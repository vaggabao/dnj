<?php

/**
 * handles methods for viewing tenant messages
 * @author Sire
 * @link null
 * @link null
 * @license null
 */
class tenantMessages
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
     * Search into database for the messages by guests
     */
    public function getChatList() 
    {
        if ($this->databaseConnection()) {
            $sql = "SELECT id, CONCAT(fname, ' ', lname) AS name FROM tbl_tenant WHERE is_verified = 1 AND is_registered = 1";
            $query_messages = $this->db_connection->prepare($sql);
            $query_messages->execute();

            $result_row = $query_messages->fetchAll();
            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Get message count
     */
    public function getMsgCount($tenant_id) {
        if ($this->databaseConnection()) {
            $query_count = $this->db_connection->prepare("SELECT COUNT(*) AS count FROM tbl_messages WHERE tenant_id = :tenant_id");
            $query_count->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
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
     * Search into database for the messages by tenants
     */
    public function getMessage($tenant_id, $count) {
        if ($this->databaseConnection()) {
            try {
                $sql = "SELECT * FROM tbl_messages WHERE tenant_id = :tenant_id ORDER BY message_datetime DESC LIMIT $count";
                $query_messages = $this->db_connection->prepare($sql);
                $query_messages->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_messages->execute();

                $result_row = $query_messages->fetchAll();
                return $result_row;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Send new message
     */
    public function sendMessage($tenant_id, $message) {
        if ($this->databaseConnection()) {
            date_default_timezone_set("Asia/Manila");
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO tbl_messages (tenant_id, send_to, message, message_datetime) VALUES(:tenant_id, 'tenant', :message, :message_datetime)";
            try {
                $query_send = $this->db_connection->prepare($sql);
                $query_send->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_send->bindValue(":message", $message, PDO::PARAM_STR);
                $query_send->bindValue(":message_datetime", $datetime, PDO::PARAM_STR);
                $query_send->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }
}
?>