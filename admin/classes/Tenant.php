<?php

/**
 * handles methods for managing Tenant
 * @author Sire
 * @link null
 * @link null
 * @license null
 */
class Tenant
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
     * Get list of all tenants
     */
    public function getTenants($criteria, $search) 
    {
        if ($this->databaseConnection()) {
			if ($criteria == 0) {
				// all tenants
                $sql = "SELECT * FROM tbl_tenant";
			} else if ($criteria == 1) {
				// active tenants
                $sql = "SELECT * FROM tbl_tenant WHERE is_active = 1";
			} else if ($criteria == 2) {
				// new tenants
                $sql = "SELECT * FROM tbl_tenant WHERE is_active = 0 AND is_expired = 0";
			} else if ($criteria == 3) {
				// rejected extensions
                $sql = "SELECT * FROM tbl_tenant WHERE is_expired = 1";
			}
			

            if ($search != "") {
                if ($criteria == 0) {
                    $query_search = " WHERE CONCAT(fname, ' ', lname) LIKE :search";
                } else {
                    $query_search = " AND CONCAT(fname, ' ', lname) LIKE :search";
                }
            } else {
                $query_search = "";
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
     * Get all information of tenant
     */
    public function getTenantInfo($tenant_id) 
    {
        if ($this->databaseConnection()) {

            $query_tenant = $this->db_connection->prepare("SELECT * FROM tbl_tenant WHERE id = :tenant_id");
            $query_tenant->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);

            $query_tenant->execute();

            $result_row = $query_tenant->fetchObject();
            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Get all billing information of tenant
     */
    public function getBillingInfo($tenant_id) 
    {
        if ($this->databaseConnection()) {

            $query_bills = $this->db_connection->prepare("SELECT * FROM tbl_bills WHERE tenant_id = :tenant_id ORDER BY id ASC");
            $query_bills->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);

            $query_bills->execute();

            $result_row = $query_bills->fetchAll();
            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Delete tenant and all of its info
     */
    public function deleteTenant($tenant_id) 
    {
        if ($this->databaseConnection()) {
            // get user_id
            $query_get_user = $this->db_connection->prepare("SELECT user_id FROM tbl_tenant WHERE id = :tenant_id");
            $query_get_user->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
            $query_get_user->execute();
            $result_row = $query_get_user->fetchObject();
            $user_id = $result_row->user_id;

            // set sql statements
            $sql_delete_bills = "DELETE FROM tbl_bills WHERE tenant_id = :tenant_id";
            $sql_delete_transactions = "DELETE FROM tbl_transaction WHERE tenant_id = :tenant_id";
            $sql_delete_calendar = "DELETE FROM tbl_calendar WHERE tenant_id = :tenant_id";
            $sql_delete_extension = "DELETE FROM tbl_extension WHERE tenant_id = :tenant_id";
            $sql_delete_housekeeping = "DELETE FROM tbl_housekeeping WHERE tenant_id = :tenant_id";
            $sql_delete_user = "DELETE FROM tbl_users WHERE id = :user_id";
            $sql_delete_tenant = "DELETE FROM tbl_tenant WHERE id = :tenant_id";

            try {
                // start transaction
                $this->db_connection->beginTransaction();

                // delete bills
                $query_delete = $this->db_connection->prepare($sql_delete_bills);
                $query_delete->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_delete->execute();

                // delete transactions
                $query_delete = $this->db_connection->prepare($sql_delete_transactions);
                $query_delete->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_delete->execute();

                // delete extension requests
                $query_delete = $this->db_connection->prepare($sql_delete_extension);
                $query_delete->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_delete->execute();

                // delete housekeeping requests
                $query_delete = $this->db_connection->prepare($sql_delete_housekeeping);
                $query_delete->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_delete->execute();

                // delete calendar
                $query_delete = $this->db_connection->prepare($sql_delete_calendar);
                $query_delete->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_delete->execute();

                // delete user
                $query_delete = $this->db_connection->prepare($sql_delete_user);
                $query_delete->bindValue(":user_id", $user_id, PDO::PARAM_INT);
                $query_delete->execute();

                // delete tenant
                $query_delete = $this->db_connection->prepare($sql_delete_tenant);
                $query_delete->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_delete->execute();

                $this->db_connection->commit();

                $this->messages[] = MSG_TENANT_DELETE_SUCCESS;
            } catch (PDOException $e) {
                $this->db_connection->rollBack();
                $this->errors[] = ERR_TENANT_DELETE_FAILED . " " . $e.getMessage();
            }

        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Expire tenant account
     */
    public function expireAccount($tenant_id) {
        if ($this->databaseConnection()) {
            // get user_id
            $query_get_user = $this->db_connection->prepare("SELECT user_id FROM tbl_tenant WHERE id = :tenant_id");
            $query_get_user->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
            $query_get_user->execute();
            $result_row = $query_get_user->fetchObject();
            $user_id = $result_row->user_id;

            // set sql statements
            $sql_expire_tenant = "UPDATE tbl_tenant SET is_expired = 1 WHERE id = :tenant_id";
            $sql_expire_user = "UPDATE tbl_users SET is_expired = 1 WHERE id = :user_id";

            try {
                // start transaction
                $this->db_connection->beginTransaction();

                // expire tenant
                $query_expire_tenant = $this->db_connection->prepare($sql_expire_tenant);
                $query_expire_tenant->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_expire_tenant->execute();

                // expire user
                $query_expire_user = $this->db_connection->prepare($sql_expire_user);
                $query_expire_user->bindValue(":user_id", $user_id, PDO::PARAM_INT);
                $query_expire_user->execute();

                $this->db_connection->commit();

                $this->messages[] = MSG_TENANT_EXPIRE_SUCCESS;
            } catch (PDOException $e) {
                $this->db_connection->rollBack();
                $this->errors[] = ERR_TENANT_EXPIRE_FAILED . " " . $e.getMessage();
            }

        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Get active tenant
     */
    public function getActiveTenant() {
        if ($this->databaseConnection()) {
            $query_get_active = $this->db_connection->prepare("SELECT * FROM tbl_tenant WHERE is_active = 1");
            $query_get_active->execute();
            $result_row = $query_get_active->fetchObject();

            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Get missed due dates
     */
    public function getMissedDueDates() {
        if ($this->databaseConnection()) {
            date_default_timezone_set("Asia/Manila");
            $date_now = date("Y-m-d");

            $query_get_missed = $this->db_connection->prepare("SELECT b.id AS id, description, amount, due_date, CONCAT(fname, ' ', lname) AS name FROM tbl_bills b, tbl_tenant t WHERE payment_status = 'unpaid' AND due_date < :date_now AND t.id = b.tenant_id");
            $query_get_missed->bindValue(":date_now", $date_now, PDO::PARAM_STR);
            $query_get_missed->execute();
            $result_row = $query_get_missed->fetchAll();

            return $result_row;
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }

    /**
     * Update activity and inactivity of tenants
     */
    public function updateTenantActivity() {
        if ($this->databaseConnection()) {
            date_default_timezone_set("Asia/Manila");
            $date_now = date("Y-m-d");
			
            // set sql statements
            $sql_get_active = "SELECT id FROM tbl_tenant WHERE start_date <= :date_now AND end_date <= :date_now AND is_reserved <> 0 AND is_expired = 0";
            $query_activity = $this->db_connection->prepare($sql_get_active);
            $query_activity->bindValue(":date_now", $date_now, PDO::PARAM_STR);
            $query_activity->execute();
			
            if ($result_row = $query_activity->fetchObject()) {
                $tenant_id = $result_row->id;

                $sql_update_activity = "UPDATE tbl_tenant SET rent_type = 'occupied', is_active = 1 WHERE id = :tenant_id";
                $sql_update_calendar = "UPDATE tbl_calendar SET calendar_type = 'occupied' WHERE tenant_id = :tenant_id";
                $sql_update_inactivity = "UPDATE tbl_tenant SET is_active = 0 WHERE start_date > :date_now OR end_date < :date_now AND is_reserved <> 0";

                try {
                    // start transaction
                    $this->db_connection->beginTransaction();

                    // update tenant activity
                    $query_activity = $this->db_connection->prepare($sql_update_activity);
                    $query_activity->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                    $query_activity->execute();

                    // update calendar
                    $query_activity = $this->db_connection->prepare($sql_update_calendar);
                    $query_activity->bindValue(":tenant_id", $date_now, PDO::PARAM_INT);
                    $query_activity->execute();

                    // update tenant inactivity
                    $query_activity = $this->db_connection->prepare($sql_update_inactivity);
                    $query_activity->bindValue(":date_now", $date_now, PDO::PARAM_STR);
                    $query_activity->execute();

                    $this->db_connection->commit();
                } catch (PDOException $e) {
                    $this->db_connection->rollBack();
                }
            } else {
				echo "none";
			}
        } else {
            $this->errors[] = ERR_DB_ERROR;
        }
    }
}
?>