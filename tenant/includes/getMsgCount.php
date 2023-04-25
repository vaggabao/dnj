<?php
    require_once("../../config/config.php");
    require_once("../classes/Messages.php");
    include("../translations/en.php");

    $tenant_id = $_POST['tenant_id'];

    $message = new Messages();
    echo $message->getMsgCount($tenant_id);
?>