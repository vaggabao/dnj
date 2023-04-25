<?php
    // set default timezone
    date_default_timezone_set("Asia/Manila");
    // Check if paypal request or response
    if ( (isset($_POST['reserve']) || isset($_POST['overwrite'])) && !isset($_POST['txn_id']) && !isset($_POST['txn_type'])) {
        // get post variables
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $start_date = $_POST['sdate'];
        $end_date = $_POST['edate'];

        $available = checkDatesAvailability($start_date, $end_date);

        if ($available) {
            $exists = 0;

            if ( !isset($_POST['overwrite']) ) {
                $sql = "SELECT * FROM tbl_tenant WHERE email LIKE '$email' AND is_expired = 0";
                $result = mysqli_query($conn, $sql);

                $num_rows = mysqli_num_rows($result);
                if ($num_rows) {
                    $rs = $result->fetch_array(MYSQLI_ASSOC);
                    $reserved = $rs['is_reserved'];
                    $exists = 1;
                }
            }

            if ( ($exists == 0) || isset($_POST['overwrite']) ) {
                if ( isset($_POST['overwrite']) ) {
                    $sql = "DELETE t, tr FROM tbl_tenant t, tbl_transaction tr WHERE t.id = tr.tenant_id AND email LIKE '$email' AND is_reserved = 0"; 
                    $result = mysqli_query($conn, $sql);
                }

                // get date difference
                $interval = getDateDiff($start_date, $end_date);
                $nummonths = $interval[0];
                $numdays = $interval[1];

                // set item value
                if($nummonths >= 1) {
                    $item_name = LONG_TERM_DESCRIPTION;
                    $item_amount = LONG_TERM_FEE;
                    $rent_term = "long";
                    $rent_fee = RENT_FEE;
                } else {
                    $item_name = SHORT_TERM_DESCRIPTION;
                    $item_amount = SHORT_TERM_FEE;
                    $rent_term = "short";

                    if ($numdays <= 6) {
                        $rent_fee = SHORT_WITH_BILLS_FEE * $numdays;
                    } else {
                        if ($numdays <= 21) {
                            $rent_fee = SHORT_NO_BILLS_FEE * $numdays;
                        } else {
                            $rent_fee = RENT_FEE;
                        }
                    }
                }

                // set variable values
                $rent_type = "reserved";
                $payment_status = "pending";
                $processing_date = date("Y-m-d");

                // generate random token for registration
                $token = md5(uniqid(mt_rand(), true));
                while(!checkToken($token)) {
                    $token = md5(uniqid(mt_rand(), true));
                }

                // insert data into tenant table
                $sql = "INSERT INTO tbl_tenant (fname, lname, email, phone, start_date, end_date, token, rent_type, rent_term, rent_fee) VALUES('$fname', '$lname', '$email', '$phone', '$start_date', '$end_date', '$token', '$rent_type', '$rent_term', '$rent_fee')";
                $result = mysqli_query($conn, $sql);
                $tenant_id = mysqli_insert_id($conn);

                // insert data into transactions table as pending and get its id
                $sql = "INSERT INTO tbl_transaction (tenant_id, amount, description, payment_status, processing_date) VALUES($tenant_id, $item_amount, '$item_name', '$payment_status', '$processing_date')";
                $result = mysqli_query($conn, $sql);

                $transaction_id = mysqli_insert_id($conn);

                // insert to recent activity
                $description = ucwords(strtolower($fname . " " . $lname)) . "($email) has booked a reservation on " . date("F d, Y", strtotime($start_date)) . " to " . date("F d, Y", strtotime($end_date)) . ".";
                $recent_datetime = date("Y-m-d H:i:s");
                $sql = "INSERT INTO tbl_recent (description, recent_datetime) VALUES('$description', '$recent_datetime')";
                $result = mysqli_query($conn, $sql);

                $cmd = "_xclick";

                // append paypal html variables to query string
                $querystring = "?cmd=" . urlencode($cmd) . "&";
                $querystring .= "business=" . urlencode(PP_ACCOUNT) . "&";  
                $querystring .= "currency_code=" . urlencode(PP_CURRENCY) . "&";
                $querystring .= "item_name=" . urlencode($item_name) . "&";
                $querystring .= "amount=" . urlencode($item_amount) . "&";
                
                // Append paypal return addresses
                $querystring .= "return=".urlencode(PP_RESERVE_RETURN_URL)."&";
                $querystring .= "cancel_return=".urlencode(PP_RESERVE_CANCEL_URL . "=" . $token)."&";
                $querystring .= "notify_url=".urlencode(PP_RESERVE_NOTIFY_URL);
                
                // Append querystring with custom field
                $querystring .= "&custom=" . $transaction_id;


                // email customer for tenant registration
                $name = ucwords(strtolower($fname));
                $phone = $phone;
                $start_date = date("F d, Y", strtotime($start_date));
                $end_date =  date("F d, Y", strtotime($end_date));

                $mail_content = "<html><head></head>
                         <body>
                         <h3>Good day $name!</h3>
                         <br/>
                         <p>You have a pending reservation on $start_date to $end_date with us. If you encountered any problems while completing the transaction, you may complete this reservation by clicking <a href='" . LNK_ROOT . "/reservation/pending/" . $token . "'>here</a>. You may also review our tenancy agreement (DRAFT) attached in this email. Thank you!</p>
                         <br/>
                         <p>Regards,</p>
                         <p><a href='" . LNK_ROOT . "'>D&J Lancaster Home Suite</a></p>
                         <br/>
                         <br/>
                         <hr/>
                         <p>This message is an automated email, please do not reply. If you think this is incorrect, email us at administrator@dnjlancasterhomesuite.com. Thank you!</p>
                         </body>
                         </html>
                         ";

                sendNotificationEmail($email, $mail_content);

                // Redirect to paypal IPN
                header('Location: ' . PP_URL . $querystring);
                exit();
            }
        }

    // PayPal response
    } elseif (isset($_POST['txn_id']) && isset($_POST['txn_type'])) {
        // include config files
        include_once("../config/config.php");
        include_once("../config/dbConnect.php");
        include_once("../config/links.php");
        include_once("../config/globals.php");
        require("../libraries/PHPMailer.php");
        
        
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
            
            // set variable data from database
            $tenant_id = getTenantId($transaction_id);
            $dateRange = getDatesToReserve($tenant_id);
            $start_date = $dateRange[0];
            $end_date = $dateRange[1];

            // validate transaction
            $valid = checkTxnId($txn_id);
            $valid = checkEmailReceiver($receiver_email);
            $valid = checkDatesAvailability($start_date, $end_date);

            if($valid) {
                $processing_date = date("Y-m-d");
                $sql = "UPDATE tbl_transaction SET payment_status='$payment_status', txn_id='$txn_id', payer_email='$payer_email', processing_date='$processing_date' WHERE id=$transaction_id";
                $result = mysqli_query($conn, $sql);

                if(strcasecmp($payment_status, "Completed") == 0) {
                    // get rent info
                    $sql = "SELECT * FROM tbl_tenant WHERE id=$tenant_id";
                    $result = mysqli_query($conn, $sql);
                    if($rs = $result->fetch_array(MYSQLI_ASSOC)) {
                        $start_date = $rs['start_date'];
                        $end_date = $rs['end_date'];
                        $rent_type = $rs['rent_type'];
                        $email = $rs['email'];
                        $fname = $rs['fname'];
                        $lname = $rs['lname'];
                        $phone = $rs['phone'];
                        $rent_term = $rs['rent_term'];
						$name = ucwords($fname . " " . $lname);
                    }

                    // generate random token for registration
                    $token = md5(uniqid(mt_rand(), true));
                    while(!checkToken($token)) {
                        $token = md5(uniqid(mt_rand(), true));
                    }

                    // set random token to tenant
                    $sql = "UPDATE tbl_tenant SET token='$token', is_reserved = 1 WHERE id=$tenant_id";
                    $result = mysqli_query($conn, $sql);

                    // insert dates reserved into calendar
                    $sql = "INSERT INTO tbl_calendar (tenant_id, start_date, end_date, calendar_type) VALUES($tenant_id, '$start_date', '$end_date', '$rent_type')";
                    $result = mysqli_query($conn, $sql);

                    // insert to notification activity
                    $description = "A reservation on " . date("F d, Y", strtotime($start_date)) . " to " . date("F d, Y", strtotime($end_date)) . " by " . ucwords(strtolower($fname . " " . $lname)) . "($email)"  . " has been completed. Confirm this reservation <a href=" . LNK_ROOT . "/admin/utilities?view=1>here</a>";
                    $notification_datetime = date("Y-m-d H:i:s");
                    $sql = "INSERT INTO tbl_notification (description, notification_datetime) VALUES('$description', '$notification_datetime')";
                    $result = mysqli_query($conn, $sql);
				
					$mail_content = "<html><head></head>
							 <body>
							 <p>Good Day Landlord,</p>
							 <br/>
							 <p>It looks like someone's interested in staying at your home. $name has made a reservation and completed the transaction process. Visit the link below to review and confirm their reservation.
							 <br/>
							 <a href='" . LNK_ROOT . "/admin/utilities?view=1'>" . LNK_ROOT . "/admin/utilities?view=1</a>. Thank you!</p>
							 <br/>
							 <p>Regards,</p>
							 <p>AireSoft Daemon</p>
							 <br/>
							 <br/>
							 <hr/>
							 <p>Landlord, this message is an automated email only. Please do not attempt to reply to this email. No one will be able to answer you back. Thank you! :)</p>
							 </body>
							 </html>
							 ";

					sendAdminNotificationEmail($mail_content);
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

    // validate token
    function checkToken($token) {
        global $conn;

        $valid = true;

        $sql = "SELECT * FROM tbl_tenant WHERE token = '$token'";
        $result = mysqli_query($conn, $sql);
        if($rs = $result->fetch_array(MYSQLI_ASSOC)) {
            $valid = false;
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

    // get dates set by the customer
    function getDatesToReserve($tenant_id) {
        global $conn;

        $sql = "SELECT start_date, end_date FROM tbl_tenant WHERE id = $tenant_id";
        $result = mysqli_query($conn, $sql);

        if($rs = $result->fetch_array(MYSQLI_ASSOC)) {
            $dateArray = array($rs['start_date'], $rs['end_date']);
        }

        return $dateArray;
    }

    // check if dates are still available
    function checkDatesAvailability($start_date, $end_date) {
        $unavailability = getUnavailableDates();

        $valid = true;
        for($i = 0; $i < sizeOf($unavailability); $i++) {
            $a_start_date = $unavailability[$i]['StartDate'];
            $a_end_date = $unavailability[$i]['EndDate'];

            $dates = getDates($start_date, $end_date);

            for($j = 0; $j < sizeOf($dates); $j++) {
                $between = isDateBetween($a_start_date, $a_end_date, $dates[$j]);

                if($between) {
                    $i = sizeOf($unavailability);
                    $j = sizeOf($dates);
                    $valid = false;
                }
            }
        }
        return $valid;
    }

    function getUnavailableDates() {
        global $conn;
        $unavailability = null;
        
        $sql = "SELECT * FROM tbl_calendar WHERE is_deleted = 0";
        $result = mysqli_query($conn, $sql);

        $i = 0;
        while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
            $unavailability[$i] = array(
                "ID"=>$rs['id'], 
                "StartDate"=>$rs['start_date'], 
                "EndDate"=>$rs['end_date'],
                "Status"=>$rs['calendar_type'],
                "TID"=>$rs['tenant_id']
            );
            $i++;
        }

        return $unavailability;
    }

    // get all dates between dates
    function getDates($startdate, $enddate) {
        date_default_timezone_set("UTC");
        $dateArray = array();
        $currentdate = $startdate;
        while (strtotime($currentdate) <= strtotime($enddate)) {
            array_push($dateArray, $currentdate);
            $currentdate = date('Y-m-d', strtotime($currentdate . '+ 1 days')) ;
        }
        return $dateArray;
    }

    // check if date is between dates
    function isDateBetween($from, $to, $check) {
        $fDate = strtotime($from);
        $lDate = strtotime($to);
        $cDate = strtotime($check);

        // Comparison of dates
        if(($cDate <= $lDate) && ($cDate >= $fDate)) {
            return true;
        }

        return false;
    }

    // get diff between dates
    function getDateDiff($date1, $date2) {
        $d1 = strtotime($date1);
        $d2 = strtotime($date2);
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $i = 0;

        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $date = date("Y-m-d", $min_date);
            $i++;
        }

        // $date = date("Y-m-d", $min_date) . "<br>";
        // echo $date;

        $min_date = min($d1, $d2);
        $min_date = strtotime("+" . $i . " MONTH", $min_date);
        $diff = ($max_date - $min_date)/(24*60*60);
        
        $interval = array($i, $diff);

        return $interval;
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
        // $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        // Enable SMTP authentication
        $mail->SMTPAuth = EMAIL_SMTP_AUTH;
        // Enable encryption, usually SSL/TLS
        $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;

        // Specify host server
        $mail->Host = EMAIL_SMTP_HOST;
        $mail->Port = EMAIL_SMTP_PORT;
        $mail->Username = EMAIL_SMTP_USERNAME;
        $mail->Password = EMAIL_SMTP_PASSWORD;

        $mail->From = EMAIL_RESERVE_FROM;
        $mail->FromName = EMAIL_RESERVE_FROM_NAME;
        $mail->Subject = EMAIL_RESERVE_SUBJECT;
        $mail->Body = $mail_content;
        $mail->AddAddress($email);
		$mail->AddAttachment("files/contract.pdf", "Tenancy Agreement (DRAFT).pdf");

        if(!$mail->Send()) {
            echo $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    /**
     * Send email to tenant
     */
    function sendAdminNotificationEmail($mail_content) {
        $mail = new PHPMailer();
        // Set mailer to use SMTP
        $mail->IsSMTP();
        $mail->IsHTML();
        //useful for debugging, shows full SMTP errors
        // $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        // Enable SMTP authentication
        $mail->SMTPAuth = EMAIL_SMTP_AUTH;
        // Enable encryption, usually SSL/TLS
        $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;

        // Specify host server
        $mail->Host = EMAIL_SMTP_HOST;
        $mail->Port = EMAIL_SMTP_PORT;
        $mail->Username = EMAIL_SMTP_USERNAME;
        $mail->Password = EMAIL_SMTP_PASSWORD;

        $mail->From = EMAIL_RESERVE_FROM;
        $mail->FromName = EMAIL_RESERVE_FROM_NAME;
        $mail->Subject = EMAIL_RESERVE_SUBJECT;
        $mail->Body = $mail_content;
        $mail->AddAddress(EMAIL_OWNER_ADDRESS);

        if(!$mail->Send()) {
            echo $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }
?>