<script type="text/javascript">
    $(function() {
        getInfo();

        /**
         * Click event for update account
         */
        $(document).on('click', '#btn-update-account', function() {
            $( '#account-info' ).hide('fade', 250, function() {
                $( '#account-edit' ).show('fade', 250);
            });
        });

        /**
         * Click event for back button
         */
        $(document).on('click', '#btn-back', function() {
            $( '#account-edit' ).hide('fade', 250, function() {
                $( '#account-info' ).show('fade', 250);
            });
        });

        /**
         * Click event for info update button
         */
        $(document).on('click', '#btn-update-info', function() {
            event.preventDefault();
            var fname = $( '#form-fname' ).val();
            var lname = $( '#form-lname' ).val();
            var username = $( '#form-uname' ).val();
            saveAdminInfo(fname, lname, username);
        });

        /**
         * Click event for password update button
         */
        $(document).on('click', '#btn-update-pass', function() {
            event.preventDefault();
            var current = $( '#form-current' ).val();
            var password = $( '#form-password' ).val();
            var repeat = $( '#form-repeat' ).val();
            saveAdminPass(current, password, repeat);
        });



        /**
         * Get admin information
         */
        function getInfo() {
            $.ajax({
                type: 'POST',
                url: 'includes/getAdminInfo.php',
                success: function(result) {
                    var content = result;
                    $( '#info-view-div' ).html(content);
                }
            });
        }


        /**
         * Save admin info
         */
        function saveAdminInfo(fname, lname, username) {
            var data = "fname=" + fname + "&lname=" + lname + "&username=" + username;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/saveAdminInfo.php',
                success: function(result) {
                    var content = result;
                    $( '#alert-info-div' ).html(content);
                }
            });
        }


        /**
         * Save admin pass
         */
        function saveAdminPass(current, password, repeat) {
            var data = "current=" + current + "&password=" + password + "&repeat=" + repeat;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/saveAdminPass.php',
                success: function(result) {
                    var content = result;
                    $( '#alert-pass-div' ).html(content);
                }
            });
        }


    });
</script>

<div class="row">
    <div id="sidebar-div" class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            <li><a href="utilities?view=1">Reservations</a></li>
            <li><a href="utilities?view=2">Extensions</a></li>
            <li><a href="utilities?view=3">Cleaning</a></li>
            <li><a href="utilities?view=4">Tenants</a></li>
            <li><a href="utilities?view=5">Fee</a></li>
            <li><a href="utilities?view=6">Transactions</a></li>
            <li class="active"><a href="utilities?view=7">My Account</a></li>
        </ul>
    </div>

    <div id="utilities-div" class="col-md-9 form-horizontal">
        <!-- <div id="page-title-div">
            <h3>
                <span id="sp-title">My Account</span>
            </h3>
        </div> -->
        
        <!-- info div -->
        <div id="info-div">
            <div id="info-view-div"></div>
        </div> <!-- end of div -->
    </div>
</div>