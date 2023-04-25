<?php
    require_once("../../config/config.php");
    require_once("../classes/Tenant.php");
    include("../translations/en.php");

    // get post data
	$tenant_id = $_POST['id'];

	// declare a Tenant class
	$tenant = new Tenant();


	// call getTenantInfo
	$tenant_info = $tenant->getTenantInfo($tenant_id);
    $tenant_info = objectToArray($tenant_info);

    // personal info
    $tenant_name = ucwords(strtolower($tenant_info['fname'])) . " " . ucwords(strtolower($tenant_info['lname']));
    $tenant_email = strtolower($tenant_info['email']);
    $tenant_phone = $tenant_info['phone'];

    // rent info
    $tenant_arrive = date("F d, Y", strtotime($tenant_info['start_date']));
    $tenant_depart = date("F d, Y", strtotime($tenant_info['end_date']));
    $tenant_term = $tenant_info['rent_term'];

    // account info
    $tenant_verified = ($tenant_info['is_verified'] == 0 ? "NO" : "YES");
    $tenant_expired = ($tenant_info['is_expired'] == 0 ? "NO" : "YES");
    $tenant_registered = ($tenant_info['is_registered'] == 0 ? "NO" : "YES");
    $tenant_active = ($tenant_info['is_active'] == 0 ? "INACTIVE" : "ACTIVE");
	if ($tenant_info['is_reserved'] == 0) {
		$tenant_reserved = "PENDING";
	} else if ($tenant_info['is_reserved'] == 1) {
		$tenant_reserved = "RESERVED";
	} else if ($tenant_info['is_reserved'] == 2) {
		$tenant_reserved = "CONFIRMED";
	}


	// call getBillingInfo
	$tenant_billing = $tenant->getBillingInfo($tenant_id);
	$count = count($tenant_billing);

    $billing_table_mobile = "<div id='billing-table-mobile'>";

	for ($i=0; $i < $count; $i++) {
        $billing_description = $tenant_billing[$i]['description'];
        $billing_amount = $tenant_billing[$i]['amount'];
        $billing_status = strtoupper($tenant_billing[$i]['payment_status']);
        $billing_due = date("F d, Y", strtotime($tenant_billing[$i]['due_date']));
				
		$mrow = "<div class='billing-row-mobile'>
					<p><strong>Description:</strong> $billing_description</p>
					<p><strong>Amount:</strong> &#8369;$billing_amount</p>
					<p><strong>Due Date:</strong> $billing_due</p>
					<p><strong>Payment Status:</strong> $billing_status</p>
				</div>
		";
		
		$billing_table_mobile .= $mrow;
	}
	
	if ( $count == 0 ) {
		$mrow = "<div class='billing-row-mobile'>
					No billing periods for this tenant yet. The tenant is either not confirmed or haven't completed the reservation transaction yet.
				</div>
		";
		
		$billing_table_mobile .= $mrow;
	}
	
	$billing_table_mobile .= "</div>";



    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
 
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }
?>

<div>
	<div class="pull-left">
		<button class="btn btn-default btn-sm btn-back">Back</button>
	</div>

	<div class="pull-right">
		<button class="btn btn-danger btn-sm btn-delete" value=<?php echo $tenant_id; ?> >Delete</button>
	</div>
	
	<?php
		if ($tenant_expired == "NO") {
			echo "<div class='pull-right'>
					<button class='btn btn-warning btn-sm btn-expire' style='margin-right: 5px;' value=$tenant_id >Expire this account</button>
				</div>
			";
		}
	?>

	<div class="clearfix"></div>
	<br>
</div>

<div id="billing-div" class="panel panel-danger">
	<div class="panel-heading">
		<h3 class="panel-title">Billing Period</h3>
	</div>
	<div class="panel-body">
		<?php echo $billing_table_mobile; ?>
	</div>
</div> 

<div class="panel panel-danger">
	<div class="panel-heading">
		<h3 class="panel-title">Personal Information</h3>
	</div>
	<div class="panel-body">
        <div class="form-group">
            <label for="form-name" class="control-label col-sm-3">Name</label>
            <div class="col-sm-9">
                <p id="form-name" class="form-control-static"><span id="sp-name"><?php echo $tenant_name; ?></span></p>
            </div>
        </div>

        <div class="form-group">
            <label for="form-email" class="control-label col-sm-3">Email Address</label>
            <div class="col-sm-9">
                <p id="form-email" class="form-control-static"><span id="sp-email"><?php echo $tenant_email; ?></span></p>
            </div>
        </div>

        <div class="form-group">
            <label for="form-phone" class="control-label col-sm-3">Phone Number</label>
            <div class="col-sm-9">
                <p id="form-phone" class="form-control-static"><span id="sp-phone"><?php echo $tenant_phone; ?></span></p>
            </div>
        </div>
	</div>
</div>

<div class="panel panel-danger">
	<div class="panel-heading">
		<h3 class="panel-title">Account Information</h3>
	</div>
	<div class="panel-body">
        <div class="form-group col-md-6">
            <label for="form-reserved" class="control-label col-sm-5">Reserved</label>
            <div class="col-sm-7">
                <p id="form-reserved" class="form-control-static"><span id="sp-reserved"><?php echo $tenant_reserved; ?></span></p>
            </div>
        </div>
		
        <div class="form-group col-md-6">
            <label for="form-verified" class="control-label col-sm-5">Verified</label>
            <div class="col-sm-7">
                <p id="form-verified" class="form-control-static"><span id="sp-verified"><?php echo $tenant_verified; ?></span></p>
            </div>
        </div>

        <div class="form-group col-md-6">
            <label for="form-expired" class="control-label col-sm-5">Expired</label>
            <div class="col-sm-7">
                <p id="form-expired" class="form-control-static"><span id="sp-expired"><?php echo $tenant_expired; ?></span></p>
            </div>
        </div>

        <div class="form-group col-md-6">
            <label for="form-registered" class="control-label col-sm-5">Registered</label>
            <div class="col-sm-7">
                <p id="form-registered" class="form-control-static"><span id="sp-registered"><?php echo $tenant_registered; ?></span></p>
            </div>
        </div>
	</div>
</div>

<div class="panel panel-danger">
	<div class="panel-heading">
		<h3 class="panel-title">Rent Information</h3>
	</div>
	<div class="panel-body">
        <div class="form-group">
            <label class="control-label col-sm-3">Arrive Date</label>
            <div class="col-sm-9">
                <p id="form-name" class="form-control-static"><span id="sp-name"><?php echo $tenant_arrive; ?></span></p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3">Depart Date</label>
            <div class="col-sm-9">
                <p id="form-name" class="form-control-static"><span id="sp-name"><?php echo $tenant_depart; ?></span></p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3">Rent Term</label>
            <div class="col-sm-9">
                <p id="form-name" class="form-control-static"><span id="sp-name"><?php echo strtoupper($tenant_term); ?></span></p>
            </div>
        </div>
	</div>
</div>

<div>
	<div class="pull-left">
		<button class="btn btn-default btn-sm btn-back">Back</button>
	</div>

	<div class="pull-right">
		<button class="btn btn-danger btn-sm btn-delete" value=<?php echo $tenant_id; ?> >Delete</button>
	</div>
	
	<?php
		if ($tenant_expired == "NO") {
			echo "<div class='pull-right'>
					<button class='btn btn-warning btn-sm btn-expire' style='margin-right: 5px;' value=$tenant_id >Expire this account</button>
				</div>
			";
		}
	?>

	<div class="clearfix"></div>
</div>