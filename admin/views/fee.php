<script type="text/javascript">
    $(function() {
        getFees();

        /**
         * Click event for update button
         */
        $(document).on('click', '#btn-update', function() {0
            var data = "[";
            data += $('.fees').map(function(idx, elem) {
                var id = '"id":"' + $(elem).data("id") + '"';
                var amount = '"amount":"' + $(elem).val() + '"';
                var value = "{" + id + "," + amount + "}";
                return value;
            }).get();
            data += "]";
            saveFees(data);
            return false;
        });


        /**
         * Get fee parameters
         */
        function getFees() {
            $.ajax({
                type: 'POST',
                url: 'includes/getFees.php',
                success: function(result) {
                    var content = result;
                    $( '#fee-div' ).html(content);
                }
            });
        }


        /**
         * Save fee parameters
         */
        function saveFees(data) {
            $.ajax({
                type: 'POST',
                data: { 'fee_values' : data},
                url: 'includes/saveFees.php',
                success: function(result) {
                    var content = result;
                    $( '#alert-div' ).html(content);
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
            <li class="active"><a href="utilities?view=5">Fee</a></li>
            <li><a href="utilities?view=6">Transactions</a></li>
            <li><a href="utilities?view=7">My Account</a></li>
        </ul>
    </div>

    <div id="utilities-div" class="col-md-9 form-horizontal">
        <div id="page-title-div">
            <h3>
                <span id="sp-title">Manage Fees</span>
            </h3>
        </div>
        
        <!-- info div -->
        <div id="info-div">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>Any changes in the values of these parameters will only affect future transactions...</p>
                </div>
            </div>
            
            <div id="info-view-div">
                <div id="alert-div"></div>
				
                <div id="fee-table-div">
                    <div id="fee-div"></div>
                </div>
            </div>
        </div> <!-- end of div -->
    </div>
</div>