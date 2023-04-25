<?php

/**
 * handles methods for managing transactions
 * @author Sire
 * @link null
 * @link null
 * @license null
 */
class Transaction
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

        if ($_SESSION['tenant_user_id']) {
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
    public function getTransactions() 
    {   
        if ($this->databaseConnection()) {
            $query_tenant = $this->db_connection->prepare("SELECT id FROM tbl_tenant WHERE user_id = :user_id");
            $query_tenant->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
            $query_tenant->execute();

            $result_row = $query_tenant->fetchObject();

            if (isset($result_row->id)) {
                $tenant_id = $result_row->id;

                $query_transactions = $this->db_connection->prepare("SELECT * FROM tbl_transaction WHERE tenant_id = :tenant_id");
                $query_transactions->bindValue(':tenant_id', $tenant_id, PDO::PARAM_INT);
                $query_transactions->execute();

                $result_row = $query_transactions->fetchAll();
            }
        }
        return $result_row;
    }
}
?>