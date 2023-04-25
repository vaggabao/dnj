<?php
    require_once("../../config/config.php");
    require_once("../classes/Notification.php");
    include("../translations/en.php");

    $count = $_POST['count'];

    $notification = new Notification();
    $data = $notification->getRecent($count);

    $count = count($data);

    $content = "";
    for ($i = $count - 1; $i >= 0; $i--) {
        $notify_id = $data[$i]['id'];
        $notify_desc = $data[$i]['description'];
        $notify_datetime = date("F d, Y", strtotime($data[$i]['recent_datetime']));

        $row = "<div class='notify-row'>$notify_desc</div>";

        $content .= $row;
    }

    // $result = array($count, $content);

    // echo json_encode($result);
    echo $content;
?>