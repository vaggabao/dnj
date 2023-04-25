<?php
    require_once("../../config/config.php");
	require_once("../classes/tenantMessages.php");

	$tenant_id = $_POST['tenant_id'];
	$msg = $_POST['message'];

	$message = new tenantMessages();
	$message->sendMessage($tenant_id, $msg);
?>