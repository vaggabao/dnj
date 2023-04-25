<?php
    include_once("../../config/config.php");
    require_once("../classes/Calendar.php");
    include("../translations/en.php");

    $cid = $_POST['cid'];

    $calendar = new Calendar();

    $result = $calendar->deleteCalendar($cid);

    // $sql = "SELECT calendar_type FROM tbl_calendar WHERE id = $cid";

    // $sql = "UPDATE tbl_calendar SET is_deleted=1 WHERE id=$cid";
    // $result = mysqli_query($conn, $sql);

    if ($calendar->errors) {
        $content = "<div id='info-edit-error-div' class='alert alert-danger alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($calendar->errors as $error) {
            $content .= "<p>" . $error . "</p>";
        }
        $content .= "</div>";
        echo $content;
    } elseif ($calendar->messages) {
        $content = "<div id='info-edit-msg-div' class='alert alert-success alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($calendar->messages as $message) {
            $content .= "<p>" . $message . "</p>";
        }
        $content .= "</div>";
        echo $content;
    }
?>