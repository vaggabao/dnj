<?php

    // include the config
    require_once("../../config/config.php");

    // include dbConnect
    require_once("../../config/dbConnect.php");

    // include links
    require_once("../../config/links.php");

    // include globals
    require_once("../../config/globals.php");

    // require Extension class
    require_once("../classes/Extensions.php");

    // include translation
    include("../translations/en.php");

    $extension_id = $_POST['extension_id'];
    $extension = new Extension();
	
	$extension->acceptExtension($extension_id);

	
    if ($extension->errors) {
        $content = "<div id='info-edit-error-div' class='alert alert-danger alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($extension->errors as $error) {
            $content .= "<p>" . $error . "</p>";
        }
        $content .= "</div>";
        echo $content;
    } elseif ($extension->messages) {
        $content = "<div id='info-edit-msg-div' class='alert alert-success alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($extension->messages as $message) {
            $content .= "<p>" . $message . "</p>";
        }
        $content .= "</div>";
        echo $content;
    }

?>