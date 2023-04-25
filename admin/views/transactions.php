<script type="text/javascript">
    $(function() {
        $( '#form-search' ).keyup(function() {
            var criteria = $( '#form-criteria' ).val();
            var search = $( '#form-search' ).val();
            getTransactions(criteria, search);
        });

        $(document).on('change', '#form-criteria', function() {
            var criteria = $( '#form-criteria' ).val();
            var search = $( '#form-search' ).val();
            getTransactions(criteria, search);
        });

        var criteria = $( '#form-criteria' ).val();
        var search = $( '#form-search' ).val();
        getTransactions(criteria, search);

        $( '#btn-show' ).click(function() {
            event.preventDefault();
            criteria = $( '#form-criteria' ).val();
            search = $( '#form-search' ).val();
            getTransactions(criteria, search);
        });


        function getTransactions(criteria, search) {
            var data = "criteria=" + criteria + "&search=" + search;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/getTransactions.php',
                success: function(result) {
                    var content = result;
                    $( '#transactions-div' ).html(content);
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
            <li class="active"><a href="utilities?view=6">Transactions</a></li>
            <li><a href="utilities?view=7">My Account</a></li>
        </ul>
    </div>

    <div id="utilities-div" class="col-md-9 form-horizontal">
        <div id="page-title-div">
            <h3>
                <span id="sp-title">Transactions</span>
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
    									<option value=1>Completed</option>
    									<option value=2>Pending</option>
    								</select>
    							</div>
    						</div>
                        </div>

                        <div class="col-md-2 text-center">
                            <button type="submit" id="btn-show" class="btn btn-default form-btn">Show</button> 
                        </div>
					</form>
				</div>

                <div id="transactions-div"></div>
            </div>
        </div> <!-- end of div -->
    </div>
</div>