<?php
    require_once("../../config/config.php");
    require_once("../classes/Tenant.php");
    include("../translations/en.php");

    $tenant_id = $_POST['id'];
    $tenant = new Tenant();
	
	$tenant->expireAccount($tenant_id);

	
    if ($tenant->errors) {
        $content = "<div id='info-edit-error-div' class='alert alert-danger alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($tenant->errors as $error) {
            $content .= "<p>" . $error . "</p>";
        }
        $content .= "</div>";
        echo $content;
    } elseif ($tenant->messages) {
        $content = "<div id='info-edit-msg-div' class='alert alert-success alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($tenant->messages as $message) {
            $content .= "<p>" . $message . "</p>";
        }
        $content .= "</div>";
        echo $content;
    }

?>