<?php
    require_once("../../config/config.php");
    require_once("../classes/guestMessages.php");
    include("../translations/en.php");

    $message_id = $_POST['message_id'];

    $message = new guestMessages();
    $message->seenMessage($message_id);
?>