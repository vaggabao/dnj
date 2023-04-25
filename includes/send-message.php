<?php
	// include config files
	require("../config/config.php");
	require("../config/dbConnect.php");
	require("../config/links.php");
	require("../config/globals.php");

	date_default_timezone_set("Asia/Manila");

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$msg = $_POST['msg'];
	// $msg = nl2br($msg);
	// $msg = strip_tags($msg);
	$msg = mysqli_real_escape_string($conn, $msg);
	$datetime = date("Y-m-d H:i:s");

	$sql = "INSERT INTO tbl_guest_messages (fname, lname, email, phone, message, message_datetime) VALUES('$fname', '$lname', '$email', '$phone', '$msg', '$datetime')";
	$result = mysqli_query($conn, $sql);

	echo $result;
?>