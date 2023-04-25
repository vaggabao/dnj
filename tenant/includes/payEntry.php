<?php
    include_once("../config/config.php");
    include_once("../config/dbConnect.php");
    include_once("../config/links.php");
    include_once("../config/globals.php");

    // set default timezone
    date_default_timezone_set("Asia/Manila");

    $user_id = $_SESSION['tenant_id'];
    $sql = "SELECT id, start_date FROM tbl_tenant WHERE user_id = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
        $due_date = strtotime($rs['start_date']);
        $tenant_id = $rs['id'];
    }

    $due_date = strtotime("-1 DAY", $due_date);
    $due_date = date("F d, Y", $due_date);


    // Check if paypal request or response
    if (isset($_POST['pay']) && !isset($_POST['txn_id']) && !isset($_POST['txn_type'])) {
        // set variables
        $item_amount = ENTRY_FEE;
        $item_name = ENTRY_DESCRIPTION;
        $payment_status = "pending";
        $processing_date = date("Y-m-d");

        $sql = "INSERT INTO tbl_transaction (tenant_id, amount, description, payment_status, processing_date) VALUES ($tenant_id, $item_amount, '$item_name', '$payment_status', '$processing_date')";
        $result = mysqli_query($conn, $sql);
        $transaction_id = mysqli_insert_id($conn);

        $cmd = "_xclick";

        // append paypal html variables to query string
        $querystring = "?cmd=" . urlencode($cmd) . "&";
        $querystring .= "business=" . urlencode(PP_ACCOUNT) . "&";  
        $querystring .= "currency_code=" . urlencode(PP_CURRENCY) . "&";
        $querystring .= "item_name=" . urlencode($item_name) . "&";
        $querystring .= "amount=" . urlencode($item_amount) . "&";
        
        // Append paypal return addresses
        $querystring .= "return=".urlencode(PP_ENTRY_RETURN_URL)."&";
        $querystring .= "cancel_return=".urlencode(PP_ENTRY_CANCEL_URL)."&";
        $querystring .= "notify_url=".urlencode(PP_ENTRY_NOTIFY_URL);
        
        // Append querystring with custom field
        $querystring .= "&custom=" . $transaction_id;

        // Redirect to paypal IPN
        header('Location: ' . PP_URL . $querystring);
        exit();

    // PayPal response
    } elseif ( isset($_POST['txn_id']) && isset($_POST['txn_type']) ) {
        include_once("../config/config.php");
        include_once("../config/dbConnect.php");
        include_once("../config/links.php");
        include_once("../config/globals.php");
        
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
        if (strcmp ($res, "VERIFIED") == 0) {

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
            $tenant_id = getTenantId($transaction_id);

            // validate transaction
            $valid = checkTxnId($txn_id);
            $valid = checkEmailReceiver($receiver_email);

            if($valid) {
            	// update transaction information
                $processing_date = date("Y-m-d");
                $sql = "UPDATE tbl_transaction SET payment_status='$payment_status', txn_id='$txn_id', payer_email='$payer_email', processing_date='$processing_date' WHERE id=$transaction_id";
                $result = mysqli_query($conn, $sql);

                if(strcasecmp($payment_status, "Completed") == 0) {
                    // activate tenant account
                    $sql = "UPDATE tbl_tenant SET is_verified = 1 WHERE id = $tenant_id";
                    $result = mysqli_query($conn, $sql);

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
                    $fname = $rs['fname'];

                    // email tenant for activation notification

                    // email tenant for billing notification        
                    $name = ucwords(strtolower($fname));
                    $phone = "(+63)" . $phone;

                    $mail_content = "<html><head></head>
                             <body>
                             <h2>Good day $name!</h2>
                             <br/>
                             <p>Your account has been verified. You may now start monitoring your stay using your dashboard account. Thank you.</p>
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

    // Functions for transaction validation

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
    function getTenantId($transaction_id) {
        global $conn;

        $sql = "SELECT tenant_id FROM tbl_transaction WHERE id = $transaction_id";
        $result = mysqli_query($conn, $sql);
        while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
            $tenant_id = $rs['tenant_id'];
        }

        return $tenant_id;
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

        $mail->From = EMAIL_ENTRY_FROM;
        $mail->FromName = EMAIL_ENTRY_FROM_NAME;
        $mail->Subject = EMAIL_ENTRY_SUBJECT;
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