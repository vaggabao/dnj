/**
 *	Script for sending message to administrator
 */

$(function() {
	$( '#btn-send' ).click(function() {
		/**
		 * Set regex for validations
		 */
        var email_regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        // var phone_regex = new RegExp("^[0-9]{10}$");

		/**
		 * Get fields values
		 */
		var fname = $( '#send-fname' ).val();
		var lname = $( '#send-lname' ).val();
		var email = $( '#send-email' ).val();
		var phone = $( '#send-phone' ).val();
		var msg = $( '#send-msg' ).val();

		msg = msg.replace(/(?:\r\n|\r|\n)/g, '<br />');

		/**
		 * Set validation variables
		 */
        var valid = true;
        var err = "";

        // fname is empty
        if (!fname) {
            err = "Please fill up all fields.";
            valid = false;

        // lname is empty
        } else if (!lname) {
            err = "Please fill up all fields.";
            valid = false;

        // email is invalid
        } else if (email && !email_regex.test(email)) {
            err = "Email address is not valid.";
            valid = false;

        // email is empty
        } else if (!email) {
            err = "Please fill up all fields.";
            valid = false;

        // invalid phone number
        // } else if (phone && !phone_regex.test(phone)) {
            // err = "Phone number invalid.";
            // valid = false;

        // phone number is empty
        } else if (!phone) {
            err = "Please fill up all fields.";
            valid = false;

        // message is empty
        } else if (!msg) {
            err = "Please fill up all fields.";
            valid = false;
        }

        // not valid
        if (!valid) {
			$( '#send-alert-success' ).hide('fade', 250, function() {
				$( '#send-alert-failed' ).html(err).show('fade', 250);
			});
        } else {
			var data = "fname=" + fname + "&lname=" + lname + "&email=" + email + "&phone=" + phone + "&msg=" + msg;
			$.ajax({
				type: 'POST',
				data: data,
				url: "includes/send-message.php",
				async: false,
				success: function(result) {
					if (result == true) {
						$( '#send-alert-failed' ).hide('fade', 250, function() {
							$( '#send-alert-success' ).html("Your message has been sent. Our reply will be sent on the email address you set.").show('fade', 250);
						});
    					clearFields();
					} else {
						$( '#send-alert-success' ).hide('fade', 250, function() {
							$( '#send-alert-failed' ).html("Sending failed. Please try again.").show('fade', 250);
						});
					}
				},
				error: function() {
					$( '#send-alert-success' ).hide('fade', 250, function() {
						$( '#send-alert-failed' ).html("Sending failed. Please try again.").show('fade', 250);
					});
				}
			});
        }
		event.preventDefault();
	});

	function clearFields() {
		$( '#send-fname' ).val('');
		$( '#send-lname' ).val('');
		$( '#send-email' ).val('');
		$( '#send-phone' ).val('');
		$( '#send-msg' ).val('');
	}
});