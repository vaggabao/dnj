<?php

// All
define("ERR_DB_ERROR", "Nagkaroon ng problema. Pakisubukan ulit pagkalipas ng ilang sandali. Salamat.");

/**
 * Translation variables for Login Class
 */
 define("ERR_LOGIN_FAILED", "Ang email at password ay hindi valid.");

/**
 * Translation variables for Registration Class
 */
define("ERR_REGISTER_FIELDS_EMPTY", "Paki fill-up ang bawat fields.");
define("ERR_REGISTER_PASSWORDS_NOT_MATCH", "Ang iyong mga passwords ay di nagtugma.");
define("ERR_PASSWORD_REQ", "Ang iyong password ay dapat 6 hanggang 15 letra at numero lamang.");
define("ERR_REGISTER_TOKEN_INVALID", "Ang token na ito ay hindi valid.");
define("MSG_REGISTER_SUCCESS", "Maari mo nang ma-monitor ang iyong pagtira gamit ang iyong account. Maglogin lamang dito.");
define("ERR_REGISTER_FAILED", "Nagkaroon ng problema. Pakisubukan ulit pagkalipas ng ilang sandali. Salamat.");


/**
 * Translation variables for Account Class
 */

define("ERR_FIELDS_EMPTY", "Paki fill-up ang bawat fields.");

// password update
define("ERR_PASSWORD_INCORRECT", "Ang kasalukuyang passsword ay mali");
define("ERR_PASSWORD_NOT_MATCH", "Ang iyong mga passwords ay di nagtugma.");
define("ERR_PASSWORD_OLD_EQ_NEW", "Ang iyong kasulukuyan at bagong passwords ay hindi dapat magkatulad.");
define("ERR_PASSWORD_REQ", "Password must be 8 to 16 characters.");
define("ERR_PASSWORD_UPDATE_FAILED", "Ang pag-update ng password ay hindi naging matagumpay. Maari lamang na irefresh ang page at subukang muli.");
define("MSG_PASSWORD_UPDATE_SUCCESS", "Ang pagpapalit ng password ay naging matagumpay.");

// personal info update
define("ERR_INFO_UPDATE_FAILED", "Ang pag-update ay hindi naging matagumpay.");
define("MSG_INFO_UPDATE_SUCCESS", "Ang pag-update ay naging matagumpay.");

// contract extend
define("ERR_EXTEND_DATE_EMPTY", "Mamili ng huling araw para sa extension.");
define("ERR_EXTEND_FAILED", "Ang pag-request ng extension ay hindi naging matagumpay. Maari lamang na irefresh ang page at subukang muli.");
define("MSG_EXTEND_SUCCESS", "Ang iyong request ay napadala na. Hintayin lamang ang confimation mula sa may-ari.");
define("MSG_EXTEND_CANCEL_SUCCESS", "Ang pag request ng extension ay nakansela.");
define("ERR_EXTEND_CANCEL_FAILED", "Nagkaroon ng problema. Maari lamang na irefresh ang page at subukang muli.");

// housekeeping requisition
define("ERR_HOUSEKEEPING_DATE_EMPTY", "Mamili ng araw ng cleaning service.");
define("ERR_HOUSEKEEPING_FAILED", "Ang iyong pag-request ng service ay hindi naging matagumpay. Maari lamang na subukang muli.");
define("MSG_HOUSEKEEPING_SUCCESS", "Ang iyong pag-request ng service ay naging matagumpay.");
define("MSG_HOUSEKEEPING_CANCEL_SUCCESS", "Ang cleaning service na iyong inorder ay nakansela.");
define("ERR_HOUSEKEEPING_CANCEL_FAILED", "Nagkaroon ng problema. Maari lamang na irefresh ang page at subukang muli.");

// laundry requisition
define("ERR_LAUNDRY_FAILED", "Ang iyong pag-request ng service ay hindi naging matagumpay. Maari lamang na subukang muli");
define("MSG_LAUNDRY_SUCCESS", "Ang iyong pag-request ng service ay naging matagumpay.");

/**
 * Shared Words
 */
define("WORD_PAY", "Magbayad");
define("WORD_CANCEL", "Ikansela");
define("WORD_CLOSE", "Isara");
define("WORD_BACK", "Bumalik");
define("WORD_SAVE", "I-save");
define("WORD_VIEW", "view");
define("WORD_REQUEST", "Mag-request");
define("WORD_EDIT", "edit");
define("WORD_EXTEND", "mag-request ng extension");
define("WORD_SEND", "Isend");
define("WORD_WELCOME", "Maligayang Pagbabalik ");
define("WORD_REGISTER", "Register");

