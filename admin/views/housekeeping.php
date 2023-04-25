<script type="text/javascript">
    $(function() {
        $( '#form-search' ).keyup(function() {
            var criteria = $( '#form-criteria' ).val();
            var search = $( '#form-search' ).val();
            getHousekeeping(criteria, search);
        });

        $(document).on('change', '#form-criteria', function() {
            var criteria = $( '#form-criteria' ).val();
            var search = $( '#form-search' ).val();
            getHousekeeping(criteria, search);
        });

        var criteria = $( '#form-criteria' ).val();
        var search = $( '#form-search' ).val();
        getHousekeeping(criteria, search);

        $( '#btn-show' ).click(function() {
            event.preventDefault();
            criteria = $( '#form-criteria' ).val();
            search = $( '#form-search' ).val();
            getHousekeeping(criteria, search);
        });

        $(document).on('click', '.btn-done', function() {
            var e = event.target;
            var hk_id = $(e).val();

            criteria = $( '#form-criteria' ).val();
            search = $( '#form-search' ).val();
            
            $.when( doneHousekeeping(hk_id) ).done(getHousekeeping(criteria, search));
        });

        $(document).on('click', '.btn-cancel', function() {
            var e = event.target;
            var hk_id = $(e).val();

            criteria = $( '#form-criteria' ).val();
            search = $( '#form-search' ).val();

            $.when( cancelHousekeeping(hk_id) ).done(getHousekeeping(criteria, search));
        });

        function getHousekeeping(criteria, search) {
            var data = "criteria=" + criteria + "&search=" + search;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/getHousekeeping.php',
                success: function(result) {
                    var content = result;
                    $( '#housekeeping-div' ).html(content);
                }
            });
        }

        function doneHousekeeping(hk_id) {
            var data = "hk_id=" + hk_id;
            $.ajax({
                type: 'POST',
                data: data,
                async: false,
                url: 'includes/doneHousekeeping.php',
                success: function(result) {
                    var content = result;
                    $( '#alert-div' ).html(content);
                }
            });
        }

        function cancelHousekeeping(hk_id) {
            var data = "hk_id=" + hk_id;
            $.ajax({
                type: 'POST',
                data: data,
                async: false,
                url: 'includes/cancelHousekeeping.php',
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
            <li class="active"><a href="utilities?view=3">Cleaning</a></li>
            <li><a href="utilities?view=4">Tenants</a></li>
            <li><a href="utilities?view=5">Fee</a></li>
            <li><a href="utilities?view=6">Transactions</a></li>
            <li><a href="utilities?view=7">My Account</a></li>
        </ul>
    </div>

    <div id="utilities-div" class="col-md-9 form-horizontal">
        <div id="page-title-div">
            <h3>
                <span id="sp-title">Manage Cleaning Requests</span>
            </h3>
        </div>
        
        <!-- info div -->
        <div id="info-div">
            <div id="info-view-div">
                <div id="alert-div"></div>
				
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
    									<option value=1>New</option>
    									<option value=2>Done</option>
                                        <option value=3>Not Yet Done</option>
    									<option value=4>Cancelled</option>
    								</select>
    							</div>
    						</div>
                        </div>

                        <div class="col-md-2 text-center">
                            <button type="submit" id="btn-show" class="btn btn-default form-btn">Show</button> 
                        </div>
					</form>
				</div>

                <div id="housekeeping-div"></div>
            </div>
        </div> <!-- end of div -->
    </div>
</div>