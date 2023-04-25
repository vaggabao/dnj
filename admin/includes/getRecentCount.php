<?php
    require_once("../../config/config.php");
    require_once("../classes/Notification.php");
    include("../translations/en.php");

    $notification = new Notification();
    echo $notification->getRecentCount();
?>