/**
 * Views/Account
 */
define("WORD_ACCOUNT_INFO", "Account Information");
define("WORD_PERSONAL_INFO", "Personal Information");
define("WORD_RENT_INFO", "Rent Information");
define("WORD_ACCOUNT_INFO_TITLE", "Account Information");
define("WORD_EDIT_PASS", "baguhin ang password");
define("WORD_EMAIL_ADDRESS", "Email Address");
define("WORD_REGISTRATION_DATE", "Araw ng Registration");
define("WORD_CURRENT_PASS", "Kasalukuyang Password");
define("WORD_NEW_PASS", "Bagong Password");
define("WORD_RETYPE_PASS", "Ulitin ang Password");
define("WORD_UPDATE_PASS", "I-update ang Password");
define("WORD_PERSONAL_INFO_TITLE", "Personal Information");
define("WORD_PERSONAL_EDIT_TITLE", "I-update ang Personal Information");
define("WORD_PERSONAL_NAME", "Pangalan");
define("WORD_PERSONAL_FNAME", "Pangalan");
define("WORD_PERSONAL_LNAME", "Apelyido");
define("WORD_PERSONAL_PHONE", "Telepono");
define("WORD_RENT_INFO_TITLE", "Rent Information");
define("WORD_RENT_EDIT_TITLE", "Request ng Extension");
define("WORD_RENT_ARRIVE", "Araw ng Pagdating");
define("WORD_RENT_DEPART", "Araw ng Paglisan");
define("WORD_RENT_TERM", "Tagal ng Pagtira");

/**
 * Views/Bills
 */
define("WORD_BILLING_TITLE", "Billing Periods");
define("WORD_BILLING_CONTENT", "Maari mong i-click ang row ng billing period upang makita ang breakdown ng halaga.");
define("WORD_BILL_SUMMARY_TITLE", "Detalye ng Presyo");
define("WORD_BILL_SUMMARY_CONTENT", "Ang breakdown ng halaga ng bill ay makikita sa ibaba.");

/**
 * Views/Transaction
 */
define("WORD_TRANS_TITLE", "Mga Transactions");

/**
 * Views/Default
 */
define("WORD_DEFAULT_EXIST_CLEANING_CONTENT_1", "Nagrequest ka ng cleaning service sa ");
define("WORD_DEFAULT_EXIST_CLEANING_CONTENT_2", ". Pindutin ang " . WORD_VIEW . " upang makita ang detalye ng service na iyong ni-request o mag-request ng iba pang service.");
define("WORD_DEFAULT_CLEANING_CONTENT", "Maari kang mag-request ng housekeeping service mula sa amin upang matulungan ka sa pagpapanatili ng kalinisan ng bahay o ng iyong mga laundry.");
define("WORD_DEFAULT_EXIST_EXT_CONTENT_1", "Mayroon kang pending na request na extension sa ");
define("WORD_DEFAULT_EXIST_EXT_CONTENT_2", ". Pindutin ang detalye ng iyong request.");
define("WORD_DEFAULT_EXT_CONTENT", "Maari kang mag-request ng extension kung nais mong tumira ng masmatagal kaysa sa mga araw na iyong ni-reserve noon. Ang iyong request ay mapapadala sa administrator para sa kumpirmasyon.");
define("WORD_DEFAULT_ACCOUNT_TITLE", "Overview ng Account");
define("WORD_DEFAULT_REQUEST_TITLE", "Mag-request ng extension");
define("WORD_DEFAULT_CLEANING_TITLE", "Mag-request ng housekeeping service");
define("WORD_DEFAULT_MESSAGE_TITLE", "Mag-iwan ng mensahe");
define("WORD_DEFAULT_MESSAGE_PLACEHOLDER", "ilagay ang mensahe dito...");
define("WORD_DEFAULT_ACCOUNT_LABEL_1", "Pangalan");
define("WORD_DEFAULT_ACCOUNT_LABEL_2", "Email Address");
define("WORD_DEFAULT_ACCOUNT_LABEL_3", "Mga Araw ng Pagtira");

/**
 * Views/Extension
 */
