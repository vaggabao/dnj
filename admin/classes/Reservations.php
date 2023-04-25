<?php

/**
 * handles methods for managing reservations
 * @author Sire
 * @link null
 * @link null
 * @license null
 */
class Reservation
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session
        session_start();
    }

    /**
     * Checks if database connection is opened. If not, then this method tries to open it.
     * @return bool Success status of the database connecting process
     */
    private function databaseConnection()
    {
        // if connection already exists
        if ($this->db_connection != null) {
            return true;
        } else {
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                return true;
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR . $e->getMessage();
            }
        }
        // default return
        return false;
    }

    /**
     * Search into database for the transactions of user_id specified
     */
    public function getReservations($search) 
    {
        if ($this->databaseConnection()) {

            $sql = "SELECT * FROM tbl_tenant WHERE is_reserved = 1 AND is_registered = 0";

            if ($search != "") {
                $query_search = " AND CONCAT(fname, ' ', lname) LIKE :search ORDER BY id DESC";
            } else {
                $query_search = " ORDER BY id DESC";
            }
            $sql .= $query_search;

            $query_tenant = $this->db_connection->prepare($sql);

            if ($search != "") {
                $query_tenant->bindValue(":search", "%".$search."%", PDO::PARAM_STR);
            }

            $query_tenant->execute();

            $result_row = $query_tenant->fetchAll();
            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Confirm reservation
     */
    public function confirmReservation($tenant_id, $rent_fee) {
        if ($this->databaseConnection()) {;
            try {
                // start transaction
                $this->db_connection->beginTransaction();

                // update tenant info
                $sql = "UPDATE tbl_tenant SET rent_fee = :rent_fee, is_reserved = 2 WHERE id = :tenant_id";
                $query_confirm = $this->db_connection->prepare($sql);
                $query_confirm->bindValue(":rent_fee", $rent_fee, PDO::PARAM_STR);
                $query_confirm->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_confirm->execute();

                // get tenant info
                $query_get_date = $this->db_connection->prepare("SELECT * FROM tbl_tenant WHERE id = :tenant_id");
                $query_get_date->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_get_date->execute();
                $result_row = $query_get_date->fetchObject();
                $fname = $result_row->fname;
                $email = $result_row->email;
                $phone = $result_row->phone;
                $rent_fee = $result_row->rent_fee;
                $start_date = $result_row->start_date;
                $end_date = $result_row->end_date;
                $token = $result_row->token;

                // set billing period for date extensions
                $this->setReservationBills($tenant_id, $start_date, $end_date, $rent_fee);

                $this->db_connection->commit();

                // email customer for tenant registration                    
                $name = ucwords(strtolower($fname));
                $phone = $phone;
                $start_date = date("F d, Y", strtotime($start_date));
                $end_date =  date("F d, Y", strtotime($end_date));

                $mail_content = "<html><head></head>
                         <body>
                         <h3>Good day $name!</h3>
                         <br/>
                         <p>Your reservation on $start_date to $end_date has been successfully accommodated. You may now register a new account to access our dashboard and monitor your payments and transactions. Click the link below to register.</p>
                         <p><a href='" . LNK_ROOT . "/tenant/registration/reg-code=$token'>" . LNK_ROOT . "/tenant/registration/reg-code=$token</a></p>
                         <br/>
                         <p>Thank you for booking your stay with us.</p>
                         <br/>
                         <br/>
                         <p>Regards,</p>
                         <p><a href='" . LNK_ROOT . "'>D&J Lancaster Home Suite</a></p>
                         <br/>
                         <br/>
                         <hr/>
                         <p>This message is an automated email. If you think this is incorrect, email us at administrator@dnjlancasterhomesuite.com. Thank you!</p>
                         </body>
                         </html>
                ";

                $this->sendNotificationEmail($email, $mail_content);

                $this->messages[] = MSG_RESERVE_CONFIRM_SUCCESS;
            } catch (PDOException $e) {
                $this->db_connection->rollBack();

                $this->errors[] = ERR_RESERVE_CONFIRM_FAILED;
                return false;
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Set billing
     */
    private function setReservationBills($tenant_id, $start_date, $end_date, $rent_fee) {
        if ($this->databaseConnection()) {
            // get date diff of dates
            $interval = $this->getDateDiff($start_date, $end_date);
            $months = $interval[0];
            $days = $interval[1];

            // set data for billing period
            $date = strtotime($start_date);
            $addInterval = "+1 MONTH";

            // insert monthly billing period if long term
            for ($i = 1; $i <= $months; $i++) {
                $billing_due = date("Y-m-d", strtotime("-1 DAY", $date));
                $billing_start_date = $date;
                $date = strtotime($addInterval, $date);
                $billing_end_date = $date;
                $billing_status = "unpaid";
                $billing_type = "rent";
                $billing_rent = $rent_fee;

                // association dues
                if ($months >= 6) {
                	$association_fee = ASSOCIATION_FEE;
                } else {
                	$association_fee = 0;
                }
                
                if ($i == 1) {
                    $billing_description = "One Month Advance, One Month Deposit";
                    $billing_type = "verification";
                    $billing_rent = $rent_fee * 2;
                    $reservation_refund = 0;
                } else if ($i == 2) {
                    $billing_description = "Month " . $i . " (" . date("F d, Y", $billing_start_date) . " to " . date("F d, Y", $billing_end_date) . ")";
                    $reservation_refund = LONG_TERM_FEE;
                } else {
                    $billing_description = "Month " . $i . " (" . date("F d, Y", $billing_start_date) . " to " . date("F d, Y", $billing_end_date) . ")";
                    $reservation_refund = 0;
                }

                $billing_amount = $billing_rent + $association_fee - $reservation_refund;

                // insert monthly billing period
                $sql = "INSERT INTO tbl_bills (tenant_id, amount, description, payment_status, due_date, billing_type) VALUES(:tenant_id, :billing_amount, :billing_description, :billing_status, :billing_due, :billing_type)";
                $query_insert_bills = $this->db_connection->prepare($sql);
                $query_insert_bills->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_insert_bills->bindValue(":billing_amount", $billing_amount, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_description", $billing_description, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_status", $billing_status, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_due", $billing_due, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_type", $billing_type, PDO::PARAM_STR);
                $query_insert_bills->execute();
				
				
				// insert each billing details
				$billing_id = $this->db_connection->lastInsertId();
				
				$sql = "INSERT INTO tbl_billing_description (id, billing_id, description, amount) VALUES(null, :billing_id, :description, :amount)";
				$query_insert_description = $this->db_connection->prepare($sql);
				$query_insert_description->bindValue(':billing_id', $billing_id, PDO::PARAM_INT);
				
				// rent fee
                if ($i == 1) {
                    $description = "One Month Advance";
                    $amount = $rent_fee;					
					$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
					$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
					$query_insert_description->execute();
					
                    $description = "One Month Deposit";
                    $amount = $rent_fee;					
					$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
					$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
					$query_insert_description->execute();
                } else {
                    $description = "Rent Fee";
                    $amount = $rent_fee;					
					$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
					$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
					$query_insert_description->execute();
                }

                // association dues if stay is more than 6 months
                if ($months >= 6) {
	                $amount = ASSOCIATION_FEE;
                } else {
	                $amount = 0;
                }

                $description = "Association Dues";
				$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
				$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
				$query_insert_description->execute();

                // refund on 2nd month
                if ($i == 2) {
                    $description = "Reservation Fee(Refund)";
                    $amount = $rent_fee;					
					$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
					$query_insert_description->bindValue(':amount', LONG_TERM_FEE, PDO::PARAM_STR);
					$query_insert_description->execute();
                }
            }

            // for short term and long term billing period for days
            if ($days > 0) {
                // insert data for remaining days billing period
                $addInterval = "+" . $days . " DAY";
                $billing_due = date("Y-m-d", strtotime("-1 DAY", $date));
                $billing_start_date = $date;
                $date = strtotime($addInterval, $date);
                $billing_end_date = $date;

                $billing_description = $days . " nights (" . date("F d, Y", $billing_start_date) . " to " . date("F d, Y", $billing_end_date) . ")";
                $billing_status = "unpaid";
                $billing_type = "rent";
                
				// if long term
                if ($months > 0) {
                    $billing_amount = ($rent_fee/30) * ($days);
					
				// if short term
                } else {
                    $billing_type = "verification";
					$billing_amount = $rent_fee;
                    // if ($days <= 6) {
                        // $billing_amount = SHORT_WITH_BILLS_FEE * ($days);
                    // } else {
                        // if ($days <= 21) {
                            // $billing_amount = SHORT_NO_BILLS_FEE * ($days);
                        // } else {
                            // $billing_amount = $rent_fee;
                        // }
                    // }
					
					// deduct reservation refund on amount
					$billing_amount = $billing_amount + DEPOSIT_FEE - SHORT_TERM_FEE;
                }
				
                // insert remaining days billing period
                $sql = "INSERT INTO tbl_bills (tenant_id, amount, description, payment_status, due_date, billing_type) VALUES(:tenant_id, :billing_amount, :billing_description, :billing_status, :billing_due, :billing_type)";
                $query_insert_bills = $this->db_connection->prepare($sql);
                $query_insert_bills->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_insert_bills->bindValue(":billing_amount", $billing_amount, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_description", $billing_description, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_status", $billing_status, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_due", $billing_due, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_type", $billing_type, PDO::PARAM_STR);
                $query_insert_bills->execute();
				
				
				// insert each billing details
				$billing_id = $this->db_connection->lastInsertId();				
				
				$sql = "INSERT INTO tbl_billing_description (id, billing_id, description, amount) VALUES(null, :billing_id, :description, :amount)";
				$query_insert_description = $this->db_connection->prepare($sql);
				$query_insert_description->bindValue(':billing_id', $billing_id, PDO::PARAM_INT);
                if ($months > 0) {
                    $description = "Long Term: &#8369;" . round(($rent_fee/30), 2) . " per night ($days night/s)";
                    $amount = ($rent_fee/30) * ($days);
					$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
					$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
					$query_insert_description->execute();
                } else {
                    $billing_type = "verification";
                    // if ($days <= 6) {
						// $description = "Short Term(2 to 6 Nights): &#8369;" . SHORT_WITH_BILLS_FEE . " per night ($days nights)";
						// $amount = SHORT_WITH_BILLS_FEE * $days;
						// $query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
						// $query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
						// $query_insert_description->execute();
                    // } else {
                        // if ($days <= 21) {
							// $description = "Short Term(7 to 21 Nights): &#8369;" . SHORT_NO_BILLS_FEE . " per night ($days nights)";
							// $amount = SHORT_NO_BILLS_FEE * $days;
							// $query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
							// $query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
							// $query_insert_description->execute();
                        // } else {
							// $description = "Short Term(21 or more Nights)";
							// $amount = $rent_fee;
							// $query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
							// $query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
							// $query_insert_description->execute();
                        // }
                    // }
					
					if ($days <= 6) {
						$description = "Short Term(2 to 6 Nights): &#8369;" . round($rent_fee/$days, 3) . " per night ($days nights)";
                    } else {
                        if ($days <= 21) {
							$description = "Short Term(7 to 21 Nights): &#8369;" . round($rent_fee/$days, 3) . " per night ($days nights)";
                        } else {
							$description = "Short Term(21 or more Nights)";
                        }
                    }
					
					$amount = $rent_fee;
					$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
					$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
					$query_insert_description->execute();
					
					$description = "Short Term: Deposit Fee";
					$amount = DEPOSIT_FEE;
					$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
					$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
					$query_insert_description->execute();
					
                    $description = "Reservation Fee(Refund)";
					$amount = SHORT_TERM_FEE;
					$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
					$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
					$query_insert_description->execute();
                }
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    
    /*
     * Get diff between dates
     */
    private function getDateDiff($date1, $date2) {
        $d1 = strtotime($date1);
        $d2 = strtotime($date2);
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $i = 0;

        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $date = date("Y-m-d", $min_date);
            $i++;
        }

        $min_date = min($d1, $d2);
        $min_date = strtotime("+" . $i . " MONTH", $min_date);
        $diff = ($max_date - $min_date)/(24*60*60);
        
        $interval = array($i, $diff);

        return $interval;
    }


    /**
     * Send email to tenant
     */
    private function sendNotificationEmail($email, $mail_content) {
        $mail = new PHPMailer();
        // Set mailer to use SMTP
        $mail->IsSMTP();
        $mail->IsHTML();
        //useful for debugging, shows full SMTP errors
        // $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        // Enable SMTP authentication
        $mail->SMTPAuth = EMAIL_SMTP_AUTH;
        // Enable encryption, usually SSL/TLS
        $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;

        // Specify host server
        $mail->Host = EMAIL_SMTP_HOST;
        $mail->Port = EMAIL_SMTP_PORT;
        $mail->Username = EMAIL_SMTP_USERNAME;
        $mail->Password = EMAIL_SMTP_PASSWORD;

        $mail->From = EMAIL_RESERVE_FROM;
        $mail->FromName = EMAIL_RESERVE_FROM_NAME;
        $mail->Subject = EMAIL_RESERVE_SUBJECT;
        $mail->Body = $mail_content;
        $mail->AddAddress($email);

        if(!$mail->Send()) {
            echo $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }
}
?>