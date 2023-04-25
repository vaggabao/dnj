<?php

class Registration
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection            = null;
    /**
     * @var bool success state of registration
     */
    public  $registration_successful  = false;
    /**
     * @var array collection of error messages
     */
    public  $errors                   = array();
    /**
     * @var array collection of success / neutral messages
     */
    public  $messages                 = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        session_start();
        // if we have such a POST request, call the registerNewUser() method
        if (isset($_POST["register"])) {
            $this->registerNewUser($_POST['email'], $_POST['password'], $_POST['confirm'], $_POST['fname'], $_POST['lname'], $_POST['phone'], $_POST['k']);
        // if we have such a GET request, call the verifyNewUser() method
        }
    }

    /**
     * Checks if database connection is opened and open it if not
     */
    private function databaseConnection()
    {
        // connection already opened
        if ($this->db_connection != null) {
            return true;
        } else {
            // create a database connection, using the constants from config/config.php
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                return true;
            // If an error is catched, database connection failed
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR;
                return false;
            }
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     */
    private function registerNewUser($user_email, $user_password, $user_password_repeat, $user_fname, $user_lname, $user_phone, $user_token)
    {
        // we just remove extra space on username and email
        $user_email = trim($user_email);

        // if fields are empty
        if ( empty($user_password) || empty($user_password_repeat) || empty($user_fname) || empty($user_lname) || empty($user_phone) ) {
            $this->errors[] = ERR_REGISTER_FIELDS_EMPTY;

        // if passwords do not match
        } elseif ( !preg_match("/[a-zA-Z0-9]{6,15}$/", $user_password) ) {
			echo "asdas";
            $this->errors[] = ERR_PASSWORD_REQ;

        // if passwords do not match
        } elseif ( $user_password && $user_password_repeat && $user_password != $user_password_repeat ) {
            $this->errors[] = ERR_REGISTER_PASSWORDS_NOT_MATCH;

        // if all is well
        } else {
            if ($this->databaseConnection()) {
                // get token info
                $token_valid = $this->checkToken($user_token);

                // if token is valid
                if ($token_valid) {
                    // set some field value
                    $user_registration_ip = $_SERVER['REMOTE_ADDR'];
                    $user_registration_datetime = date("Y-m-d H:i:s");

                    // hash password
                    $password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => '10'));

                    // insert new user
                    $query_new_user_insert = $this->db_connection->prepare('INSERT INTO tbl_users (email, password_hash, registration_ip, registration_datetime) VALUES(:user_email, :password_hash, :user_registration_ip, :user_registration_datetime)');
                    $query_new_user_insert->bindValue(':user_email', $user_email, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(':user_registration_ip', $user_registration_ip, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(':user_registration_datetime', $user_registration_datetime, PDO::PARAM_STR);
                    $query_new_user_insert->execute();
                    $user_id = $this->db_connection->lastInsertId();

                    // update tenant info
                    $query_update_tenant = $this->db_connection->prepare('UPDATE tbl_tenant SET user_id=:user_id, fname=:user_fname, lname=:user_lname, phone=:user_phone, token = "", is_registered = 1 WHERE token=:user_token');
                    $query_update_tenant->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                    $query_update_tenant->bindValue(':user_fname', $user_fname, PDO::PARAM_STR);
                    $query_update_tenant->bindValue(':user_lname', $user_lname, PDO::PARAM_STR);
                    $query_update_tenant->bindValue(':user_phone', $user_phone, PDO::PARAM_STR);
                    $query_update_tenant->bindValue(':user_token', $user_token, PDO::PARAM_STR);
                    $query_update_tenant->execute();

                    // insert recent activity
                    date_default_timezone_set("Asia/Manila");
                    $name = ucwords(strtolower($user_fname . " " . $user_lname));
                    $description = $name . " is now registered.";
                    $recent_datetime = date("Y-m-d H:i:s");
                    $query_recent = $this->db_connection->prepare("INSERT INTO tbl_recent (description, recent_datetime) VALUES(:description, :recent_datetime)");
                    $query_recent->bindValue(":description", $description, PDO::PARAM_STR);
                    $query_recent->bindValue(":recent_datetime", $recent_datetime, PDO::PARAM_STR);
                    $query_recent->execute();

                    $this->sendNotificationEmail($user_email, $user_id, $user_password);

                    $this->registration_successful = true;
                    $this->messages[] = MSG_REGISTER_SUCCESS;

                // if token is invalid
                } else {
                    $this->errors[] = ERR_REGISTER_TOKEN_INVALID;
                }
            } else {
                $this->errors[] = ERR_DB_ERROR;
            }
        }

        
    }

    /*
     * sends an email to the provided email address
     * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
     */
    public function sendNotificationEmail($user_email, $user_id, $user_password)
    {
        $query_get_user = $this->db_connection->prepare("SELECT start_date, end_date, fname, lname, registration_datetime, phone FROM tbl_tenant t, tbl_users u WHERE u.id = t.user_id AND u.id = :user_id");
        $query_get_user->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $query_get_user->execute();

        $result_row = $query_get_user->fetchObject();

        $name = ucwords(strtolower($result_row->fname)) . " " . ucwords(strtolower($result_row->lname));
        $phone = $result_row->phone;
        $registration_date = date("F d, Y H:i:s A", strtotime($result_row->registration_datetime));
        $start_date = date("F d, Y", strtotime($result_row->start_date));
        $end_date =  date("F d, Y", strtotime($result_row->end_date));

        $mail_content = "<html><head></head>
                 <body>
                 <h3>Welcome to D&J Home!</h3>
                 <br/>
                 <p>You have successfully registered your new account. You may now log in your account by visiting this link <a href='http://dnjlancasterhomesuite.com/tenant/dashboard'>Dashboard | D&J Home</a></p>
                 <br/>
                 <h3>Here are your account information</h3>
                 <p>
                 <br />Dates of Stay: $start_date to $end_date
                 <br />Email Address / Username: $user_email
                 <br />Password: $user_password
                 <br />Name: $name
                 <br />Phone: $phone
                 <br />Registration Date: $registration_date
                 </p>
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
                 
        $mail = new PHPMailer();
        // Set mailer to use SMTP
        $mail->IsSMTP();
        $mail->IsHTML();
        //useful for debugging, shows full SMTP errors
        //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        // Enable SMTP authentication
        $mail->SMTPAuth = EMAIL_SMTP_AUTH;
        // Enable encryption, usually SSL/TLS
        $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;

        // Specify host server
        $mail->Host = EMAIL_SMTP_HOST;
        $mail->Port = EMAIL_SMTP_PORT;
        $mail->Username = EMAIL_SMTP_USERNAME;
        $mail->Password = EMAIL_SMTP_PASSWORD;

        $mail->From = EMAIL_NOTIFY_FROM;
        $mail->FromName = EMAIL_NOTIFY_FROM_NAME;
        $mail->Subject = EMAIL_NOTIFY_SUBJECT;
        $mail->Body = $mail_content;
        $mail->AddAddress($user_email);

        if(!$mail->Send()) {
            $this->errors[] = MESSAGE_VERIFICATION_MAIL_NOT_SENT . $mail->ErrorInfo;
            echo $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    /**
     * Check provided registration token
     */
    public function checkToken($token) {
        if ($this->databaseConnection()) {
            // check if token is valid
            $query_check_token = $this->db_connection->prepare("SELECT * FROM tbl_tenant WHERE token = :token AND is_registered = 0 AND is_reserved = 2");
            $query_check_token->bindValue(":token", $token, PDO::PARAM_STR);
            $query_check_token->execute();
            $result_row = $query_check_token->fetchObject();

            if ($result_row) {
                return true;
            } else {
                return false;
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;
            return false;
        }
    }
}