define("WORD_EXT_EXIST_LABEL_1", "Kasalukuyang Araw ng Paglisan");
define("WORD_EXT_EXIST_LABEL_2", "Araw na Iyong Ni-request");
define("WORD_EXT_CONTENT", "Wala ng available na araw para sa iyong extension.");
define("WORD_EXT_LABEL_1", "Araw ng Extension");

/**
 * Views/Housekeeping
 */
define("WORD_HOUSEKEEPING_TITLE", "Cleaning Services");
define("WORD_HOUSEKEEPING_EXIST_CONTENT_1", "Mayroon kang pending na request sa ");
define("WORD_HOUSEKEEPING_EXIST_CONTENT_2", ". Maari nang magbayad ng service fee upang maisagawa ito sa itinakda mong araw. Maari mo ring ikansela ang iyong request i-click lamang ang button na \"Ikansela\".");
define("WORD_HOUSEKEEPING_EXIST_CONTENT_3", "Ang aming cleaning service ay maisasagawa sa araw na iyong ni-request o sa mga susunod na araw mula sa petsa na iyong ni-request");
define("WORD_HOUSEKEEPING_CONTENT", "Pumili ng date kung kelan ka namin tutulungan na linisin ang iyong tahanan.");
define("WORD_HOUSEKEEPING_LABEL_1", "Araw ng Paglilinis");
// laundry
define("WORD_LAUNDRY_TITLE", "Laundry Services");
define("WORD_LAUNDRY_CONTENT", "Maari kang mag-request ng laundry at ironing assistance mula sa amin. Ang halaga ay depende sa dami ng labahin. Maaari ka ring mag-request ng clean towels at pagpalit ng duvet covers, pillow cases, at bed sheets sa karagdagang halaga. Maari kang magbayad sa araw na dumating ang aming personnel sa iyong tahanan.");

/**
 * Views/Initial Payment
 */
define("WORD_INITIAL_CONTENT_1", "Ang iyong account ay hindi pa verified. Maaring i-settle muna ang one month advance and one month deposit na fee upang ma-verify ang iyong account at ang iyong pagtira. Ang detalye ng transaction ay makikita sa ibaba.<br /> <br />Kapag ang account ay verified na, maaari mo nang ma-access ang account dashboard at i-monitor ang iyong mga transaction.<br /><br />");
define("WORD_INITIAL_CONTENT_2", "Ang iyong account ay hindi pa verified. Maaring i-settle muna ang iyong rent fee upang ma-verify ang iyong account at ang iyong pagtira. Ang detalye ng transaction ay makikita sa ibaba.<br /> <br />Kapag ang account ay verified na, maaari mo nang ma-access ang account dashboard at i-monitor ang iyong mga transaction.<br /><br />");
define("WORD_INITIAL_CONTENT_3", "Ang transaction na ito ay mababayaran gamit ang Paypal.");

/**
 * Views/Registration
 */
define("WORD_REGISTRATION_TITLE", "Registration bilang Tenant");
define("WORD_REGISTRATION_ACCOUNT_TITLE", "Account Information");
define("WORD_REGISTRATION_ACCOUNT_LABEL_1", "Email Address");
define("WORD_REGISTRATION_ACCOUNT_LABEL_2", "Password");
define("WORD_REGISTRATION_ACCOUNT_LABEL_3", "Ulitin ang Password");
define("WORD_REGISTRATION_PERSONAL_TITLE", "Personal Information");
define("WORD_REGISTRATION_PERSONAL_LABEL_1", "Pangalan");
define("WORD_REGISTRATION_PERSONAL_LABEL_2", "Apelyido");
define("WORD_REGISTRATION_PERSONAL_LABEL_3", "Telepono");
define("WORD_REGISTRATION_SUCCESS_TITLE", "Ang registration ay naging matagumpay");
define("WORD_REGISTRATION_SUCCESS_CONTENT", "May pinadala kaming mensahe sa iyong email address. Maaari ka ng mag-login mayari lamang na i-click ang link na ito: ");
define("WORD_REGISTRATION_INVALID_TITLE", "Ang Registration Code ay hindi valid");
define("WORD_REGISTRATION_INVALID_CONTENT", "Ang registration na ito ay hindi na valid. Kung ito ay isang pagkakamali, maaari kaming i-email sa ");

/**
 * Views/Login
 */
define("WORD_LOGIN_TITLE", "I-login ang iyong account");
define("WORD_LOGIN_LABEL_1", "Email");
define("WORD_LOGIN_LABEL_2", "Password");
define("WORD_LOGIN_LABEL_3", "Mag-login");

?>