<?php

/**
 * this login system is based on Panique's php login
 * @author Sire
 * @link null
 * @link null
 * @license null
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
    private $user_email = "";
    /**
     * @var boolean $user_is_logged_in The user's login status
     */
    private $user_is_logged_in = false;
    /**
     * @var boolean $user_is_verified The user is now a tenant
     */
    private $user_is_verified = false;
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
        $this->expireSession();

        // if user tried to log out
        if ($_GET["action"] == "logout") {
            $this->doLogout();

        // if user has an active session on the server
        } elseif ( isset($_SESSION['tenant_email']) && ($_SESSION['tenant_logged_in'] == 1) ) {
            $this->loginWithSessionData();

        // if user just submitted a login form
        } elseif (isset($_POST["login"])) {
            $this->loginWithPostData($_POST['user_email'], $_POST['user_password']);
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
     * Log in with $_SESSION data.
     * Technically we are already logged in at that point of time, as the $_SESSION values already exist.
     */
    private function loginWithSessionData()
    {
        $this->user_id = $_SESSION['tenant_user_id'];
        $this->user_email = $_SESSION['tenant_email'];
		$this->user_is_verified = $_SESSION['tenant_verified'];
        $this->user_is_logged_in = true;
		
        if ($this->databaseConnection()) {
            $query_verified = $this->db_connection->prepare("SELECT is_verified FROM tbl_tenant t WHERE user_id = :user_id");
            $query_verified->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
            $query_verified->execute();

            // get result row (as an object)
            $result_row = $query_verified->fetchObject();

            $this->user_is_verified = $result_row->is_verified;
            $_SESSION['tenant_verified'] = $result_row->is_verified;
        } else {
            $this->doLogout();
        }
    }

    /**
     * Logs in with the data provided in $_POST, coming from the login form
     * @param $user_email
     * @param $user_password
     */
    private function loginWithPostData($user_email, $user_password)
    {
        if (empty($user_email) || empty($user_password)) {
            $this->errors[] = ERR_LOGIN_FAILED;

        // if POST data (from login form) contains non-empty user_name and non-empty user_password
        } else {

            if ($this->databaseConnection()) {
                // database query, getting all the info of the selected user
                $query_user = $this->db_connection->prepare('SELECT u.id AS id, u.email AS email, u.password_hash AS password_hash, t.fname AS fname, t.lname AS lname, t.is_verified AS is_verified FROM tbl_users u, tbl_tenant t WHERE u.email = :user_email AND u.id = t.user_id AND t.is_expired = 0');
                $query_user->bindValue(':user_email', trim($user_email), PDO::PARAM_STR);
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
                $_SESSION['tenant_user_id'] = $result_row->id;
                $_SESSION['tenant_email'] = $result_row->email;
                $_SESSION['tenant_fname'] = $result_row->fname;
                $_SESSION['tenant_lname'] = $result_row->lname;
                $_SESSION['tenant_verified'] = $result_row->is_verified;
                $_SESSION['tenant_logged_in'] = 1;

                // declare user id, set the login status to true
                $this->user_id = $result_row->id;
                $this->user_email = $result_row->email;
                $this->user_is_verified = $result_row->is_verified;
                $this->user_is_logged_in = true;
				
                header("Location: " . LNK_ROOT . "/tenant/dashboard");
                exit();
            } else {
                $this->errors[] = ERR_LOGIN_FAILED;
            }
        }
    }

    /**
     * Expire session in 30 minutes of no activity
     */
    public function expireSession() {
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
            // last request was more than 30 minutes ago
            session_unset();     // unset $_SESSION variable for the run-time 
            session_destroy();   // destroy session data in storage
        }
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['CREATED'] = time();
        } else if (time() - $_SESSION['CREATED'] > 1800) {
            // session started more than 30 minutes ago
            session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
            $_SESSION['CREATED'] = time();  // update creation time
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

        header('Location: ' . LNK_ROOT . '/tenant/dashboard');
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

    /**
     * Simply return the current state of the user is tenant
     * @return bool user's tenant status
     */
    public function isUserVerified()
    {
        return $this->user_is_verified;
    }
}
?>