<?php
    require_once("../../config/config.php");
    require_once("../classes/guestMessages.php");
    include("../translations/en.php");

    $message_id = $_POST['message_id'];
    $message = new guestMessages();
    $data = $message->getMessageContent($message_id);

    $data = objectToArray($data);
    $count = count($data);

    $msg_id = $data['id'];
    $msg_name = ucwords(strtolower($data['fname'])) . " " . ucwords(strtolower($data['lname']));
    $msg_email = strtolower($data['email']);
    $msg_content = $data['message'];
    $msg_date = date("F d, Y H:i:s a", strtotime($data['message_datetime']));
    $msg_seen = $data['is_seen'];

    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
 
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }
?>

<!-- View message modal -->
<div id="view-message-modal" class="modal fade">
    <div class="modal-dialog">

        <!-- Message content -->
        <div id="message-content-div" class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Message</h4>
            </div>

            <!-- Show message content -->
            <div class="modal-body">
                <div class="message-details">
                    <div class="form-group row">
                        <label class="control-label col-sm-1">From</label>
                        <div class="col-sm-11">
                            <p class="form-control-static"><?php echo $msg_name . " (" . $msg_email . ")"; ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group row">
                        <label class="control-label col-sm-1">Date</label>
                        <div class="col-sm-11">
                            <p class="form-control-static"><?php echo $msg_date; ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group row">
                        <label class="control-label">Content</label>
                        <div class="message-content"><?php echo $msg_content; ?></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="modal-footer">
                <fieldset id="form-view-fieldset">
                    <button id="btn-reply" type="button" class="btn btn-danger" value=<?php echo $msg_id; ?> >Reply</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </fieldset>
            </div><!-- end message content -->
        </div>


        <!-- Reply to message -->
        <div id="reply-content-div" class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Reply...</h4>
            </div>

            <div class="modal-body">
                <div class="message-details">
                    <div class="form-group row">
                        <label class="control-label col-sm-1">To</label>
                        <div class="col-sm-11">
                            <p class="form-control-static"><?php echo $msg_name . " (" . $msg_email . ")"; ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group row">
                        <label class="control-label">Content</label>
                        
                        <div id="alert-div" class="alert alert-danger"></div>

                        <div class="message-content">
                            <textarea id="form-message" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="modal-footer">
                <fieldset id="form-view-fieldset">
                    <!-- <input type="hidden" id="form-email" name="email" value=<?php echo $msg_email; ?> > -->
                    <button id="btn-send" type="button" class="btn btn-danger" value=<?php echo $msg_email; ?> >Send</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </fieldset>
            </div>
        </div><!-- end of reply -->

        <!-- Message has been send -->
        <div id="sent-content-div" class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Message sent...</h4>
            </div>

            <div class="modal-body">
                <div class="message-details">
                    <p>Your message has been sent to <?php echo $msg_name . " (" . $msg_email . ")"; ?>.</p>
                </div>
            </div>

            <div class="modal-footer">
                <fieldset id="form-view-fieldset">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </fieldset>
            </div>
        </div><!-- end of sent -->
    
    </div> <!-- End of dialog -->
</div> <!-- End of modal -->