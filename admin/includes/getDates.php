<?php
    require_once("../../config/config.php");
    require_once("../../config/dbConnect.php");

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
    mysqli_close($conn);
    
    echo json_encode($availability);
?>