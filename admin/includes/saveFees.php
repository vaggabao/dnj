<?php
    require_once("../../config/config.php");
    require_once("../classes/Fee.php");
    include("../translations/en.php");

    $fee_values = json_decode($_POST['fee_values'], true);

    // initialize fee class
    $fees = new Fee();

    foreach($fee_values as $fee_value) {
        $fee_id = $fee_value['id'];
        $fee_amount = $fee_value['amount'];
        $fees->updateFee($fee_id, $fee_amount);
    }
    
    if ($fees->errors) {
        $content = "<div id='info-edit-error-div' class='alert alert-danger alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($fees->errors as $error) {
            $content .= "<p>" . $error . "</p>";
        }
        $content .= "</div>";
        echo $content;
    } elseif ($fees->messages) {
        $content = "<div id='info-edit-msg-div' class='alert alert-success alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($fees->messages as $message) {
            $content .= "<p>" . $message . "</p>";
        }
        $content .= "</div>";
        echo $content;
    }
?>