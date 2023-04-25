$(function() {
    var position = 0;
    var msgCount = 0;

    getMsgCount();

    /**
     * Send message to tenant
     */
    $(document).on('click', '#btn-send', function() {
        var message = $( '#message-textarea' ).val();
		
		if (message) {
			message = message.replace(/(?:\r\n|\r|\n)/g, '<br />');
			sendChat(tenant_id, message);
			$( '#message-textarea' ).val('');
		}
    });

    /**
     * Get message count
     */
    function getMsgCount() {
        var data = "tenant_id=" + tenant_id + "&count=" + msgCount;

        $.ajax ({
            type: 'POST',
            data: data,
            url: '../includes/getMsgCount.php',
            success: function(result) {
                if (result > msgCount) {
                    var count = result - msgCount;
                    msgCount = result;

                    getMessage(tenant_id, count);
                }
            },
            complete: function() {
                setTimeout(getMsgCount, 1000);
            }
        });
    }

    function getMessage(tenant_id, count) {
        var data = "tenant_id=" + tenant_id + "&count=" + count;
        $.ajax({
            data: data,
            type: 'POST',
            url: '../includes/getMessage.php',
            success: function(result) {
                $( '#chat-div' ).append(result);
                $( '#chat-div' ).scrollTop($( '#chat-div' )[0].scrollHeight);
            }
        });
    }

    function sendChat(tenant_id, message) {
        var data = "tenant_id=" + tenant_id + "&message=" + message;
        $.ajax({
            type: 'POST',
            data: data,
            url: '../includes/sendMessage.php',
            success: function(result) {
                $( '#chat-div' ).scrollTop($( '#chat-div' )[0].scrollHeight);
            }
        });
    }
});