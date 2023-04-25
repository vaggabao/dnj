<?php

/**
 * handles methods for Transactions
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
    public function getTransactions($criteria, $search) 
    {
        if ($this->databaseConnection()) {
			if ($criteria == 0) {
				// all transactions
                $sql = "SELECT CONCAT(t.fname, ' ', t.lname) AS name, tr.description AS description, tr.amount AS amount, tr.payment_status AS payment_status, tr.processing_date AS processing_date FROM tbl_transaction tr, tbl_tenant t WHERE tr.tenant_id = t.id";
			} else if ($criteria == 1) {
				// completed transactions
                $sql = "SELECT CONCAT(t.fname, ' ', t.lname) AS name, tr.description AS description, tr.amount AS amount, tr.payment_status AS payment_status, tr.processing_date AS processing_date FROM tbl_transaction tr, tbl_tenant t WHERE tr.tenant_id = t.id AND tr.payment_status LIKE 'completed'";
			} else if ($criteria == 2) {
				// pending transactions
                $sql = "SELECT CONCAT(t.fname, ' ', t.lname) AS name, tr.description AS description, tr.amount AS amount, tr.payment_status AS payment_status, tr.processing_date AS processing_date FROM tbl_transaction tr, tbl_tenant t WHERE tr.tenant_id = t.id AND tr.payment_status LIKE 'pending'";
			}

            if ($search != "") {
                $query_search = " AND CONCAT(t.fname, ' ', t.lname) LIKE :search";
            } else {
                $query_search = "";
            }
            $sql .= $query_search;

            $query_transactions = $this->db_connection->prepare($sql);

            if ($search != "") {
                $query_transactions->bindValue(":search", "%".$search."%", PDO::PARAM_STR);
            }

            $query_transactions->execute();

            $result_row = $query_transactions->fetchAll();
            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Delete pending transactions for more than a day
     */
    public function removePending($extension_id) {
        if ($this->databaseConnection()) {
            date_default_timezone_set("Asia/Manila");
            $date_now = date("Y-m-d");

            $sql_delete_transaction = "DELETE * FROM tbl_transaction WHERE DATE_ADD(processing_date, INTERVAL 1 DAY) < :date_now";

            
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

            // get current end date of tenant_id
            $query_get_date = $this->db_connection->prepare("SELECT end_date FROM tbl_tenant WHERE id = :tenant_id");
            $query_get_date->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
            $query_get_date->execute();
            $result_row = $query_get_date->fetchObject();
            $end_date = $query_get_date->end_date;

            // update extension is_accepted = 1
            $query_accept_ext = $this->db_connection->prepare("UPDATE tbl_extension SET is_accepted = 1 WHERE id = :extension_id");
            $query_accept_ext->bindValue(":extension_id", $extension_id, PDO::PARAM_INT);
            $query_accept_ext->execute();

            // update tenants end_date
            $query_update_tenant = $this->db_connection->prepare("UPDATE tbl_tenant SET end_date = :requested_date WHERE id = :tenant_id");
            $query_update_tenant->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
            $query_update_tenant->execute();


            // set billing period for date extensions
            


            if ($query_accept_ext->rowCount() > 0) {
                $this->messages[] = MSG_EXTENSION_ACCEPT_SUCCESS;
            } else {
                $this->errors[] = ERR_EXTENSION_ACCEPT_FAILED;
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


    /**
     * Set billing
     */
    private function setExtensionBills() {

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