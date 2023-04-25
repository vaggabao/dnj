<?php
    require_once("../../config/config.php");
    require_once("../classes/guestMessages.php");
    include("../translations/en.php");

    $search = $_POST['search'];
    $message = new guestMessages();
    $data = $message->getMessages($search);


    // $data = objectToArray($data);
    $count = count($data);

    $msg_table = "<table id='msg-table' class='table'>";
    $msg_table_headers = "<tr><th>Sender</th><th>Message</th><th>Date</th></tr>";
    $msg_table .= $msg_table_headers;

    $msg_table_mobile = "<div id='msg-table-mobile'><h3>Requests</h3><br>";

    for ($i = 0; $i < $count; $i++) {
        $msg_id = $data[$i]['id'];
        $msg_name = ucwords(strtolower($data[$i]['fname'])) . " " . ucwords(strtolower($data[$i]['lname']));
        $msg_date = date("F d, Y H:i:s a", strtotime($data[$i]['message_datetime']));
        $msg_content = $data[$i]['message'];
        $msg_content = str_replace("<br />", " ", $msg_content);
        $msg_seen = $data[$i]['is_seen'];

        if ($msg_seen == 0) {
            // unread
            $row = "<tr class='msg-row msg-row-unread' data-id=$msg_id data-read=$msg_seen>
                        <td><div class='msg-row-sender'>$msg_name</div></td>
                        <td><div class='msg-row-content'>$msg_content</div></td>
                        <td><div class='msg-row-date'>$msg_date</div></td>
                    </tr>";

            $mrow = "<div class='msg-row-mobile'>
                        <div class='text-right'><small><i>$msg_date</i></small></div>
                        <div>$msg_name</div>
                    </div>";
        } else if ($msg_seen == 1 ) {
            // read
            $row = "<tr class='msg-row' data-id=$msg_id data-read=$msg_seen>
                        <td><div class='msg-row-sender'>$msg_name</div></td>
                        <td><div class='msg-row-content'>$msg_content</div></td>
                        <td><div class='msg-row-date'>$msg_date</div></td>
                    </tr>";

            $mrow = "<div class='msg-row-mobile'>
                        <div class='text-right'><small><i>$msg_date</i></small></div>
                        <div>$msg_name</div>
                    </div>";
        }

        $msg_table .= $row;
        $msg_table_mobile .= $mrow;
    }

    if ($count == 0) {
        $row = "<tr>
                    <td colspan=3 class=text-center>No messages found</td>
                </tr>";

        $mrow = "<div class='msg-row-mobile text-center'>
                    <p>No messages found</p>
                </div>";
        $msg_table .= $row;
        $msg_table_mobile .= $mrow;
    }

    $msg_table .= "</table>";
    $msg_table_mobile .= "</div>";

    $content = $msg_table . $msg_table_mobile;

    echo $content;
?>