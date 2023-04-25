$(function() {
    $( '#btn-register' ).click(function() {
        var pass_regex = new RegExp("^[a-zA-Z0-9]{6,15}$");
        var password = $( '#form-password' ).val();
        var retype = $( '#form-confirm' ).val();
        var fname = $( '#form-fname' ).val();
        var lname = $( '#form-lname' ).val();
        var phone = $( '#form-phone' ).intlTelInput("getCleanNumber");
        var valid = true;
        var err = "";
		
        if (!password || !retype || !fname || !lname || !phone) {
            err = err_fields_empty;
            valid = false;
		} else if (password && !pass_regex.test(password)) {
            err = err_passwords_req;
            valid = false;
        } else if (retype && !(retype == password) ) {
            err = err_passwords_unmatch;
            valid = false;
        }

        if (!valid) {
            $( '#alerts-div' ).remove();
            $( '#alert-div' ).html(err).hide().show('fade', 500);
            return false;
        }
    });
});