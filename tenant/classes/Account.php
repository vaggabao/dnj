<?php

class Account
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var int $user_id The user's id
     */
    private $user_id = null;
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

        if (isset($_SESSION['tenant_user_id'])) {
            $this->user_id = $_SESSION['tenant_user_id'];
        }
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
    public function getAccountInfo() 
    {   
        if ($this->databaseConnection()) {
            $query_account = $this->db_connection->prepare("SELECT t.id AS tenant_id,u.email AS email, fname, lname, phone, start_date, end_date, rent_term, registration_datetime  FROM tbl_users u, tbl_tenant t WHERE u.id = :user_id AND u.id = t.user_id");
            $query_account->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
            $query_account->execute();

            $result_row = $query_account->fetchObject();
        }
        return $result_row;
    }
	
	/**
	 * Update password of tenant
	 */
    public function updatePassword($old, $new, $retype) {
        // old pass is empty
        if (empty($old)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // new pass is empty
        } elseif (empty($new)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // retype pass is empty
        } elseif (empty($retype)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // password requirement do not match
        } elseif (!preg_match("/^\w{8,16}$/", $new)) {
            $this->errors[] = ERR_PASSWORD_REQ;

        // passwords do not match
        } elseif ($new != $retype) {
            $this->errors[] = ERR_PASSWORD_NOT_MATCH;

        // if everything is fine
        } else {
            if ($this->databaseConnection()) {
                $query_select_password = $this->db_connection->prepare("SELECT password_hash FROM tbl_users WHERE id = :user_id");
                $query_select_password->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
                $query_select_password->execute();

                $result_row = $query_select_password->fetchObject();

                // if password not found
                if (!isset($result_row->password_hash)) {


                // if wrong old password                   
                } else if(!password_verify($old, $result_row->password_hash)) {
                    $this->errors[] = ERR_PASSWORD_INCORRECT;

                // old password is correct
                } else {
                    // if passwords are the same
                    if ($old == $new) {
                        $this->errors[] = ERR_PASSWORD_OLD_EQ_NEW;

                    // else
                    } else {
                        // hash password
                        $user_password = password_hash($new, PASSWORD_DEFAULT, array('cost' => '10'));
                        $query_update_password = $this->db_connection->prepare("UPDATE tbl_users SET password_hash = :user_password WHERE id = :user_id");
                        $query_update_password->bindValue(":user_password", $user_password, PDO::PARAM_STR);
                        $query_update_password->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
                        $query_update_password->execute();

                        if ($query_update_password->rowCount() == 1) {
                            $this->messages[] = MSG_PASSWORD_UPDATE_SUCCESS;
                        } else {
                            $this->errors[] = ERR_PASSWORD_UPDATE_FAILED;
                        }
                    }
                }
            } else {
                $this->errors[] = ERR_DB_ERROR;
            }
        }
    }
	
	/**
	 * Update personal information of tenant
	 */
    public function updatePersonalInfo($fname, $lname, $phone) {
        // old pass is empty
        if (empty($fname)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // new pass is empty
        } elseif (empty($lname)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // retype pass is empty
        } elseif (empty($phone)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // if everything is fine
        } else {
            if ($this->databaseConnection()) {
                $query_update_personal = $this->db_connection->prepare("UPDATE tbl_tenant SET fname = :fname, lname = :lname, phone = :phone WHERE user_id = :user_id");
                $query_update_personal->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
                $query_update_personal->bindValue(":fname", $fname, PDO::PARAM_STR);
                $query_update_personal->bindValue(":lname", $lname, PDO::PARAM_STR);
                $query_update_personal->bindValue(":phone", $phone, PDO::PARAM_STR);
                $query_update_personal->execute();

                if ($query_update_personal->rowCount() == 1) {
                    $this->messages[] = MSG_INFO_UPDATE_SUCCESS;
                } else {
                    $this->errors[] = ERR_INFO_UPDATE_FAILED;
                }
            } else {
                $this->errors[] = ERR_DB_ERROR;
            }
        }
    }
	
	/**
	 * Request extension from admin
	 */
	public function extendContract($date) {
        // extension date is empty
        if (empty($date)) {
            $this->errors[] = ERR_EXTEND_DATE_EMPTY;

        // if everything is fine
        } else {
            if ($this->databaseConnection()) {
				// get email address of tenant
				$query_get_tenant_id = $this->db_connection->prepare("SELECT email FROM tbl_tenant WHERE user_id = :user_id");
				$query_get_tenant_id->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
				$query_get_tenant_id->execute();
				$result_row = $query_get_tenant_id->fetchObject();
				$email = strtolower($result_row->email);
				
				try {
					$this->db_connection->beginTransaction();
					
					// get tenant_id & end_date
					$query_get_tenant_id = $this->db_connection->prepare("SELECT id, end_date FROM tbl_tenant WHERE user_id = :user_id");
					$query_get_tenant_id->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
					$query_get_tenant_id->execute();
					$result_row = $query_get_tenant_id->fetchObject();
					$tenant_id = $result_row->id;
					$end_date = $result_row->end_date;

					// insert to extensions
					$query_extend_extensions = $this->db_connection->prepare("INSERT INTO tbl_extension (tenant_id, before_date, extension_date) VALUES (:tenant_id, :before_date, :extension_date)");
					$query_extend_extensions->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
					$query_extend_extensions->bindValue(":before_date", $end_date, PDO::PARAM_STR);
					$query_extend_extensions->bindValue(":extension_date", $date, PDO::PARAM_STR);
					$query_extend_extensions->execute();

					// insert notification
					$name = ucwords($_SESSION['tenant_fname'] . " " . $_SESSION['tenant_lname']);
                    $description = "$name has requested an extension. Click <a href=" . LNK_ROOT . "/admin/utilities?view=2>here</a> to see the extension details.";
                    $notification_datetime = date("Y-m-d H:i:s");
                    $sql_notify = "INSERT INTO tbl_notification (description, notification_datetime) VALUES(:description, :notification_datetime)";
					$query_notify = $this->db_connection->prepare($sql_notify);
					$query_notify->bindValue(":description", $description, PDO::PARAM_STR);
					$query_notify->bindValue(":notification_datetime", $notification_datetime, PDO::PARAM_STR);
					$query_notify->execute();
					
					$this->db_connection->commit();
					
					// email landlord
					$mail_from = EMAIL_NOTIFY_FROM;
					$mail_fromname = "D&J Lancaster Home Suite";
					$mail_subject = "Extension Request";
					$mail_body = "<html><head></head>
							 <body>
							 <p>Hi Landlord,</p>
							 <br/>
							 <p>It looks like our tenant, $name, wishes to extend their stay at your home. You may see their request information by clicking <a href=" . LNK_ROOT . "/admin/utilities?view=2>here</a> or send a message to $email. Please make sure that the date they requested is still available before accepting. Thank you! :)</p>
							 <br/>
							 </body>
							 </html>
							 ";
					$mail_address = EMAIL_OWNER_ADDRESS;
					$this->sendEmail($mail_from, $mail_fromname, $mail_subject, $mail_body, $mail_address);

                    $this->messages[] = MSG_EXTEND_SUCCESS;
					return true;
					
				// rolls back if any queries above fails
				} catch (PDOException $e) {
					$this->db_connection->rollBack();
                    $this->errors[] = ERR_EXTEND_FAILED;
					return false;
                }
            } else {
                $this->errors[] = ERR_DB_ERROR;
            }
        }
	}
	
	/**
	 * Cancel extension
	 */
	public function cancelExtension($tenant_id) {
		if ($this->databaseConnection()) {
			try {
				$this->db_connection->beginTransaction();
				
				// update is_cancelled = 1
				$query_cancel_extension = $this->db_connection->prepare("UPDATE tbl_extension SET is_cancelled = 1 WHERE tenant_id = :tenant_id AND is_accepted = 0 AND is_cancelled = 0");
				$query_cancel_extension->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
				$query_cancel_extension->execute();
				
				// insert notification
				$name = ucwords($_SESSION['tenant_fname'] . " " . $_SESSION['tenant_lname']);
				$description = "$name has cancelled an extension. Click <a href=" . LNK_ROOT . "/admin/utilities?view=2>here</a> to see the extension details.";
				$recent_datetime = date("Y-m-d H:i:s");
				$sql_notify = "INSERT INTO tbl_recent (description, recent_datetime) VALUES(:description, :recent_datetime)";
				$query_notify = $this->db_connection->prepare($sql_notify);
				$query_notify->bindValue(":description", $description, PDO::PARAM_STR);
				$query_notify->bindValue(":recent_datetime", $recent_datetime, PDO::PARAM_STR);
				$query_notify->execute();
				
				$this->db_connection->commit();

				$this->messages[] = MSG_EXTEND_CANCEL_SUCCESS;
				return true;				
				
			// rolls back if any queries above fails
			} catch (PDOException $e) {
				$this->db_connection->rollBack();
				$this->errors[] = ERR_EXTEND_CANCEL_FAILED;
				return false;
			}
		}		
	}
	
	/**
	 * Request housekeeping services
	 * Insert into tbl_bills
	 * Insert into tbl_housekeeping
	 */
	public function requestHouseKeeping($tenant_id, $date) {
		// extension date is empty
        if (empty($date)) {
            $this->errors[] = ERR_HOUSEKEEPING_DATE_EMPTY;

        // if everything is fine
        } else {
            if ($this->databaseConnection()) {
				// get email address of tenant
				$query_get_tenant_id = $this->db_connection->prepare("SELECT email FROM tbl_tenant WHERE user_id = :user_id");
				$query_get_tenant_id->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
				$query_get_tenant_id->execute();
				$result_row = $query_get_tenant_id->fetchObject();
				$email = strtolower($result_row->email);
				
				try {
					$this->db_connection->beginTransaction();
					
					// set billing information
					$housekeeping_date = date("F d, Y", strtotime($_POST['housekeeping_date']));
					$billing_description = HOUSEKEEPING_DESCRIPTION . " on " . $housekeeping_date;
					$billing_amount = HOUSEKEEPING_FEE;
					$billing_status = "unpaid";
					$billing_type = "housekeeping";
					$due_date = date("Y-m-d", strtotime("-1 DAY", strtotime($housekeeping_date)));
					
					// insert billing information
					$query_housekeeping_bill = $this->db_connection->prepare("INSERT INTO tbl_bills (tenant_id, amount, description, payment_status, billing_type, due_date) VALUES (:tenant_id, :billing_amount, :billing_description, :billing_status, :billing_type, :billing_due)");
					$query_housekeeping_bill->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
					$query_housekeeping_bill->bindValue(":billing_amount", $billing_amount, PDO::PARAM_STR);
					$query_housekeeping_bill->bindValue(":billing_description", $billing_description, PDO::PARAM_STR);
					$query_housekeeping_bill->bindValue(":billing_status", $billing_status, PDO::PARAM_STR);
					$query_housekeeping_bill->bindValue(":billing_type", $billing_type, PDO::PARAM_STR);
					$query_housekeeping_bill->bindValue(":billing_due", $due_date, PDO::PARAM_STR);
					$query_housekeeping_bill->execute();
					$billing_id = $this->db_connection->lastInsertId();
					
					// insert request to table
					$query_housekeeping_request = $this->db_connection->prepare("INSERT INTO tbl_housekeeping (tenant_id, billing_id, housekeeping_date, is_paid) VALUES(:tenant_id, :billing_id, :housekeeping_date, 0)");
					$query_housekeeping_request->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
					$query_housekeeping_request->bindValue(":billing_id", $billing_id, PDO::PARAM_INT);
					$query_housekeeping_request->bindValue(":housekeeping_date", $date, PDO::PARAM_STR);
					$query_housekeeping_request->execute();
					
					// insert notification
					$name = ucwords($_SESSION['tenant_fname'] . " " . $_SESSION['tenant_lname']);
					$description = "$name has requested a cleaning service. Click <a href=" . LNK_ROOT . "/admin/utilities?view=3>here</a>.";
					$notification_datetime = date("Y-m-d H:i:s");
					$sql_notify = "INSERT INTO tbl_notification (description, notification_datetime) VALUES(:description, :notification_datetime)";
					$query_notify = $this->db_connection->prepare($sql_notify);
					$query_notify->bindValue(":description", $description, PDO::PARAM_STR);
					$query_notify->bindValue(":notification_datetime", $notification_datetime, PDO::PARAM_STR);
					$query_notify->execute();
					
					$this->db_connection->commit();
					
					// email landlord
					$mail_from = EMAIL_NOTIFY_FROM;
					$mail_fromname = "D&J Lancaster Home Suite";
					$mail_subject = "Housekeeping Request";
					$mail_body = "<html><head></head>
							 <body>
							 <p>Hi Landlord,</p>
							 <br/>
							 <p>Our tenant, $name, needs some assistance on keeping your home clean. You may see their request information by clicking <a href=" . LNK_ROOT . "/admin/utilities?view=3>here</a> or send a message to $email. Thank you! :)</p>
							 <br/>
							 </body>
							 </html>
							 ";
					$mail_address = EMAIL_OWNER_ADDRESS;
					$this->sendEmail($mail_from, $mail_fromname, $mail_subject, $mail_body, $mail_address);
					
                    $this->messages[] = MSG_HOUSEKEEPING_SUCCESS;
					return true;

				// rolls back if any queries above fails
				} catch (PDOException $e) {
					$this->db_connection->rollBack();
                    $this->errors[] = ERR_HOUSEKEEPING_FAILED;
					return false;
				}
            } else {
                $this->errors[] = ERR_DB_ERROR;
				return false;
            }
        }
	}
	
	/**
	 * Cancel housekeeping request
	 * Mark as cancelled in tbl_bills
	 * Update is_cancelled = 1 in tbl_bills
	 */
	public function cancelHousekeeping($billing_id) {
		if ($this->databaseConnection()) {
			try {
				$this->db_connection->beginTransaction();
					
				// update is_cancelled = 1 in tbl_housekeeping
				$query_cancel_housekeeping = $this->db_connection->prepare("UPDATE tbl_housekeeping SET is_cancelled = 1 WHERE billing_id = :billing_id");
				$query_cancel_housekeeping->bindValue(":billing_id", $billing_id, PDO::PARAM_INT);
				$query_cancel_housekeeping->execute();

				// update payment_status = cancelled in tbl_bills
				$query_cancel_bills = $this->db_connection->prepare("UPDATE tbl_bills SET payment_status = 'cancelled' WHERE id = :billing_id");
				$query_cancel_bills->bindValue(":billing_id", $billing_id, PDO::PARAM_INT);
				$query_cancel_bills->execute();
			
				// insert notification
				$name = ucwords($_SESSION['tenant_fname'] . " " . $_SESSION['tenant_lname']);
				$description = "$name has cancelled their cleaning request. Click <a href=" . LNK_ROOT . "/admin/utilities?view=3>here</a>.";
				$recent_datetime = date("Y-m-d H:i:s");
				$sql_notify = "INSERT INTO tbl_recent (description, recent_datetime) VALUES(:description, :recent_datetime)";
				$query_notify = $this->db_connection->prepare($sql_notify);
				$query_notify->bindValue(":description", $description, PDO::PARAM_STR);
				$query_notify->bindValue(":recent_datetime", $recent_datetime, PDO::PARAM_STR);
				$query_notify->execute();
					
				$this->db_connection->commit();
					
				$this->messages[] = MSG_HOUSEKEEPING_CANCEL_SUCCESS;
				return true;
		
			// if any queries above fails
			} catch (PDOException $e) {
				$this->db_connection->rollBack();
				$this->errors[] = ERR_HOUSEKEEPING_CANCEL_FAILED;
				return false;
			}
		} else {
			$this->errors[] = ERR_DB_ERROR;
			return false;
		}
	}
	
	/**
	 * laundry services
	 * sends a notification to the administrator
	 * sends an email to landlord
	 */
	public function requestLaundry() {
		if ($this->databaseConnection()) {
			// get email address of tenant
			$query_get_tenant_id = $this->db_connection->prepare("SELECT email FROM tbl_tenant WHERE user_id = :user_id");
			$query_get_tenant_id->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
			$query_get_tenant_id->execute();
			$result_row = $query_get_tenant_id->fetchObject();
			$email = strtolower($result_row->email);
			
			$name = ucwords($_SESSION['tenant_fname'] . " " . $_SESSION['tenant_lname']);
			$description = "$name has requested assitance regarding their laundry. Click <a href=" . LNK_ROOT . "/admin/messages?view=2>here</a> to contact your tenant immediately.";
			$notification_datetime = date("Y-m-d H:i:s");
			$sql_notify = "INSERT INTO tbl_notification (description, notification_datetime) VALUES(:description, :notification_datetime)";
			$query_notify = $this->db_connection->prepare($sql_notify);
			$query_notify->bindValue(":description", $description, PDO::PARAM_STR);
			$query_notify->bindValue(":notification_datetime", $notification_datetime, PDO::PARAM_STR);
			$query_notify->execute();
			
			$mail_from = EMAIL_NOTIFY_FROM;
			$mail_fromname = "D&J Lancaster Home Suite";
			$mail_subject = "Housekeeping Request";
			$mail_body = "<html><head></head>
					 <body>
					 <p>Hi Landlord,</p>
					 <br/>
					 <p>It seems like our tenant, $name, needs some assistance on keeping their laundry clean. Please contact them immediately by clicking <a href=" . LNK_ROOT . "/admin/messages?view=2>here</a> or send a message to $email. Thank you! :)</p>
					 <br/>
					 </body>
					 </html>
					 ";
			$mail_address = EMAIL_OWNER_ADDRESS;
			
			$this->sendEmail($mail_from, $mail_fromname, $mail_subject, $mail_body, $mail_address);
			
			$this->messages[] = MSG_LAUNDRY_SUCCESS;
		} else {
			$this->errors[] = ERR_DB_ERROR;
			return false;
		}
	}

	/**
     * sends an email to the provided email address
     * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
     */
    private function sendEmail($mail_from, $mail_fromname, $mail_subject, $mail_body, $mail_address) {
        $mail = new PHPMailer();
        // Set mailer to use SMTP
        $mail->IsSMTP();
        $mail->IsHTML();
        // $mail->SMTPDebug = 1;
        // Enable SMTP authentication
        $mail->SMTPAuth = EMAIL_SMTP_AUTH;
        // Enable encryption, usually SSL/TLS
        $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;

        // Specify host server
        $mail->Host = EMAIL_SMTP_HOST;
        $mail->Port = EMAIL_SMTP_PORT;
        $mail->Username = EMAIL_SMTP_USERNAME;
        $mail->Password = EMAIL_SMTP_PASSWORD;

        $mail->From = $mail_from;
        $mail->FromName = $mail_fromname;
        $mail->Subject = $mail_subject;
        $mail->Body = $mail_body;
        $mail->AddAddress($mail_address);

        if(!$mail->Send()) {
            $this->errors[] = MESSAGE_VERIFICATION_MAIL_NOT_SENT . $mail->ErrorInfo;
            echo $mail->ErrorInfo;
        }
    }
}
?>