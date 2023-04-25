<script type="text/javascript">
    $(function() {
        var criteria = $( '#form-criteria' ).val();
        var search = $( '#form-search' ).val();
        getTenants(criteria, search);

        /**
         * Form events
         */

        // search box
        $( '#form-search' ).keyup(function() {
            var criteria = $( '#form-criteria' ).val();
            var search = $( '#form-search' ).val();
            getTenants(criteria, search);
        });

        // select box
        $( '#form-criteria' ).on('change', function() {
            var criteria = $( '#form-criteria' ).val();
            var search = $( '#form-search' ).val();
            getTenants(criteria, search);
        });

        // show button
        $( '#btn-show' ).click(function() {
            event.preventDefault();
            criteria = $( '#form-criteria' ).val();
            search = $( '#form-search' ).val();
            getTenants(criteria, search);
        });

        /**
         * Click event for tenant row
         */
        $(document).on('click', '.row-tenant', function() {
            var tenant_id = $(this).attr('data-id');

            viewTenantInfo(tenant_id);
            $( '#sp-title' ).hide('fade', 250);
            $( '#tenant-table-div' ).hide('fade', 250, function() {
                $( '#tenant-info-div' ).show('fade', 250);
            });
        });

        /**
         * Click event for view info button
         */
        $(document).on('click', '.btn-view', function() {
            var tenant_id = $(this).val();

            viewTenantInfo(tenant_id);
            $( '#sp-title' ).hide('fade', 250);
            $( '#tenant-table-div' ).hide('fade', 250, function() {
                $( '#tenant-info-div' ).show('fade', 250);
            });
        });


        /**
         * Click event back button
         */
        $(document).on('click', '.btn-back', function() {
            $( '#tenant-info-div' ).hide('fade', 250, function() {
                $( '#tenant-table-div' ).show('fade', 250);
                $( '#sp-title' ).show('fade', 250);
            });
        });


        /**
         * Click event for delete button
         */
        $(document).on('click', '.btn-delete', function() {
            var tenant_id = $(this).val();

            criteria = $( '#form-criteria' ).val();
            search = $( '#form-search' ).val();

            $.when( deleteTenant(tenant_id) ).done(getTenants(criteria, search));

            $( '#tenant-info-div' ).hide('fade', 250, function() {
                $( '#tenant-table-div' ).show('fade', 250);
                $( '#sp-title' ).show('fade', 250);
            });
        });


        /**
         * Click event for expire button
         */
        $(document).on('click', '.btn-expire', function() {
            var tenant_id = $(this).val();

            criteria = $( '#form-criteria' ).val();
            search = $( '#form-search' ).val();

            $.when( expireAccount(tenant_id) ).done(getTenants(criteria, search));

            $( '#tenant-info-div' ).hide('fade', 250, function() {
                $( '#tenant-table-div' ).show('fade', 250);
                $( '#sp-title' ).show('fade', 250);
            });
        });



        /**
         * Get list of tenants
         */
        function getTenants(criteria, search) {
            var data = "criteria=" + criteria + "&search=" + search;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/getTenants.php',
                success: function(result) {
                    var content = result;
                    $( '#tenant-div' ).html(content);
                }
            });
        }

        /**
         * Get info of selected tenant
         */
        function viewTenantInfo(tenant_id) {
            var data = "id=" + tenant_id;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/getTenantInfo.php',
                success: function(result) {
                    var content = result;
                    $( '#tenant-info-div' ).html(content);
                }
            });
        }


        /**
         * Delete tenant
         */
        function deleteTenant(tenant_id) {
            var data = "id=" + tenant_id;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/deleteTenant.php',
                success: function(result) {
                    var content = result;
                    $( '#alert-div' ).html(content);
                }
            });
        }


        /**
         * Expire tenant account
         */
        function expireAccount(tenant_id) {
            var data = "id=" + tenant_id;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/expireAccount.php',
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
            <li class="active"><a href="utilities?view=4">Tenants</a></li>
            <li><a href="utilities?view=5">Fee</a></li>
            <li><a href="utilities?view=6">Transactions</a></li>
            <li><a href="utilities?view=7">My Account</a></li>
        </ul>
    </div>

    <div id="utilities-div" class="col-md-9 form-horizontal">
        <div id="page-title-div">
            <h3>
                <span id="sp-title">Manage Tenants</span>
            </h3>
        </div>
        
        <!-- info div -->
        <div id="info-div">
            <div id="info-view-div">
                <div id="alert-div"></div>
				
                <div id="tenant-table-div">
    				<div id="filter-div" class="row no-margin">
    					<form role="form" action="" method="POST" class="form-inline">
                            <div class="col-md-10 text-center">
        						<div class="form-group col-md-8">
        							<label for="form-search" class="control-label col-sm-3">Search:</label>
        							<div class="col-sm-9">
        								<input type="text" id="form-search" class="form-control form-text" name="search" value=""/>
        							</div>
        						</div>

        						<div class="form-group col-md-4">
        							<label for="form-criteria" class="control-label col-sm-3">Show:</label>
        							<div class="col-sm-9">
        								<select id="form-criteria" class="form-control form-select text-center" name="criteria">
        									<option value=0>All</option>
                                            <option value=1>Active</option>
                                            <option value=2>New</option>
        									<option value=3>Expired</option>
        								</select>
        							</div>
        						</div>
                            </div>

                            <div class="col-md-2 text-center">
                                <button type="submit" id="btn-show" class="btn btn-default form-btn">Show</button> 
                            </div>
    					</form>
    				</div>

                    <div id="tenant-div"></div>
                </div>

                <div id="tenant-info-div">

                </div>
            </div>
        </div> <!-- end of div -->
    </div>
</div>