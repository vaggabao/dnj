<script type="text/javascript">
    $(function() {
        $( window ).resize(function() {
            resizeTable();
        });

        var search = $( '#form-search' ).val();
        getMessages(search);

        $( '#form-search' ).keyup(function() {
            var search = $( '#form-search' ).val();
            getMessages(search);
        });

        $( '#btn-search' ).click(function() {
            event.preventDefault();
            var search = $( '#form-search' ).val();
            getMessages(search);
        });

        $(document).on('click', '.msg-row', function() {
            var message_id = $(this).data('id');
            var read = $(this).data('read');
            var search = $( '#form-search' ).val();

            if (!read) {
                $.when(seenMessages(message_id)).done( getMessages(search) );
            }
            
            viewMessage(message_id);
        });

        /**
         * Show reply form
         */
        // $( '#btn-reply' ).click(function() {
        $(document).on('click', '#btn-reply', function() {
            $( '#message-content-div' ).hide('fade', 250, function() {
                $( '#reply-content-div' ).show('fade', 250);
            });
        });

        /**
         * Event for btn-send
         */
        $(document).on('click', '#btn-send', function() {
            /**
             * Set validation variables
             */

            var valid = true;
            var err = "";

            var email = $( '#btn-send' ).val();
            var content = $( '#form-message' ).val();
			
			content = content.replace(/(?:\r\n|\r|\n)/g, '<br />');

            if (!content) {
                err = "Add content first";
                $( '#alert-div' ).html(err).show('fade', 250);
            } else {
                sendEmail(email, content)
                $( '#reply-content-div' ).hide('fade', 250, function() {
                    $( '#sent-content-div' ).show('fade', 250);
                });
            }
        });

        /**
         * Functions
         */
        function getMessages(search) {
            var data = "search=" + search;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/getGuestMessages.php',
                success: function(result) {
                    var content = result;
                    $( '#message-div' ).html(content);
                },
                complete: function() {
                    resizeTable();
                }
            });
        }

        function seenMessages(message_id) {
            var data = "message_id=" + message_id;
            $.ajax({
                type: 'POST',
                data: data,
                async: false,
                url: 'includes/seenGuestMessages.php'
            });
        }

        function viewMessage(message_id) {
            var data = "message_id=" + message_id;
            $.ajax({
                type: 'POST',
                data: data,
                async: false,
                url: 'includes/getGuestMessageContent.php',
                success: function(result) {
                    var content = result;
                    $( '#view-message-modal-div' ).html(content);
                },
                complete: function() {
                    $( '#view-message-modal' ).modal({
                        show: true
                    });
                }
            });
        }

        function sendEmail(email, content) {
            var data = "email=" + email + "&content=" + content;
            $.ajax({
                type: 'POST',
                data: data,
                async: false,
                url: 'includes/sendGuestEmail.php',
                success: function(result) {
                    if (result == true) {
                        $( '#view-message-modal' ).modal({
                            show: true
                        });
                    } else {
                        $( '#alert-div' ).html("Sending failed. Please try again.").show('fade', 250);
                    }
                }
            });
        }

        function resizeTable() {
            var rowWidth = $( '#message-div' ).width();
            var senderWidth = parseInt(rowWidth * 0.20 - 10);
            var contentWidth = parseInt(rowWidth * 0.53 - 10);
            var dateWidth = parseInt(rowWidth * 0.27 - 10);
            
            $( '.msg-row-sender' ).width(senderWidth + "px");
            $( '.msg-row-content' ).width(contentWidth + "px");
            $( '.msg-row-date' ).width(dateWidth + "px");
        }
    });
</script>

<div id="nav-div">
    <ul class="nav nav-tabs">
        <li class="active"><a href="messages?view=1">Guest Messages</a></li>
        <li><a href="messages?view=2">Tenant Messages</a></li>
        <!-- <li><a href="messages?view=3">Emails</a></li> -->
    </ul>
</div>

<div id="messages-div" class="form-horizontal">
    <div id="page-title-div" class="page-header">
        <h3>
            <span id="sp-title">Guest Messages</span>
        </h3>
    </div>
    
	<div id="filter-div" class="row no-margin">
		<form role="form" method="POST">
			<div class="form-group">
				<label for="form-search" class="control-label col-sm-1">Search</label>
				<div class="form- col-sm-8">
                    <div class="input-group">
                        <input type="text" id="form-search" class="form-control form-text" name="search" value=""/>
                        <span class="input-group-btn button-addon">
                            <button class="btn btn-danger" type="button">Show</button>
                        </span>
                    </div>
				</div>
			</div>
		</form>
	</div>

    <div id="message-div"></div>
</div>