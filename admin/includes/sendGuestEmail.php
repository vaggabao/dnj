<?php
	// include config files
	include_once("../../config/config.php");
	include_once("../../config/dbConnect.php");
	include_once("../../config/links.php");
	include_once("../../config/globals.php");
	require("../libraries/PHPMailer.php");

	$email = $_POST['email'];
	$content = $_POST['content'];

    $sent = sendNotificationEmail($email, $content);

    echo $sent;

    /**
     * Send email to tenant
     */
    function sendNotificationEmail($email, $mail_content) {
        $mail = new PHPMailer();
        // Set mailer to use SMTP
        $mail->IsSMTP();
        $mail->IsHTML();
        //useful for debugging, shows full SMTP errors
        //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        // Enable SMTP authentication
        $mail->SMTPAuth = EMAIL_SMTP_AUTH_ADMIN;
        // Enable encryption, usually SSL/TLS
        $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION_ADMIN;

        // Specify host server
        $mail->Host = EMAIL_SMTP_HOST_ADMIN;
        $mail->Port = EMAIL_SMTP_PORT_ADMIN;
        $mail->Username = EMAIL_SMTP_USERNAME_ADMIN;
        $mail->Password = EMAIL_SMTP_PASSWORD_ADMIN;

        $mail->From = EMAIL_REPLY_FROM;
        $mail->FromName = EMAIL_REPLY_FROM_NAME;
        $mail->Subject = EMAIL_REPLY_SUBJECT;
        $mail->Body = $mail_content;
        $mail->AddAddress($email);

        if(!$mail->Send()) {
            $this->errors[] = $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }
?>