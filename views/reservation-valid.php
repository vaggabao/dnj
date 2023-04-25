<!-- Valid reservation -->

<?php
    $content = "
        <form class='form-horizontal' role='form' method='POST'>
            
            <p class='well'> " . WORD_INVLD_TXT . "</p>
            <div>
                <div class='page-header'>
                    <h4>
                        " . TRANS_INFO . "
                    </h4>
                </div>

                <div class='fields-div'>
                    <div class='form-group'>
                        <label class='control-label col-sm-3'>" . WORD_NAME . "</label>
                        <div class='col-sm-8 col-sm-offset-1'>
                            <p id='form-name' class='form-control-static'><span id='sp-name'>$name</span></p>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label class='control-label col-sm-3'>" . WORD_EMAILADD . "</label>
                        <div class='col-sm-8 col-sm-offset-1'>
                            <p id='form-email' class='form-control-static'><span id='sp-email'>$email</span></p>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label class='control-label col-sm-3'>" . WORD_DTERSRV . "</label>
                        <div class='col-sm-8 col-sm-offset-1'>
                            <p id='form-date' class='form-control-static'><span id='sp-date'>$stay_date</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class='page-header'>
                    <h4>
                        " . WORD_PRICESUM . "
                    </h4>
                </div>

                <div class='fields-div'>
                    <div class='form-group'>
                        <p class='pull-left'><span id='sp-item-name'>$description</span></p>
                        <p class='pull-right'>&#8369; <span id='sp-item-cost'>$amount</span></p>
                        <div class='clearfix'></div>
                    </div>
                </div>
            </div>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <div class='fields-div text-right'>
                <button class='btn btn-primary btn-sm' id='btn-pay' name='pay'>" . WORD_PAYNOW . "</button>
                <a href='" . PP_RESERVE_CANCEL_URL . '/' . $token . "' class='btn btn-danger btn-sm' id='btn-cancel'>" . WORD_CANCEL . "</a>
            </div>
        </form>
    ";

    if ( isset($_POST['pay']) ) {
        $available = checkDatesAvailability($start_date, $end_date);
        
        if ($available) {
            // get date difference
            $interval = getDateDiff($start_date, $end_date);
            $nummonths = $interval[0];
            $numdays = $interval[1];

            // set item value
            if($nummonths >= 1) {
                $item_name = SHORT_TERM_DESCRIPTION;
                $item_amount = SHORT_TERM_FEE;
                $rent_term = "long";
            } else {
                $item_name = LONG_TERM_DESCRIPTION;
                $item_amount = LONG_TERM_FEE;
                $rent_term = "short";
            }

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

            echo $querystring;

            // Redirect to paypal IPN
            header('location: ' . PP_URL . $querystring);
            exit();
        } else {
            $sql = "DELETE t, tr FROM tbl_tenant t, tbl_transaction tr WHERE t.id = tr.tenant_id AND token = '$token'";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_affected_rows($result);

            $content = "<p class='well'>" . WORD_PENDRSRVTXT . "<a href='" . LNK_ROOT . "/reservation" . "'>" . WORD_HERE . "</a></p>";
        }
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
?>

<!-- tenant form div -->
<div id="reservation-div">
    <div id="page-title-div" class="text-center">
        <h3>
            <?php echo WORD_PENDRSRV; ?>
        </h3>
    </div>

    <?php
        echo $content;
    ?>

</div> <!-- end of div -->