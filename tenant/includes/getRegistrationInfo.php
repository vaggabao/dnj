<?php
    include_once "../config/config.php";
    include_once "../config/dbConnect.php";

    $token = $_GET['k'];

    $sql = "SELECT * FROM tbl_tenant WHERE token LIKE '$token'";
    $result = mysqli_query($conn, $sql);

    if ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
        $fname = $rs['fname'];
        $lname = $rs['lname'];
        $email = $rs['email'];
        $phone = $rs['phone'];
        $start_date = strtotime($rs['start_date']);
        $end_date = strtotime($rs['end_date']);
        $rent_type = $rs['rent_type'];
        $rent_term = $rs['rent_term'];   
    }
?>