<?php
    require_once("../../config/config.php");
	require_once("../classes/Messages.php");

	$tenant_id = $_POST['tenant_id'];
	$msg = $_POST['message'];

	$message = new Messages();
	$message->sendMessage($tenant_id, $msg);
?>