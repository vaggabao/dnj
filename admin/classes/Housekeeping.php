<?php

/**
 * handles methods for managing Housekeeping requests
 * @author Sire
 * @link null
 * @link null
 * @license null
 */
class Housekeeping
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
     * Search into database for the housekeeping of user_id specified
     */
    public function getHousekeeping($criteria, $search) 
    {
        if ($this->databaseConnection()) {
			if ($criteria == 0) {
				// all
                $sql = "SELECT h.id AS id, h.housekeeping_date AS housekeeping_date, h.is_paid AS is_paid, h.is_cancelled AS is_cancelled, h.is_done AS is_done, t.fname AS fname, t.lname AS lname FROM tbl_housekeeping h, tbl_tenant t WHERE h.tenant_id = t.id";
			} else if ($criteria == 1) {
				// new requests
                $sql = "SELECT h.id AS id, h.housekeeping_date AS housekeeping_date, h.is_paid AS is_paid, h.is_cancelled AS is_cancelled, h.is_done AS is_done, t.fname AS fname, t.lname AS lname FROM tbl_housekeeping h, tbl_tenant t WHERE h.tenant_id = t.id AND h.is_cancelled = 0 AND h.is_paid = 0 AND h.is_done = 0";
			} else if ($criteria == 2) {
				// done
                $sql = "SELECT h.id AS id, h.housekeeping_date AS housekeeping_date, h.is_paid AS is_paid, h.is_cancelled AS is_cancelled, h.is_done AS is_done, t.fname AS fname, t.lname AS lname FROM tbl_housekeeping h, tbl_tenant t WHERE h.tenant_id = t.id AND h.is_cancelled = 0 AND h.is_paid = 1 AND h.is_done = 1";
			} else if ($criteria == 3) {
				// not yet done
                $sql = "SELECT h.id AS id, h.housekeeping_date AS housekeeping_date, h.is_paid AS is_paid, h.is_cancelled AS is_cancelled, h.is_done AS is_done, t.fname AS fname, t.lname AS lname FROM tbl_housekeeping h, tbl_tenant t WHERE h.tenant_id = t.id AND h.is_cancelled = 0 AND h.is_paid = 1 AND h.is_done = 0";
			} else if ($criteria == 4) {
                // cancelled
                $sql = "SELECT h.id AS id, h.housekeeping_date AS housekeeping_date, h.is_paid AS is_paid, h.is_cancelled AS is_cancelled, h.is_done AS is_done, t.fname AS fname, t.lname AS lname FROM tbl_housekeeping h, tbl_tenant t WHERE h.tenant_id = t.id AND h.is_cancelled = 1 AND h.is_paid = 0 AND h.is_done = 0";
            }

            if ($search != "") {
                $query_search = " AND CONCAT(t.fname, ' ', t.lname) LIKE :search ORDER BY housekeeping_date";
            } else {
                $query_search = " ORDER BY housekeeping_date";
            }
            $sql .= $query_search;
			
            $query_tenant = $this->db_connection->prepare($sql);
            if ($search != "") {
                $query_tenant->bindValue(":search", "%".$search."%", PDO::PARAM_STR);
            }

            $query_tenant->execute();

            $result_row = $query_tenant->fetchAll();
            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Mark housekeeping as done
     */
    public function doneHousekeeping($hk_id) {
        if ($this->databaseConnection()) {
            // mark request as done
            $query_hk_done = $this->db_connection->prepare("UPDATE tbl_housekeeping SET is_done = 1, is_cancelled = 0, is_paid = 1 WHERE id = :hk_id");
            $query_hk_done->bindValue(":hk_id", $hk_id, PDO::PARAM_INT);
            $query_hk_done->execute();

            if ($query_hk_done->rowCount() > 0) {
                $this->messages[] = MSG_HOUSEKEEPING_UPDATE_SUCCESS;
            } else {
                $this->errors[] = ERR_HOUSEKEEPING_UPDATE_FAILED;
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }


    /**
     * Cancel housekeeping request
     */
    public function cancelHousekeeping($hk_id) {
        if ($this->databaseConnection()) {
            // cancel housekeeping
            $query_hk_cancel = $this->db_connection->prepare("UPDATE tbl_housekeeping SET is_paid = 0, is_done = 0, is_cancelled = 1 WHERE id = :hk_id");
            $query_hk_cancel->bindValue(":hk_id", $hk_id, PDO::PARAM_INT);
            $query_hk_cancel->execute();

            // get billing_id
            $query_hk_billing_id = $this->db_connection->prepare("SELECT billing_id FROM tbl_housekeeping WHERE id = :hk_id");
            $query_hk_billing_id->bindValue(":hk_id", $hk_id, PDO::PARAM_INT);
            $query_hk_billing_id->execute();
            $result_row = $query_hk_billing_id->fetchObject();
            $billing_id = $result_row->billing_id;


            $query_billing_cancel = $this->db_connection->prepare("UPDATE tbl_bills SET payment_status = 'cancelled' WHERE id = :billing_id");
            $query_billing_cancel->bindValue(":billing_id", $billing_id, PDO::PARAM_INT);
            $query_billing_cancel->execute();

            if ($query_hk_cancel->rowCount() > 0 && $query_billing_cancel->rowCount() > 0) {
                $this->messages[] = MSG_HOUSEKEEPING_UPDATE_SUCCESS;
            } else {
                $this->errors[] = ERR_HOUSEKEEPING_UPDATE_FAILED;
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }
}
?>