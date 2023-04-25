<?php
	if ( isset($_POST['lang']) ) {
		$lang = $_POST['lang'];
		setcookie("lang", $lang, time() + 60*60*24*30, "/");
		header("Location: " . $_SERVER['REQUEST_URI']);
	}
?>