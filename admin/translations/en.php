<?php

// All
define("ERR_DB_ERROR", "Database connection problem. Please try again after a few minutes.");

/**
 * Translation variables for Login Class
 */
 define("ERR_LOGIN_FAILED", "Incorrect username or password");


/**
 * Translation variables for Login Class
 */

define("ERR_FIELDS_EMPTY", "Please fill up all fields.");

// password update
define("ERR_PASSWORD_INCORRECT", "Current password is incorrect.");
define("ERR_PASSWORD_NOT_MATCH", "New password and repeat password do not match.");
define("ERR_PASSWORD_OLD_EQ_NEW", "Current password and new password must not be the same.");
define("ERR_PASSWORD_REQ", "Password must be 8 to 16 characters.");
define("ERR_PASSWORD_UPDATE_FAILED", "Password update unsuccessful.");
define("MSG_PASSWORD_UPDATE_SUCCESS", "Password updated.");

// personal info update
define("ERR_INFO_UPDATE_FAILED", "Saving failed.");
define("MSG_INFO_UPDATE_SUCCESS", "Update saved.");

// contract extend
define("ERR_EXTEND_DATE_EMPTY", "Select extension date.");
define("ERR_EXTEND_FAILED", "Date extension request failed.");
define("MSG_EXTEND_SUCCESS", "Date extension request sent.");
define("MSG_EXTEND_CANCEL_SUCCESS", "Extension cancelled.");
define("ERR_EXTEND_CANCEL_FAILED", "An error has occured. Please try again.");

// housekeeping requisition
define("ERR_HOUSEKEEPING_DATE_EMPTY", "Select cleaning date.");
define("ERR_HOUSEKEEPING_FAILED", "Cleaning service request failed.");
define("MSG_HOUSEKEEPING_SUCCESS", "Cleaning service request sent.");
define("MSG_HOUSEKEEPING_CANCEL_SUCCESS", "Service cancelled.");
define("ERR_HOUSEKEEPING_CANCEL_FAILED", "An error has occured. Please try again.");

/**
 * Translation Variables for Reservations
 */
define("MSG_RESERVE_CONFIRM_SUCCESS", "Reservation confirmed. An email has been sent to the tenant");
define("ERR_RESERVE_CONFIRM_FAILED", "A problem has occurred. Please try again");

/**
 * Translation Variables for Extensions
 */
define("MSG_EXTENSION_ACCEPT_SUCCESS", "Extension accepted.");
define("ERR_EXTENSION_ACCEPT_FAILED", "Extension accept failed.");
define("MSG_EXTENSION_CANCEL_SUCCESS", "Extension cancelled.");
define("ERR_EXTENSION_CANCEL_FAILED", "Extension cancel failed.");

/**
 * Translation Variables for Housekeeping
 */
define("MSG_HOUSEKEEPING_UPDATE_SUCCESS", "Status updated.");
define("ERR_HOUSEKEEPING_UPDATE_FAILED", "Update failed.");

/**
 * Translation Variables for Tenant
 */
define("MSG_TENANT_DELETE_SUCCESS", "Tenant deleted successfully.");
define("ERR_TENANT_DELETE_FAILED", "Delete failed.");
define("MSG_TENANT_EXPIRE_SUCCESS", "Account has been expired. This tenant can no longer access his/her account.");
define("ERR_TENANT_EXPIRE_FAILED", "Action failed. Please refresh the page and try again.");

/**
 * Translation Variables for Fee
 */
define("MSG_FEE_UPDATE_SUCCESS", "Fees updated successfully.");
define("ERR_FEE_UPDATE_FAILED", "Update failed.");

/**
 * Translation Variables for Calendar
 */
define("MSG_CALENDAR_DELETE_SUCCESS", "Dates selected are now available.");
define("ERR_CALENDAR_DELETE_FAILED", "Update failed.");