<?php

// All
define("ERR_DB_ERROR", "Database connection problem. Please try again after a few minutes.");

/**
 * Translation variables for Login Class
 */
 define("ERR_LOGIN_FAILED", "Incorrect username or password");

/**
 * Translation variables for Registration Class
 */
define("ERR_REGISTER_FIELDS_EMPTY", "Please fill up all fields.");
define("ERR_REGISTER_PASSWORDS_NOT_MATCH", "Passwords do not match.");
define("ERR_PASSWORD_REQ", "Password must be at least 6 to 15 letters and/or numbers only.");
define("ERR_REGISTER_TOKEN_INVALID", "Something went wrong. Please try again. Thank you.");
define("MSG_REGISTER_SUCCESS", "Congratulations, you may now monitor and manage your account by logging in here.");
define("ERR_REGISTER_FAILED", "Sorry, a problem occurred. Please try again after a few minutes if problem persists.");


/**
 * Translation variables for Account Class
 */

define("ERR_FIELDS_EMPTY", "Please fill up all fields.");

// password update
define("ERR_PASSWORD_INCORRECT", "Old password is incorrect.");
define("ERR_PASSWORD_NOT_MATCH", "New password and retype password do not match.");
define("ERR_PASSWORD_OLD_EQ_NEW", "Old password and new password must not be the same.");
define("ERR_PASSWORD_REQ", "Password must be at least 6 to 15 letters or numbers.");
define("ERR_PASSWORD_UPDATE_FAILED", "Password update unsuccessful.");
define("MSG_PASSWORD_UPDATE_SUCCESS", "Password updated.");

// personal info update
define("ERR_INFO_UPDATE_FAILED", "Saving failed.");
define("MSG_INFO_UPDATE_SUCCESS", "Changes saved.");

// contract extend
define("ERR_EXTEND_DATE_EMPTY", "Select extension date.");
define("ERR_EXTEND_FAILED", "Date extension request failed.");
define("MSG_EXTEND_SUCCESS", "Date extension request sent.");
define("MSG_EXTEND_CANCEL_SUCCESS", "Extension cancelled.");
define("ERR_EXTEND_CANCEL_FAILED", "An error has occured. Please try again.");

// housekeeping requisition
define("ERR_HOUSEKEEPING_DATE_EMPTY", "Select cleaning date.");
define("ERR_HOUSEKEEPING_FAILED", "An error has occurred. Please try again.");
define("MSG_HOUSEKEEPING_SUCCESS", "Cleaning service request sent.");
define("MSG_HOUSEKEEPING_CANCEL_SUCCESS", "Service cancelled.");
define("ERR_HOUSEKEEPING_CANCEL_FAILED", "An error has occurred. Please try again.");

// laundry requisition
define("ERR_LAUNDRY_FAILED", "Request failed. Please try again.");
define("MSG_LAUNDRY_SUCCESS", "Service request sent.");

/**
 * Shared Words
 */
define("WORD_PAY", "Pay Now");
define("WORD_CANCEL", "Cancel");
define("WORD_CLOSE", "Close");
define("WORD_BACK", "Back");
define("WORD_SAVE", "Save");
define("WORD_VIEW", "view");
define("WORD_REQUEST", "Request");
define("WORD_EDIT", "edit");
define("WORD_EXTEND", "request extension");
define("WORD_SEND", "Send");
define("WORD_WELCOME", "Welcome back ");
define("WORD_REGISTER", "Register");

/**
 * Views/Account
 */
define("WORD_ACCOUNT_INFO", "Account Information");
define("WORD_PERSONAL_INFO", "Personal Information");
define("WORD_RENT_INFO", "Rent Information");
define("WORD_ACCOUNT_INFO_TITLE", "Account Information");
define("WORD_EDIT_PASS", "edit password");
define("WORD_EMAIL_ADDRESS", "Email Address");
define("WORD_REGISTRATION_DATE", "Registration Date");
define("WORD_CURRENT_PASS", "Current Password");
define("WORD_NEW_PASS", "New Password");
define("WORD_RETYPE_PASS", "Retype Password");
define("WORD_UPDATE_PASS", "Update Password");
define("WORD_PERSONAL_INFO_TITLE", "Personal Information");
define("WORD_PERSONAL_EDIT_TITLE", "Update Personal Information");
define("WORD_PERSONAL_NAME", "Name");
define("WORD_PERSONAL_FNAME", "First Name");
define("WORD_PERSONAL_LNAME", "Last Name");
define("WORD_PERSONAL_PHONE", "Phone Number");
define("WORD_RENT_INFO_TITLE", "Rent Information");
define("WORD_RENT_EDIT_TITLE", "Request Extension");
define("WORD_RENT_ARRIVE", "Arrive Date");
define("WORD_RENT_DEPART", "Depart Date");
define("WORD_RENT_TERM", "Rent Term");

/**
 * Views/Bills
 */
define("WORD_BILLING_TITLE", "Billing Periods");
define("WORD_BILLING_CONTENT", "You may click the row of a certain billing period to view the cost breakdown.");
define("WORD_BILL_SUMMARY_TITLE", "Price Summary");
define("WORD_BILL_SUMMARY_CONTENT", "The cost breakdown of the bill is listed below.");

/**
 * Views/Transaction
 */
define("WORD_TRANS_TITLE", "Transactions");

