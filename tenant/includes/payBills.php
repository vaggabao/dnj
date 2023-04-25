<?php
    // set default timezone
    date_default_timezone_set("Asia/Manila");

    // Check if paypal request or response
    if ( isset($_POST['pay']) && !isset($_POST['txn_id']) && !isset($_POST['txn_type']) ) {
        // get post variable
        $billing_id = $_POST['pay'];

        // get billing info
        $sql = "SELECT * FROM tbl_bills WHERE id = $billing_id";
        $result = mysqli_query($conn, $sql);

        if ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
            $item_amount = $rs['amount'];
            $item_name = $rs['description'];
            $tenant_id = $rs['tenant_id'];
            $transaction_id = $rs['transaction_id'];
        }

        // set transaction variables
        $payment_status = "pending";
        $processing_date = date("Y-m-d");

        if ( empty($transaction_id) ) {
            // insert transaction
            $sql = "INSERT INTO tbl_transaction (tenant_id, amount, description, payment_status, processing_date) VALUES ($tenant_id, $item_amount, '$item_name', '$payment_status', '$processing_date')";
            $result = mysqli_query($conn, $sql);
            $transaction_id = mysqli_insert_id($conn);

            // set transaction id to billing info
            $sql = "UPDATE tbl_bills SET transaction_id = $transaction_id WHERE id = $billing_id";
            $result = mysqli_query($conn, $sql);
        } else {
            // delete incomplete transaction
            $sql = "DELETE FROM tbl_transaction WHERE id = $transaction_id";
            $result = mysqli_query($conn, $sql);

            // insert transaction
            $sql = "INSERT INTO tbl_transaction (tenant_id, amount, description, payment_status, processing_date) VALUES ($tenant_id, $item_amount, '$item_name', '$payment_status', '$processing_date')";
            $result = mysqli_query($conn, $sql);
            $transaction_id = mysqli_insert_id($conn);

            // set transaction id to billing info
            $sql = "UPDATE tbl_bills SET transaction_id = $transaction_id WHERE id = $billing_id";
            $result = mysqli_query($conn, $sql);
        }

        $cmd = "_xclick";

        // append paypal html variables to query string
        $querystring = "?cmd=" . urlencode($cmd) . "&";
        $querystring .= "business=" . urlencode(PP_ACCOUNT) . "&";  
        $querystring .= "currency_code=" . urlencode(PP_CURRENCY) . "&";
        $querystring .= "item_name=" . urlencode($item_name) . "&";
        $querystring .= "amount=" . urlencode($item_amount) . "&";
        
        // Append paypal return addresses
        $querystring .= "return=".urlencode(PP_BILLS_RETURN_URL)."&";
        $querystring .= "cancel_return=".urlencode(PP_BILLS_CANCEL_URL)."&";
        $querystring .= "notify_url=".urlencode(PP_BILLS_NOTIFY_URL);
        
        // Append querystring with custom field
        $querystring .= "&custom=" . $transaction_id;
		
        // Redirect to paypal IPN
        header('location: ' . PP_URL . $querystring);
        exit();

    // PayPal response
    } elseif ( isset($_POST['txn_id']) && isset($_POST['txn_type']) ) {
        // include config files
        include_once("../../config/config.php");
        include_once("../../config/dbConnect.php");
        include_once("../../config/links.php");
        include_once("../../config/globals.php");
        require("../../libraries/PHPMailer.php");
		
        // read raw POST data from input stream 
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();

        foreach ($raw_post_array as $keyval) {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        // add 'cmd' and other post data
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        } 

        foreach ($myPost as $key => $value) {        
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
                $value = urlencode(stripslashes($value)); 
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }
        
        // send POST data to PayPal for validation
        $ch = curl_init(PP_URL);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        // In wamp like environments that do not come bundled with root authority certificates,
        // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
        // of the certificate as shown below.
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
        if( !($res = curl_exec($ch)) ) {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);
		
        // inspect IPN validation result
        if (strcasecmp ($res, "VERIFIED") == 0) {

            // assign posted variables to local variables
            $item_name = $_POST['item_name'];
            $item_number = $_POST['item_number'];
            $payment_status = $_POST['payment_status'];
            if ($_POST['mc_gross'] != NULL)
                $payment_amount = $_POST['mc_gross'];
            else
                $payment_amount = $_POST['mc_gross1'];
            $payment_currency = $_POST['mc_currency'];
            $txn_id = $_POST['txn_id'];
            $receiver_email = $_POST['receiver_email'];
            $payer_email = $_POST['payer_email'];
            $transaction_id = $_POST['custom'];
            
            // get variable data from database
            $billing_id = getBillingId($transaction_id);
            $billing_type = getBillingType($billing_id);

            // validate transaction
            $valid = checkTxnId($txn_id);
            $valid = checkEmailReceiver($receiver_email);

            if($valid) {
                // update transaction information
                $processing_date = date("Y-m-d");
                $sql = "UPDATE tbl_transaction SET payment_status='$payment_status', txn_id='$txn_id', payer_email='$payer_email', processing_date='$processing_date' WHERE id=$transaction_id";
                $result = mysqli_query($conn, $sql);

                if(strcasecmp($payment_status, "Completed") == 0) {
                    // update bills payment_status = paid
                    $sql = "UPDATE tbl_bills SET payment_status='paid' WHERE id=$billing_id";
                    $result = mysqli_query($conn, $sql);


                    // get billing information
                    $sql = "SELECT * FROM tbl_bills WHERE id = $billing_id";
                    $result = mysqli_query($conn, $sql);
                    $rs = $result->fetch_array(MYSQLI_ASSOC);
                    $tenant_id = $rs['tenant_id'];
                    $due_date = date("F d, Y", strtotime($rs['due_date']));

                    // if billing is housekeeping
                    if (strcasecmp($billing_type, "housekeeping") == 0) {
                        // update tbl_housekeeping is_paid = 0
                        $sql = "UPDATE tbl_housekeeping SET is_paid = 1, is_cancelled = 0, is_done = 0 WHERE billing_id = $billing_id";
                        $result = mysqli_query($conn, $sql);
                    } else if (strcasecmp($billing_type, "verification") == 0) {
                        $sql = "UPDATE tbl_tenant SET is_verified = 1 WHERE id = $tenant_id";
                        $result = mysqli_query($conn, $sql);
                    }                   

                    // get transaction information
                    $sql = "SELECT * FROM tbl_transaction WHERE id = $transaction_id";
                    $result = mysqli_query($conn, $sql);
                    $rs = $result->fetch_array(MYSQLI_ASSOC);
                    $description = $rs['description'];
                    $amount = $rs['amount'];
                    $payer_email = strtolower($rs['payer_email']);
                    $payment_status = strtoupper($rs['payment_status']);
                    $processing_date = date("F d, Y", strtotime($rs['processing_date']));

                    // get tenant information
                    $sql = "SELECT * FROM tbl_tenant WHERE id = $tenant_id";
                    $result = mysqli_query($conn, $sql);
                    $rs = $result->fetch_array(MYSQLI_ASSOC);
                    $email = $rs['email'];
                    $fname = $rs['fname'];

                    // email tenant for billing notification        
                    $name = ucwords(strtolower($fname));

                    $mail_content = "<html><head></head>
                             <body>
                             <h2>Good day $name!</h2>
                             <br/>
                             <p>We have received your payment for the $description worth &#8369; $amount due by $due_date. Thank you.</p>
                             <table border=0>
                                <tr><td>Processing Date: $processing_date</td></tr>
                                <tr><td>Description: $description</td></tr>
                                <tr><td>Amount: &#8369; $amount</td></tr>
                                <tr><td>Paypal Account: $payer_email</td></tr>
                                <tr><td>Status: $payment_status</td></tr>
                             </table>
                             <br/>
                             <br/>
                             <p>Regards,</p>
                             <p><a href='" . LNK_ROOT . "'>D & J Lancaster Home Suite</a></p>
                             <br/>
                             <br/>
                             <hr/>
                             <p>This message is an automated email. If you think this is incorrect, email us at administrator@dnjlancasterhomesuite.com. Thank you!</p>
                             </body>
                             </html>
                             ";

                    sendNotificationEmail($email, $mail_content);
                }
            }
        } else if (strcmp ($res, "INVALID") == 0) {
            // log for manual investigation
        }
    }

    /**
     * Functions for transaction validation
     */

    // validate txn_id
    function checkTxnId($txn_id) {
        global $conn;

        $valid = true;

        $sql = "SELECT * FROM tbl_transaction WHERE txn_id = '$txn_id'";
        $result = mysqli_query($conn, $sql);
        if($rs = $result->fetch_array(MYSQLI_ASSOC)) {
            $valid = false;
        }

        return $valid;
    }

    // validate business email
    function checkEmailReceiver($email) {
        $valid = false;
        if(strcasecmp($email, PP_ACCOUNT) == 0) {
            $valid = true;
        }
        return $valid;
    }

    // get tenant id of customer
    function getBillingId($transaction_id) {
        global $conn;

        $sql = "SELECT id FROM tbl_bills WHERE transaction_id = $transaction_id";
        $result = mysqli_query($conn, $sql);
        while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
            $billing_id = $rs['id'];
        }

        return $billing_id;
    }

    // get billing_type of the bills
    function getBillingType($billing_id) {
        global $conn;

        $sql = "SELECT billing_type FROM tbl_bills WHERE id = $billing_id";
        $result = mysqli_query($conn, $sql);
        while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
            $billing_type = $rs['billing_type'];
        }

        return $billing_type;
    }

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
        $mail->SMTPAuth = EMAIL_SMTP_AUTH;
        // Enable encryption, usually SSL/TLS
        $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;

        // Specify host server
        $mail->Host = EMAIL_SMTP_HOST;
        $mail->Port = EMAIL_SMTP_PORT;
        $mail->Username = EMAIL_SMTP_USERNAME;
        $mail->Password = EMAIL_SMTP_PASSWORD;

        $mail->From = EMAIL_BILLING_FROM;
        $mail->FromName = EMAIL_BILLING_FROM_NAME;
        $mail->Subject = EMAIL_BILLING_SUBJECT;
        $mail->Body = $mail_content;
        $mail->AddAddress($email);

        if(!$mail->Send()) {
            $this->errors[] = MESSAGE_VERIFICATION_MAIL_NOT_SENT . $mail->ErrorInfo;
            echo $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }
?>