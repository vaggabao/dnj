<?php

/**
 * handles methods for viewing guest messages
 * @author Sire
 * @link null
 * @link null
 * @license null
 */
class guestMessages
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
    public function getMessages($search) 
    {
        if ($this->databaseConnection()) {
            $sql = "SELECT * FROM tbl_guest_messages";

            if ($search != "") {
                $query_search = " WHERE CONCAT(fname, ' ', lname) LIKE :search OR message LIKE :search ORDER BY message_datetime DESC";
            } else {
                $query_search = " ORDER BY message_datetime DESC";
            }
            $sql .= $query_search;
			
            $query_messages = $this->db_connection->prepare($sql);
            if ($search != "") {
                $query_messages->bindValue(":search", "%".$search."%", PDO::PARAM_STR);
            }

            $query_messages->execute();

            $result_row = $query_messages->fetchAll();
            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Mark message as seen
     */
    public function seenMessage($message_id) {
        if ($this->databaseConnection()) {
            // mark message as seen
            $query_msg_seen = $this->db_connection->prepare("UPDATE tbl_guest_messages SET is_seen = 1 WHERE id = :message_id");
            $query_msg_seen->bindValue(":message_id", $message_id, PDO::PARAM_INT);
            $query_msg_seen->execute();
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Get content of message
     */
    public function getMessageContent($message_id) {
        if ($this->databaseConnection()) {
            $sql = "SELECT * FROM tbl_guest_messages WHERE id = :message_id";
            
            $query_messages = $this->db_connection->prepare($sql);
            $query_messages->bindValue(":message_id", $message_id, PDO::PARAM_INT);
            $query_messages->execute();

            $result_row = $query_messages->fetchObject();

            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }
}
?>