<?php
    include_once("../../config/config.php");
    include_once("../../config/dbConnect.php");

    $start = $_POST['start_date'];
    $start = date("Y-m-d", strtotime($start));
    $end = $_POST['end_date'];
    $end = date("Y-m-d", strtotime($end));
    $status = $_POST['status'];

    $valid = checkDatesAvailability($start, $end);

    if($valid) {
        $sql = "INSERT INTO tbl_calendar VALUES(null, 0, '$start', '$end', '$status', 0)";
        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);

        echo $result;
    } else {
        echo "The selected dates are no longer available";
    }

    // check if dates are still available
    function checkDatesAvailability($start, $end) {
        $availability = getDatesFromDb();
        $valid = true;
        $dates = getDates($start, $end);
        for($i = 0; $i < sizeOf($availability); $i++) {
            $startdate = $availability[$i]['StartDate'];
            $enddate = $availability[$i]['EndDate'];

            for($j = 0; $j < sizeOf($dates); $j++) {
                $between = isDateBetween($startdate, $enddate, $dates[$j]);
                if($between) {
                    $i = sizeOf($availability);
                    $j = sizeOf($dates);
                    $valid = false;
                }
            }
        }
        return $valid;
    }

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

    function getDatesFromDb() {
        global $conn;
        $sql = "SELECT * FROM tbl_calendar WHERE is_deleted = 0";
        $result = mysqli_query($conn, $sql);

        $i = 0;
        while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
            $availability[$i] = array(
                "ID"=>$rs['id'], 
                "StartDate"=>$rs['start_date'], 
                "EndDate"=>$rs['end_date'],
                "Status"=>$rs['calendar_type'],
                "TID"=>$rs['tenant_id']
            );
            $i++;
        }
        return $availability;
    }
?>