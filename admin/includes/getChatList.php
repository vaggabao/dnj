<?php
    require_once("../../config/config.php");
    require_once("../classes/tenantMessages.php");
    include("../translations/en.php");

    $message = new tenantMessages();
    $data = $message->getChatList();
    
    $count = count($data);

    $chat_list = "";
    for ($i = 0; $i < $count; $i++) {
        $msg_id = $data[$i]['id'];
        $msg_name = ucwords(strtolower($data[$i]['name']));

        $content = "<div class='tenant-row' data-id=$msg_id>
                    <p>$msg_name</p>
                    </div>
        ";

        $chat_list .= $content;
    }

    if ($count == 0) {

        // chat to tenant
        $content = "
                    <div class='chat-no-tenant'>NO TENANTS FOUND...</div>
        ";
        
        $chat_list .= $content;
    }


    echo $chat_list;
?>