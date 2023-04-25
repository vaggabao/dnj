<script type="text/javascript">
    $(function() {
        $( '#form-search' ).keyup(function() {
            var search = $( '#form-search' ).val();
            getReservations(search);
        });

        var search = $( '#form-search' ).val();
        getReservations(search);

        $( '#btn-show' ).click(function() {
            event.preventDefault();
            search = $( '#form-search' ).val();
            getReservations(search);
        });

        $(document).on('click', '.btn-confirm', function() {
            var e = event.target;
            var tenant_id = $(e).val();
            var rent_fee = $(e).data('fee');
            var term = $(e).data('term');
            var content = "";
            search = $( '#form-search' ).val();

            if (term == "SHORT") {
                content = "<p>Enter the whole price of their stay.</p><br /><label for='rent-fee' class=control-label>Rent Fee:</label><div class='input-group'><div class='input-group-addon currency-addon'>&#8369;</div><input type='text' id='rent-fee' class='form-control form-text' name='rent_fee' value=" + rent_fee +" /></div>";
            } else {
                content = "<p>Enter the price of monthly rent <strong>ONLY</strong>. Please <strong>DO NOT</strong> include other fees to the cost, such as association dues, as those fees will be added automatically on the tenant's monthly billing.</p><br /><label for='rent-fee' class=control-label>Rent Fee:</label><div class='input-group'><div class='input-group-addon currency-addon'>&#8369;</div><input type='text' id='rent-fee' class='form-control form-text' name='rent_fee' value=" + rent_fee +" /></div>";
            }
            $( '#btn-reserve' ).val(tenant_id);
            $( '#confirm-modal .modal-body' ).html(content);
            $( '#confirm-modal' ).modal('show');
        });

        $(document).on('click', '#btn-reserve', function() {
            var e = event.target;
            var tenant_id = $(e).val();
            var fee_amount = $( '#rent-fee' ).val();

            $.when( confirmReservation(tenant_id, fee_amount) ).done( getReservations(search) );
        });

        function getReservations(search) {
            var data = "search=" + search;
            $.ajax({
                type: 'POST',
                data: data,
                url: 'includes/getReservations.php',
                success: function(result) {
                    var content = result;
                    $( '#reservations-div' ).html(content);
                }
            });
        }

        function confirmReservation(tenant_id, fee_amount) {
            var data = "tenant_id=" + tenant_id + "&rent_fee=" + fee_amount;
            $.ajax({
                type: 'POST',
                data: data,
                async: false,
                url: 'includes/confirmReservation.php',
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
            <li class="active"><a href="utilities?view=1">Reservations</a></li>
            <li><a href="utilities?view=2">Extensions</a></li>
            <li><a href="utilities?view=3">Cleaning</a></li>
            <li><a href="utilities?view=4">Tenants</a></li>
            <li><a href="utilities?view=5">Fee</a></li>
            <li><a href="utilities?view=6">Transactions</a></li>
            <li><a href="utilities?view=7">My Account</a></li>
        </ul>
    </div>

    <div id="utilities-div" class="col-md-9 form-horizontal">
        <div id="page-title-div">
            <h3>
                <span id="sp-title">Confirm Reservations</span>
            </h3>
        </div>
        
        <!-- info div -->
        <div id="info-div">
            <div id="info-view-div">
                <div id="alert-div"></div>
				
				<div id="filter-div">
					<div class="form-group no-margin">
						<label for="form-search" class="control-label col-sm-2">Search:</label>
						<div class="col-sm-9">
							<input type="text" id="form-search" class="form-control form-text" name="search" value=""/>
						</div>
					</div>

				</div>

                <div id="reservations-div"></div>
            </div>
        </div> <!-- end of div -->
    </div>
</div>