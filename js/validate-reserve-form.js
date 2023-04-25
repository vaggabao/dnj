$(function() {
    $( '#btn-reserve' ).click(function() {
        var email_regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        // var phone_regex = new RegExp("^[0-9]{10}$");
        var fname = $( '#form-fname' ).val();
        var lname = $( '#form-lname' ).val();
        var phone = $( '#form-phone' ).val();
        var email = $( '#form-email' ).val();
        var confirm = $( '#form-confirm' ).val();
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

        // emails do not match
        } else if (confirm && !(confirm == email) ) {
            err = "Email addresses do not match.";
            valid = false;

        // email confirm is empty
        } else if (!confirm) {
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
        }

        // not valid
        if (!valid) {
            $( '#alert-div' ).html(err).hide().show('fade', 500);
            return false;
        }
    });
});