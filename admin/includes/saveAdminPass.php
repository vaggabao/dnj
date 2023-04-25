<?php
	error_reporting(0);
    require_once("../../config/config.php");
    require_once("../classes/Login.php");
    require_once("../libraries/password_compatibility_library.php");
    include("../translations/en.php");

    // retrieve post variables
    $current = $_POST['current'];
    $password = $_POST['password'];
    $repeat = $_POST['repeat'];

    // initialize Login class
    $login = new Login();
    $login->updatePassword($current, $password, $repeat);
    
    if ($login->errors) {
        $content = "<div id='info-edit-error-div' class='alert alert-warning alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($login->errors as $error) {
            $content .= "<p>" . $error . "</p>";
        }
        $content .= "</div>";
        echo $content;
    } elseif ($login->messages) {
        $content = "<div id='info-edit-msg-div' class='alert alert-success alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($login->messages as $message) {
            $content .= "<p>" . $message . "</p>";
        }
        $content .= "</div>";
        echo $content;
    }
?>