<?php
    require_once("../../config/config.php");
    require_once("../classes/tenantMessages.php");
    include("../translations/en.php");

    $message = new tenantMessages();

    $tenant_id = $_POST['tenant_id'];
    $count = $_POST['count'];

    $data = $message->getMessage($tenant_id, $count);

    $count = count($data);
    $chat_content = "";

    for ($i =  $count - 1; $i >= 0; $i--) {
        $msg_id = $data[$i]['id'];
        $msg_to = $data[$i]['send_to'];
        $msg_date = date("F d, Y H:i:s a", strtotime($data[$i]['message_datetime']));
        $msg_content = $data[$i]['message'];
        $msg_seen = $data[$i]['is_seen'];

        if ($msg_to == "admin") {
            // chat to admin
            $content = "
                        <div class='chat-tenant-message'>$msg_content</div>
                        <div class='clearfix'></div>
            ";
        } else if ($msg_to == "tenant" ) {
            // chat to tenant
            $content = "
                        <div class='chat-admin-message'>$msg_content</div>
                        <div class='clearfix'></div>
            ";
        }

        $chat_content .= $content;
    }

    if ($count == 0) {

        // chat to tenant
        $content = "<div class='chat-no-messages'>NO MESSAGES FOUND...</div>";

        $chat_content .= $content;
    }

    // $result = array($chat_content, $count);

    // echo json_encode($result);

    echo $chat_content;
?>