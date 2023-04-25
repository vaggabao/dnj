<?php
    require_once("../../config/config.php");
    require_once("../classes/tenantMessages.php");
    include("../translations/en.php");

    $tenant_id = $_POST['tenant_id'];

    $message = new tenantMessages();
    echo $message->getMsgCount($tenant_id);
?>