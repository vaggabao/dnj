<?php

/**
 * this login system is based on Panique's php login
 * @author Sire
 * @link null
 * @link null
 * @license null
 * login for administrator
 */
class Login
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
     * @var string $user_email The user's mail
     */
    private $username = "";
    /**
     * @var boolean $user_is_logged_in The user's login status
     */
    private $user_is_logged_in = false;
    /**
     * @var boolean $user_is_tenant The user is now a tenant
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

        // if user tried to log out
        if ($_GET["action"] == "logout") {
            $this->doLogout();

        // if user has an active session on the server
        } elseif ( !empty($_SESSION['admin_username']) && ($_SESSION['admin_logged_in'] == 1) ) {
            $this->loginWithSessionData();

        // if user just submitted a login form
        } elseif (isset($_POST["login"])) {
            $this->loginWithPostData($_POST['username'], $_POST['user_password']);
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
     * Logs in with S_SESSION data.
     * Technically we are already logged in at that point of time, as the $_SESSION values already exist.
     */
    private function loginWithSessionData()
    {
        // $this->user_name = $_SESSION['user_name'];
        $this->user_id = $_SESSION['admin_id'];
        $this->username = $_SESSION['admin_username'];

        // set logged in status to true, because we just checked for this:
        // !empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)
        // when we called this method (in the constructor)
        $this->user_is_logged_in = true;
    }


    /**
     * Logs in with the data provided in $_POST, coming from the login form
     * @param $username
     * @param $user_password
     */
    private function loginWithPostData($username, $user_password)
    {
        if (empty($username) || empty($user_password)) {
            $this->errors[] = ERR_LOGIN_FAILED;

        // if POST data (from login form) contains non-empty user_name and non-empty user_password
        } else {

            if ($this->databaseConnection()) {
                // database query, getting all the info of the selected user
                $query_user = $this->db_connection->prepare('SELECT id, username, password_hash, fname, lname FROM tbl_admin WHERE username = :username');
                $query_user->bindValue(':username', trim($username), PDO::PARAM_STR);
                $query_user->execute();
                // get result row (as an object)
                $result_row = $query_user->fetchObject();
            }

            // if this user not exists
            if (!isset($result_row->id)) {
                $this->errors[] = ERR_LOGIN_FAILED;
            // using PHP 5.5's password_verify() function to check if the provided passwords fits to the hash of that user's password
            } else if (password_verify($user_password, $result_row->password_hash)) {
                // write user data into PHP SESSION [a file on your server]
                $_SESSION['admin_id'] = $result_row->id;
                $_SESSION['admin_username'] = $result_row->username;
                $_SESSION['admin_fname'] = $result_row->fname;
                $_SESSION['admin_lname'] = $result_row->lname;
                $_SESSION['admin_logged_in'] = 1;

                // declare user id, set the login status to true
                $this->user_id = $result_row->id;
                $this->username = $result_row->username;
                $this->user_is_logged_in = true;

                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                $this->errors[] = ERR_LOGIN_FAILED;
            }
        }
    }


    /**
     * Get administrator information
     */
    public function getInfo() {
        if ($this->databaseConnection()) {
            $sql = "SELECT * FROM tbl_admin WHERE id = :user_id";
            $query_get = $this->db_connection->prepare($sql);
            $query_get->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
            $query_get->execute();
            $result_row = $query_get->fetchObject();

            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }

    }


    /**
     * Update administrator information
     */
    public function saveInfo($fname, $lname, $username) {

        // old pass is empty
        if (empty($fname)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // new pass is empty
        } elseif (empty($lname)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // retype pass is empty
        } elseif (empty($username)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        } else {
            if ($this->databaseConnection()) {
                $sql = "UPDATE tbl_admin SET fname = :fname, lname = :lname, username = :username WHERE id = :user_id";
                $query_save = $this->db_connection->prepare($sql);
                $query_save->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
                $query_save->bindValue(":fname", $fname, PDO::PARAM_INT);
                $query_save->bindValue(":lname", $lname, PDO::PARAM_INT);
                $query_save->bindValue(":username", $username, PDO::PARAM_INT);
                $query_save->execute();

                if ($query_save->rowCount() == 1) {
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
     * Update password
     */
    public function updatePassword($current, $new, $repeat) {
        // old pass is empty
        if (empty($current)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // new pass is empty
        } elseif (empty($new)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // retype pass is empty
        } elseif (empty($repeat)) {
            $this->errors[] = ERR_FIELDS_EMPTY;

        // password requirement do not match
        } elseif (!preg_match("/^\w{8,16}$/", $new)) {
            $this->errors[] = ERR_PASSWORD_REQ;

        // passwords do not match
        } elseif ($new != $repeat) {
            $this->errors[] = ERR_PASSWORD_NOT_MATCH;

        // if everything is fine
        } else {
            if ($this->databaseConnection()) {
                $query_select_password = $this->db_connection->prepare("SELECT password_hash FROM tbl_admin WHERE id = :user_id");
                $query_select_password->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
                $query_select_password->execute();

                $result_row = $query_select_password->fetchObject();

                // if password not found
                if (!isset($result_row->password_hash)) {

                // if wrong old password                   
                } else if (!password_verify($current, $result_row->password_hash)) {
                    $this->errors[] = ERR_PASSWORD_INCORRECT;

                // old password is correct
                } else if (password_verify($current, $result_row->password_hash) == 1) {
                    // if passwords are the same
                    if ($current == $new) {
                        $this->errors[] = ERR_PASSWORD_OLD_EQ_NEW;

                    // else
                    } else {
                        // hash password
                        $user_password = password_hash($new, PASSWORD_DEFAULT, array('cost' => '10'));
                        $query_update_password = $this->db_connection->prepare("UPDATE tbl_admin SET password_hash = :user_password WHERE id = :user_id");
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
     * Perform the logout, resetting the session
     */
    public function doLogout()
    {
        $_SESSION = array();
        session_destroy();

        $this->user_is_logged_in = false;
        $this->messages[] = MESSAGE_LOGGED_OUT;

        header("Location: " . LNK_ROOT . "/admin");
        exit();
    }

    /**
     * Simply return the current state of the user's login
     * @return bool user's login status
     */
    public function isUserLoggedIn()
    {
        return $this->user_is_logged_in;
    }
}
?>