/**
 * Views/Default
 */
define("WORD_DEFAULT_EXIST_CLEANING_CONTENT_1", "You have requested cleaning service on ");
define("WORD_DEFAULT_EXIST_CLEANING_CONTENT_2", ". Click " . WORD_VIEW . " to show service information you requested or order other housekeeping service.");
define("WORD_DEFAULT_CLEANING_CONTENT", "You may request for housekeeping services if you wish to receive assistance on keeping your home or your laundry clean.");
define("WORD_DEFAULT_EXIST_EXT_CONTENT_1", "You have a pending request for extension on ");
define("WORD_DEFAULT_EXIST_EXT_CONTENT_2", ". Click view to show the date you requested.");
define("WORD_DEFAULT_EXT_CONTENT", "You may request an extension if you wish to stay longer than the dates you reserved. Your request will be sent to the administrator for confirmation.");
define("WORD_DEFAULT_ACCOUNT_TITLE", "Account Overview");
define("WORD_DEFAULT_REQUEST_TITLE", "Request extension");
define("WORD_DEFAULT_CLEANING_TITLE", "Order housekeeping services");
define("WORD_DEFAULT_MESSAGE_TITLE", "Leave us a message");
define("WORD_DEFAULT_MESSAGE_PLACEHOLDER", "your message here...");
define("WORD_DEFAULT_ACCOUNT_LABEL_1", "Name");
define("WORD_DEFAULT_ACCOUNT_LABEL_2", "Email Address");
define("WORD_DEFAULT_ACCOUNT_LABEL_3", "Dates of Stay");

/**
 * Views/Extension
 */
define("WORD_EXT_EXIST_LABEL_1", "Current Depart Date");
define("WORD_EXT_EXIST_LABEL_2", "Requested Date");
define("WORD_EXT_CONTENT", "No more dates are available for extension");
define("WORD_EXT_LABEL_1", "Extension Date");

/**
 * Views/Housekeeping
 */

 // housekeeping
define("WORD_HOUSEKEEPING_TITLE", "Cleaning Services");
define("WORD_HOUSEKEEPING_EXIST_CONTENT_1", "You have a pending request on ");
define("WORD_HOUSEKEEPING_EXIST_CONTENT_2", ". Wait for this service to be completed or cancel your pending request.");
define("WORD_HOUSEKEEPING_EXIST_CONTENT_3", "Our cleaning service will take place on or after the date you requested");
define("WORD_HOUSEKEEPING_CONTENT", "Select the date you wish to be assisted on cleaning your home.");
define("WORD_HOUSEKEEPING_LABEL_1", "Housekeeping Date");
// laundry
define("WORD_LAUNDRY_TITLE", "Laundry and Ironing Services");
define("WORD_LAUNDRY_CONTENT", "You may request laundry and ironing assistance from us. The cost will depend on the amount of the laundry. You may also request for clean towels and change of duvet covers, pillow cases, and bed sheets for both bedrooms for additional costs. The payment will be made when our personnel visits your home.");

/**
 * Views/Initial Payment
 */
define("WORD_INITIAL_CONTENT_1", "Your account is not yet verified. As part of our verification process, please settle the one month advance and one month deposit fee by clicking the \"Pay now\" button below. The information about the transaction is listed below.<br /> <br />Once verified, you can fully access your account dashboard and monitor your due dates and transactions.<br /><br />");
define("WORD_INITIAL_CONTENT_2", "Your account is not yet verified. As part of our verification process, please settle your rent fee by clicking the \"Pay now\" button below. The information about the transaction is listed below.<br /> <br />Once verified, you can fully access your account dashboard and monitor your due dates and transactions.<br /><br />");
define("WORD_INITIAL_CONTENT_3", "This transaction will be completed through PayPal.");

/**
 * Views/Registration
 */
define("WORD_REGISTRATION_TITLE", "Tenant Registration");
define("WORD_REGISTRATION_ACCOUNT_TITLE", "Account Information");
define("WORD_REGISTRATION_ACCOUNT_LABEL_1", "Email Address");
define("WORD_REGISTRATION_ACCOUNT_LABEL_2", "Password");
define("WORD_REGISTRATION_ACCOUNT_LABEL_3", "Retype Password");
define("WORD_REGISTRATION_PERSONAL_TITLE", "Personal Information");
define("WORD_REGISTRATION_PERSONAL_LABEL_1", "First Name");
define("WORD_REGISTRATION_PERSONAL_LABEL_2", "Last Name");
define("WORD_REGISTRATION_PERSONAL_LABEL_3", "Phone");
define("WORD_REGISTRATION_SUCCESS_TITLE", "Registration Successful");
define("WORD_REGISTRATION_SUCCESS_CONTENT", "A message has been sent to your email address. You may now login by clicking this link: ");
define("WORD_REGISTRATION_INVALID_TITLE", "Invalid Registration Code");
define("WORD_REGISTRATION_INVALID_CONTENT", "The registration code provided is either invalid or already been used. If you find this incorrect, send us an email at ");

/**
 * Views/Login
 */
define("WORD_LOGIN_TITLE", "Login your account here..");
define("WORD_LOGIN_LABEL_1", "Email");
define("WORD_LOGIN_LABEL_2", "Password");
define("WORD_LOGIN_LABEL_3", "Login");

?>