<?php

/**
 * handles methods for managing Fee parameters
 * @author Sire
 * @link null
 * @link null
 * @license null
 */
class Fee
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
     * Get list of all fee parameters in database
     */
    public function getFees() 
    {
        if ($this->databaseConnection()) {
			$query_get_fees = $this->db_connection->prepare("SELECT * FROM tbl_prices");
            $query_get_fees->execute();
            $result_row = $query_get_fees->fetchAll();

            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Update fee parameter values
     */
    public function updateFee($id, $amount) 
    {
        if ($this->databaseConnection()) {
            // update fee amount
            $query_update_fee = $this->db_connection->prepare("UPDATE tbl_prices SET amount = :amount WHERE id = :id");
            $query_update_fee->bindValue(":amount", $amount, PDO::PARAM_STR);
            $query_update_fee->bindValue(":id", $id, PDO::PARAM_INT);
            $query_update_fee->execute();
            if ($query_update_fee) {
                if (!$this->messages) {
                    $this->messages[] = MSG_FEE_UPDATE_SUCCESS;
                }
            } else {
                if (!$this->errors) {
                    $this->errors[] = ERR_FEE_UPDATE_FAILED;
                }
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }
}
?>