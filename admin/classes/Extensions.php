<?php

/**
 * handles methods for managing extensions
 * @author Sire
 * @link null
 * @link null
 * @license null
 */
class Extension
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
    public function getExtensions($criteria, $search) 
    {
        if ($this->databaseConnection()) {
			if ($criteria == 0) {
				// all extensions
                $sql = "SELECT e.id AS id, e.extension_date AS extension_date, e.is_accepted AS is_accepted, e.is_cancelled AS is_cancelled, t.fname AS fname, t.lname AS lname, t.start_date AS start_date, e.before_date AS end_date FROM tbl_extension e, tbl_tenant t WHERE e.tenant_id = t.id";
			} else if ($criteria == 1) {
				// new requests
                $sql = "SELECT e.id AS id, e.extension_date AS extension_date, e.is_accepted AS is_accepted, e.is_cancelled AS is_cancelled, t.fname AS fname, t.lname AS lname, t.start_date AS start_date, e.before_date AS end_date FROM tbl_extension e, tbl_tenant t WHERE e.tenant_id = t.id AND e.is_cancelled = 0 AND e.is_accepted = 0";
			} else if ($criteria == 2) {
				// accepted extensions
                $sql = "SELECT e.id AS id, e.extension_date AS extension_date, e.is_accepted AS is_accepted, e.is_cancelled AS is_cancelled, t.fname AS fname, t.lname AS lname, t.start_date AS start_date, e.before_date AS end_date FROM tbl_extension e, tbl_tenant t WHERE e.tenant_id = t.id AND e.is_accepted = 1";
			} else if ($criteria == 3) {
				// rejected extensions
                $sql = "SELECT e.id AS id, e.extension_date AS extension_date, e.is_accepted AS is_accepted, e.is_cancelled AS is_cancelled, t.fname AS fname, t.lname AS lname, t.start_date AS start_date, e.before_date AS end_date FROM tbl_extension e, tbl_tenant t WHERE e.tenant_id = t.id AND e.is_cancelled = 1";
			}
			

            if ($search != "") {
                $query_search = " AND CONCAT(t.fname, ' ', t.lname) LIKE :search ORDER BY e.id DESC";
            } else {
                $query_search = " ORDER BY e.id DESC";
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
     * Accept extension request
     */
    public function acceptExtension($extension_id) {
        if ($this->databaseConnection()) {
            // get tenant_id
            $query_get_tenant = $this->db_connection->prepare("SELECT tenant_id FROM tbl_extension WHERE id = :extension_id");
            $query_get_tenant->bindValue(":extension_id", $extension_id, PDO::PARAM_INT);
            $query_get_tenant->execute();
            $result_row = $query_get_tenant->fetchObject();
            $tenant_id = $result_row->tenant_id;

            // get extension_date requested
            $query_get_requested = $this->db_connection->prepare("SELECT extension_date FROM tbl_extension WHERE id = :extension_id");
            $query_get_requested->bindValue(":extension_id", $extension_id, PDO::PARAM_INT);
            $query_get_requested->execute();
            $result_row = $query_get_requested->fetchObject();
            $requested_date = $result_row->extension_date;
			
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

            // get diff of current dates
            $current_interval = $this->getDateDiff($start_date, $end_date);
            $current_months = $current_interval[0];
            $current_days = $current_interval[1];

            // get diff of extension dates
            $requested_interval = $this->getDateDiff($end_date, $requested_date);
            $requested_months = $requested_interval[0];
            $requested_days = $requested_interval[1];

            $total_months = $current_months + $requested_months;
            $total_days = $current_days + $requested_days;

            try {
                // start transaction
                $this->db_connection->beginTransaction();
                
                // update extension is_accepted = 1
                $query_accept_ext = $this->db_connection->prepare("UPDATE tbl_extension SET is_accepted = 1 WHERE id = :extension_id");
                $query_accept_ext->bindValue(":extension_id", $extension_id, PDO::PARAM_INT);
                $query_accept_ext->execute();

                // update tenant's end_date and rent_term
                if ( $total_months > 0 || $total_days >= 30 ) {
                    $sql = "UPDATE tbl_tenant SET end_date = :requested_date, rent_term = 'long' WHERE id = :tenant_id";
                } else {
                    $sql = "UPDATE tbl_tenant SET end_date = :requested_date WHERE id = :tenant_id";
                }
                $query_update_tenant = $this->db_connection->prepare($sql);
                $query_update_tenant->bindValue(":requested_date", $requested_date, PDO::PARAM_STR);
                $query_update_tenant->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_update_tenant->execute();

                // update calendar
                $query_update_calendar = $this->db_connection->prepare("UPDATE tbl_calendar SET end_date = :requested_date WHERE id = :tenant_id");
                $query_update_calendar->bindValue(":requested_date", $requested_date, PDO::PARAM_STR);
                $query_update_calendar->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_update_calendar->execute();


                // set billing period for date extensions
                $this->setExtensionBills($tenant_id, $end_date, $current_months, $current_days, $requested_months, $requested_days, $rent_fee);

                $this->db_connection->commit();

                $this->messages[] = MSG_EXTENSION_ACCEPT_SUCCESS;
            } catch (PDOException $e) {
                $this->db_connection->rollBack();

                $this->errors[] = ERR_EXTENSION_ACCEPT_FAILED;
                return false;
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }


    /**
     * Set billing
     */
    private function setExtensionBills($tenant_id, $start_ext, $current_months, $current_days, $requested_months, $requested_days, $rent_fee) {
        if ($this->databaseConnection()) {
            // set data for billing period
            $date = strtotime($start_ext);
            $addInterval = "+1 MONTH";

            // insert monthly billing period if extension is more than 1 month
            for ($i = 1; $i <= $requested_months; $i++) {
                $billing_due = date("Y-m-d", strtotime("-1 DAY", $date));
                $billing_start_date = $date;
                $date = strtotime($addInterval, $date);
                $billing_end_date = $date;
                $billing_type = "rent";

                $billing_description = "Extension: Month " . $i . " (" . date("F d, Y", $billing_start_date) . " to " . date("F d, Y", $billing_end_date) . ")";
                $billing_status = "unpaid";
				
				if ($i + $current_months >= 6) {
					$association_fee = ASSOCIATION_FEE;
				} else {
					$association_fee = 0;
				}
                $reservation_refund = 0;

                $billing_amount = $rent_fee + $association_fee - $reservation_refund;

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
				
				$description = "Rent Fee";
				$amount = $rent_fee;					
				$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
				$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
				$query_insert_description->execute();
				
                // association dues if stay is more than 6 months
                if ($months >= 6) {
	                $amount = ASSOCIATION_FEE;
                } else {
	                $amount = 0;
                }

				$description = "Association Dues";			
				$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
				$query_insert_description->bindValue(':amount', ASSOCIATION_FEE, PDO::PARAM_STR);
				$query_insert_description->execute();
            }

            // insert billing period for days of extension
            if ($requested_days > 0) {
                $total_days = $current_days + $requested_days;
                $addInterval = "+" . $requested_days . " DAY";
                $billing_due = date("Y-m-d", strtotime("-1 DAY", $date));
                $billing_start_date = $date;
                $date = strtotime($addInterval, $date);
                $billing_end_date = $date;

                $billing_description = "Extension: " . ($requested_days) . " night(s) (" . date("F d, Y", $billing_start_date) . " to " . date("F d, Y", $billing_end_date) . ")";

                // check if short term or long term
                if ( ($current_months + $requested_months) > 0 || $total_days >= 30 ) {
                    // if short term days + days of extension is 1 month or above 1 month
                    if ($total_days >= 30) {
                        $rent_fee = (RENT_FEE/30) * ($requested_days);
                        $association_fee = 0;

                    // if already long term and have days
                    } else {
						echo $rent_fee;
                        $rent_fee = ($rent_fee/30) * ($requested_days);
                        $association_fee = 0;
                    }
                } else {
                    if ($total_days >= 7) {
                        $rent_fee = SHORT_NO_BILLS_FEE * ($requested_days);
                        $association_fee = 0;
                    } else {
                        $rent_fee = SHORT_WITH_BILLS_FEE * ($requested_days);
                        $association_fee = 0;
                    }
                }

                $billing_amount = $rent_fee + $association_fee;
                $billing_status = "unpaid";
                
                // insert remaining days billing period
                $sql = "INSERT INTO tbl_bills (tenant_id, amount, description, payment_status, due_date) VALUES(:tenant_id, :billing_amount, :billing_description, :billing_status, :billing_due)";
                $query_insert_bills = $this->db_connection->prepare($sql);
                $query_insert_bills->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_insert_bills->bindValue(":billing_amount", $billing_amount, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_description", $billing_description, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_status", $billing_status, PDO::PARAM_STR);
                $query_insert_bills->bindValue(":billing_due", $billing_due, PDO::PARAM_STR);
                $query_insert_bills->execute();
				
				
				$billing_id = $this->db_connection->lastInsertId();
				
				$sql = "INSERT INTO tbl_billing_description (id, billing_id, description, amount) VALUES(null, :billing_id, :description, :amount)";
				$query_insert_description = $this->db_connection->prepare($sql);
				$query_insert_description->bindValue(':billing_id', $billing_id, PDO::PARAM_INT);	
				
                // check if short term or long term
                if ( ($current_months + $requested_months) > 0 || $total_days >= 30 ) {
                    // if short term days + days of extension is 1 month or above 1 month
                    if ($total_days >= 30) {						
						$description = "Extension: &#8369;" . round((RENT_FEE/30), 2) . " per night ($requested_days night/s)";
						$amount = (RENT_FEE/30) * ($requested_days);
						$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
						$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
						$query_insert_description->execute();
						
						$description = "Association Dues";
						$amount = 0;
						$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
						$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
						$query_insert_description->execute();

                    // if already long term and have days
                    } else {
						$description = "Extension: &#8369;" . round($rent_fee/$requested_days, 2) . " per night ($requested_days night/s)";
						$amount = $rent_fee;
						$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
						$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
						$query_insert_description->execute();
                    }
                } else {
                    if ($total_days >= 7) {
						$description = "Extension: &#8369;" . SHORT_NO_BILLS_FEE . " per night ($days nights)";
						$amount = SHORT_NO_BILLS_FEE * $requested_days;
						$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
						$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
						$query_insert_description->execute();
                    } else {
						$description = "Extension: &#8369;" . SHORT_WITH_BILLS_FEE . " per night ($days nights)";
						$amount = SHORT_WITH_BILLS_FEE * $requested_days;
						$query_insert_description->bindValue(':description', $description, PDO::PARAM_STR);
						$query_insert_description->bindValue(':amount', $amount, PDO::PARAM_STR);
						$query_insert_description->execute();
                    }
                }
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }


    /**
     * Cancel extension request
     */
    public function cancelExtension($extension_id) {
        if ($this->databaseConnection()) {
            // cancel extensions
            $query_cancel_ext = $this->db_connection->prepare("UPDATE tbl_extension SET is_cancelled = 1 WHERE id = :extension_id");
            $query_cancel_ext->bindValue(":extension_id", $extension_id, PDO::PARAM_INT);
            $query_cancel_ext->execute();

            if ($query_cancel_ext->rowCount() > 0) {
                $this->messages[] = MSG_EXTENSION_CANCEL_SUCCESS;
            } else {
                $this->errors[] = ERR_EXTENSION_CANCEL_FAILED;
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

        // $date = date("Y-m-d", $min_date) . "<br>";
        // echo $date;

        $min_date = min($d1, $d2);
        $min_date = strtotime("+" . $i . " MONTH", $min_date);
        $diff = ($max_date - $min_date)/(24*60*60);
        
        $interval = array($i, $diff);

        return $interval;
    }
}
?>