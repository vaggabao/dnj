<script type="text/javascript" src=<?php echo LNK_ROOT . "/admin/js/jquery.autogrow-textarea.js"; ?> ></script>
<script type="text/javascript">
    $(function() {
        var position = 0;
        var tenant_id = 0;
        var msgCount = 0;

        $( '#message-textarea' ).autogrow();
        getChatList();

        /**
         * Show message when tenant is selected
         */
        $(document).on('click', '.tenant-row', function() {
            tenant_id = $(this).data('id');
            position = 0;
            $( '.chat-unselected-tenant' ).remove();
            getMsgCount(tenant_id, msgCount);
        });

        /**
         * Send message to tenant
         */
        $(document).on('click', '#btn-send', function() {
            var message = $( '#message-textarea' ).val();

            if (tenant_id != 0 && message) {
                message = message.replace(/(?:\r\n|\r|\n)/g, '<br />');
                sendChat(tenant_id, message);
                $( '#message-textarea' ).val('');
            }
        });


        /**
         * Functions
         */
        function getChatList() {
            $.ajax({
                type: 'POST',
                url: 'includes/getChatList.php',
                success: function(result) {
                    var content = result;
                    $( '#chat-list-div' ).html(content);
                }
            });
        }
        

        /**
         * Get message count
         */
        function getMsgCount() {
            var data = "tenant_id=" + tenant_id + "&count=" + msgCount;
            $.ajax ({
                type: 'POST',
                data: data,
                url: 'includes/getMsgCount.php',
                success: function(result) {
                    if (result == 0) {
                        $content = "<div class='chat-no-messages'>NO MESSAGES FOUND...</div>";
                        $( '#chat-messages-div' ).html(content);
                    }

                    if (result > msgCount) {
                        var count = result - msgCount;
                        msgCount = result;

                        getTenantMessage(tenant_id, count);
                    }
                },
                complete: function() {
                    setTimeout(getMsgCount, 1000);
                }
            });
        }

        function getTenantMessage(tenant_id, count) {
            var data = "tenant_id=" + tenant_id + "&count=" + count;
            $.ajax({
                data: data,
                type: 'POST',
                url: 'includes/getTenantMessage.php',
                success: function(result) {
                    $( '#chat-messages-div' ).append(result);
                    $( '#chat-messages-div' ).scrollTop($( '#chat-messages-div' )[0].scrollHeight);
                }
            });
        }

        function sendChat(tenant_id, message) {
            var data = "tenant_id=" + tenant_id + "&message=" + message;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/sendTenantMessage.php',
                success: function(result) {
                    $( '#chat-messages-div' ).scrollTop($( '#chat-messages-div' )[0].scrollHeight);
                }
            });
        }
    });
</script>

<div id="nav-div">
    <ul class="nav nav-tabs">
        <li><a href="messages?view=1">Guest Messages</a></li>
        <li class="active"><a href="messages?view=2">Tenant Messages</a></li>
        <!-- <li><a href="messages?view=3">Emails</a></li> -->
    </ul>
</div>

<div id="messages-div" class="form-horizontal">
    <!-- <div id="page-title-div" class="page-header">
        <h3>
            <span id="sp-title">Guest Messages</span>
        </h3>
    </div> -->

    <div class="row">
        <!-- List of tenants -->
        <div id="tenant-list-div" class="col-sm-4">
            <div class="panel panel-danger">
                <div id="chat-list-div" class="panel-body">

                </div>
            </div>
        </div>

        <!-- Messages -->
        <div id="messages-list-div" class="col-sm-8">
            <div class="panel panel-danger">
                <div id="chat-messages-div" class="panel-body">
                    <div class="chat-unselected-tenant">SELECT A TENANT FROM THE LIST...</div>
                </div>

                <div class="form-group">
                    <div id="message-text" class="pull-left">
                        <textarea id="message-textarea" class="form-control"></textarea>
                    </div>
                    
                    <button type="submit" id="btn-send" class="btn btn-danger pull-right" name="send">SEND</button>
                </div>
            </div>
        </div>
    </div>
</div>