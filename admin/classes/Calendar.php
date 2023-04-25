<?php

/**
 * handles methods for managing calendar
 * @author Sire
 * @link null
 * @link null
 * @license null
 */
class Calendar
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
     * Get calendar and tenant info
     */
    public function getCalendarInfo($calendar_id) {
        if ($this->databaseConnection()) {
            $query_get_calendar = $this->db_connection->prepare("SELECT tenant_id, start_date, end_date, calendar_type FROM tbl_calendar WHERE id = :calendar_id");
            $query_get_calendar->bindValue(":calendar_id", $calendar_id, PDO::PARAM_INT);
            $query_get_calendar->execute();
            $result_row = $query_get_calendar->fetchObject();
            $tenant_id = $result_row->tenant_id;

            if ($tenant_id != 0) {
                $query_get_tenant = $this->db_connection->prepare("SELECT tenant_id, CONCAT(t.fname, ' ', t.lname) AS name, c.start_date AS start_date, c.end_date AS end_date, c.calendar_type AS calendar_type FROM tbl_calendar c, tbl_tenant t WHERE c.id = :calendar_id AND c.tenant_id = :tenant_id AND c.tenant_id = t.id");
                $query_get_tenant->bindValue(":calendar_id", $calendar_id, PDO::PARAM_INT);
                $query_get_tenant->bindValue(":tenant_id", $tenant_id, PDO::PARAM_INT);
                $query_get_tenant->execute();
                $result_row = $query_get_tenant->fetchObject();

                return $result_row;
            } else {
                return $result_row;
            }
        } else {
            $this->errors[] = ERR_DB_ERROR;

            return false;
        }
    }


    /**
     * Delete calendar and tenant info if there is
     */
    public function deleteCalendar($calendar_id) 
    {
        if ($this->databaseConnection()) {
            // get tenant_id and calendar_type
            $query_get_calendar = $this->db_connection->prepare("SELECT tenant_id, calendar_type FROM tbl_calendar WHERE id = :calendar_id");
            $query_get_calendar->bindValue(":calendar_id", $calendar_id, PDO::PARAM_INT);
            $query_get_calendar->execute();
            $result_row = $query_get_calendar->fetchObject();
            $tenant_id = $result_row->tenant_id;
            $calendar_type = $result_row->calendar_type;

            // if type is unavailable
            if (strcasecmp($calendar_type, "unavailable") == 0) {
                try {
                    $query_delete_calendar = $this->db_connection->prepare("DELETE FROM tbl_calendar WHERE id = :calendar_id");
                    $query_delete_calendar->bindValue(":calendar_id", $calendar_id, PDO::PARAM_INT);
                    $query_delete_calendar->execute();
                    $this->messages[] = MSG_CALENDAR_DELETE_SUCCESS;

                    return true;
                } catch (PDOException $e) {
                    $this->errors[] = ERR_CALENDAR_DELETE_FAILED . " " . $e.getMessage();

                    return false;
                }

            // if type is reserved or occupied
            } else {
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

                    $this->messages[] = MSG_CALENDAR_DELETE_SUCCESS;

                    return true;
                } catch (PDOException $e) {
                    $this->db_connection->rollBack();
                    $this->errors[] = ERR_CALENDAR_DELETE_FAILED . " " . $e.getMessage();

                    return false;
                }
            }

        } else {
            $this->errors[] = ERR_DB_ERROR;

            return false;
        }
    }
}
?>