<?php

	/**
	 * Configuration for: Database Connection
	 */
	// define("DB_HOST", "ailishe.ipagemysql.com");
	define("DB_HOST", "localhost");
	define("DB_NAME", "asdnj_rental");
	define("DB_USER", "root");
	// define("DB_USER", "asdnj_rental");
	define("DB_PASS", "");
	// define("DB_PASS", "TPVaD8wyAVW6zPY9");

	/**
	 * Configuration for: Cookies
	 */
	define("COOKIE_RUNTIME", 1209600);
	define("COOKIE_DOMAIN", ".127.0.0.1");
	define("COOKIE_SECRET_KEY", "1gp@TMPS{+$78sfpMJFe-92s");

	/**
	 * Configuration for: Email no-reply credentials
	 */
	define("EMAIL_SMTP_HOST", "smtp.dnjlancasterhomesuite.com");
	define("EMAIL_SMTP_AUTH", true);
	define("EMAIL_SMTP_USERNAME", "no-reply@dnjlancasterhomesuite.com");
	define("EMAIL_SMTP_PASSWORD", "Dnjno-reply16");
	define("EMAIL_SMTP_PORT", 465);
	define("EMAIL_SMTP_ENCRYPTION", "ssl");

	/**
	 * Configuration for: Email administrator credentials
	 */
	define("EMAIL_SMTP_HOST_ADMIN", "smtp.dnjlancasterhomesuite.com");
	define("EMAIL_SMTP_AUTH_ADMIN", true);
	define("EMAIL_SMTP_USERNAME_ADMIN", "administrator@dnjlancasterhomesuite.com");
	define("EMAIL_SMTP_PASSWORD_ADMIN", "Dnjadministrator16");
	define("EMAIL_SMTP_PORT_ADMIN", 465);
	define("EMAIL_SMTP_ENCRYPTION_ADMIN", "ssl");
	// define("EMAIL_OWNER_ADDRESS", "voleaggabao@gmail.com");
	define('EMAIL_OWNER_ADDRESS', 'jean_0616@hotmail.com');

	/**
	 * Configuration for: Reply email
	 */
	define("EMAIL_REPLY_FROM", "administrator@dnjlancasterhomesuite.com");
	define("EMAIL_REPLY_FROM_NAME", "D&J Lancaster Home Suite");
	define("EMAIL_REPLY_SUBJECT", "Reply from D&J Lancaster Home Suite Administrator");

	/**
	 * Configuration for: Registration notification email
	 */
	define("EMAIL_NOTIFY_FROM", "no-reply@dnjlancasterhomesuite.com");
	define("EMAIL_NOTIFY_FROM_NAME", "D&J Lancaster Home Suite");
	define("EMAIL_NOTIFY_SUBJECT", "Welcome to D&J Lancaster Home Suite");

	/**
	 * Configuration for: Reservation notification email
	 */
	define("EMAIL_RESERVE_FROM", "no-reply@dnjlancasterhomesuite.com");
	define("EMAIL_RESERVE_FROM_NAME", "D&J Lancaster Home Suite");
	define("EMAIL_RESERVE_SUBJECT", "(Reservation) D&J Lancaster Home Suite");

	/**
	 * Configuration for: Billing paid notification email
	 */
	define("EMAIL_BILLING_FROM", "no-reply@dnjlancasterhomesuite.com");
	define("EMAIL_BILLING_FROM_NAME", "D&J Lancaster Home Suite");
	define("EMAIL_BILLING_SUBJECT", "(Transaction Completed) D&J Lancaster Home Suite");

	/**
	 * Configuration for: Entry paid notification email
	 */
	define("EMAIL_ENTRY_FROM", "no-reply@dnjlancasterhomesuite.com");
	define("EMAIL_ENTRY_FROM_NAME", "D&J Lancaster Home Suite");
	define("EMAIL_ENTRY_SUBJECT", "(Account Verified) D&J Lancaster Home Suite");
?>