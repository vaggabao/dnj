<?php

/**
 * handles methods for retrieving Notfications
 * @author Sire
 * @link null
 * @link null
 * @license null
 */
class Notification
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
     * Get notification count
     */
    public function getNotifyCount() {
        if ($this->databaseConnection()) {
            $query_count = $this->db_connection->prepare("SELECT COUNT(*) AS count FROM tbl_notification");
            $query_count->execute();
            $result_row = $query_count->fetchObject();
            $count = $result_row->count;

            return $count;
        } else {
            $this->errors[] = ERR_DB_ERROR;

            return false;
        }
    }

    /**
     * Get recent count
     */
    public function getRecentCount() {
        if ($this->databaseConnection()) {
            $query_count = $this->db_connection->prepare("SELECT COUNT(*) AS count FROM tbl_recent");
            $query_count->execute();
            $result_row = $query_count->fetchObject();
            $count = $result_row->count;

            return $count;
        } else {
            $this->errors[] = ERR_DB_ERROR;

            return false;
        }
    }

    /**
     * Get notifications
     */
    public function getNotifications($count) {
        if ($this->databaseConnection()) {
            $sql = "(SELECT * FROM tbl_notification ORDER BY id DESC LIMIT $count) ORDER BY id ASC";
            $query_get_notification = $this->db_connection->prepare($sql);
            $query_get_notification->execute();

            $result_row = $query_get_notification->fetchAll();
            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;

            return false;
        }
    }

    /**
     * Get recent activities
     */
    public function getRecent($count) {
        if ($this->databaseConnection()) {
            $sql = "(SELECT * FROM tbl_recent ORDER BY id DESC LIMIT $count) ORDER BY id ASC";
            $query_get_notification = $this->db_connection->prepare($sql);
            $query_get_notification->execute();

            $result_row = $query_get_notification->fetchAll();
            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;

            return false;
        }
    }
}
?>