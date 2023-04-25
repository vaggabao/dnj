<?php
    require_once("../../config/config.php");
    require_once("../classes/Housekeeping.php");
    include("../translations/en.php");

    $hk_id = $_POST['hk_id'];
    $hk = new Housekeeping();
	
	$hk->doneHousekeeping($hk_id);

	
    if ($hk->errors) {
        $content = "<div id='info-edit-error-div' class='alert alert-danger alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($hk->errors as $error) {
            $content .= "<p>" . $error . "</p>";
        }
        $content .= "</div>";
        echo $content;
    } elseif ($hk->messages) {
        $content = "<div id='info-edit-msg-div' class='alert alert-success alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($hk->messages as $message) {
            $content .= "<p>" . $message . "</p>";
        }
        $content .= "</div>";
        echo $content;
    }
?>