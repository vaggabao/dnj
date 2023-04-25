<?php
    require_once("../config/config.php");
    require_once("../config/dbConnect.php");
    require_once("../config/links.php");
    require_once("../config/globals.php");

	$start_date = $_GET['sdate'];
	$end_date = $_GET['edate'];

	// get date difference
	$interval = getDateDiff($start_date, $end_date);
	$nummonths = $interval[0];
	$numdays = $interval[1];

	// set item value
	if($nummonths < 1) {
	    $item_name = SHORT_TERM_DESCRIPTION;
	    $item_amount = SHORT_TERM_FEE;
	    $rent_term = "short";
	} else {
	    $item_name = LONG_TERM_DESCRIPTION;
	    $item_amount = LONG_TERM_FEE;
	    $rent_term = "long";
	}

	$pricing = array($item_name, $item_amount);
	echo json_encode($pricing);

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

        $min_date = min($d1, $d2);
        $min_date = strtotime("+" . $i . " MONTH", $min_date);
        $diff = ($max_date - $min_date)/(24*60*60);
        
        $interval = array($i, $diff);

        return $interval;
    }
?>