
<script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/booking.js";?> ></script>
<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/datepicker.css";?> />

<?php
	require_once("libraries/PHPMailer.php");
	require_once("classes/Account.php");

	$account = new Account();
	
	
	$user_id = $_SESSION['tenant_user_id'];
	$sql = "SELECT  id, start_date, end_date FROM tbl_tenant WHERE user_id = $user_id";
	$result = mysqli_query($conn, $sql);

	if ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		$start_date = $rs['start_date'];
		$end_date = $rs['end_date'];
		$tenant_id = $rs['id'];
	}

	if (isset($_POST['request_housekeeping'])) {
		$housekeeping_date = $_POST['housekeeping_date'];
		$billing_due = date("F d, Y", strtotime("-1 DAY", strtotime($housekeeping_date)));
		
		$result = $account->requestHouseKeeping($tenant_id, $housekeeping_date);
	}
	
	// cancel housekeeping request
	if (isset($_POST['cancel_housekeeping'])) {		
		// get existing housekeeping request
		$sql_billing = "SELECT h.billing_id FROM tbl_housekeeping h, tbl_tenant t WHERE t.id = h.tenant_id AND t.user_id = $user_id AND h.is_cancelled = 0 AND h.is_done = 0";
		$result_billing = mysqli_query($conn, $sql_billing);
		
		// set housekeeping variables
		if ($rs = $result_billing->fetch_array(MYSQLI_ASSOC)) {
			$billing_id = $rs['billing_id'];
		}
		
		$account->cancelHousekeeping($billing_id);
	}
	
	// request laundry service
	if (isset($_POST['request_laundry'])) {
		$account->requestLaundry();
	}
	
	// check for system messages
	if ($account->errors) {
		$content = "<div id='info-edit-error-div' class='alert alert-danger alert-dismissable' role='alert'>
					<button type='button' class='close' data-dismiss='alert'>
						<span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
					</button>";
		foreach ($account->errors as $error) {
			$content .= "<p>" . $error . "</p>";
		}
		$content .= "</div>";
		echo $content;
	} elseif ($account->messages) {
		$content = "<div id='info-edit-msg-div' class='alert alert-success alert-dismissable' role='alert'>
					<button type='button' class='close' data-dismiss='alert'>
						<span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
					</button>";
		foreach ($account->messages as $message) {
			$content .= "<p>" . $message . "</p>";
		}
		$content .= "</div>";
		echo $content;
	}
?>

<!-- Cleaning Panel -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="panel-title">
			<?php echo WORD_HOUSEKEEPING_TITLE;?>
		</h4>
	</div>

	<div class="panel-body">
		<?php
			// get existing housekeeping request
			$sql_housekeeping = "SELECT h.billing_id, h.housekeeping_date, h.is_paid FROM tbl_housekeeping h, tbl_tenant t WHERE t.id = h.tenant_id AND t.user_id = $user_id AND h.is_cancelled = 0 AND h.is_done = 0";
			$result_housekeeping = mysqli_query($conn, $sql_housekeeping);
			
			// set housekeeping variables
			if ($rs = $result_housekeeping->fetch_array(MYSQLI_ASSOC)) {
				$housekeeping_date = $rs['housekeeping_date'];
				$billing_id = $rs['billing_id'];
				$billing_paid = $rs['is_paid'];
			}
			
			// if a request exists
			if (mysqli_num_rows($result_housekeeping)) {
				include("views/housekeeping_exists.php");
				
			// if no request is made
			} else {
				include("views/housekeeping_request.php");
			}
		?>
	</div>
</div> <!-- end of cleaning -->

<!-- Laundry Panel -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="panel-title">
			<?php echo WORD_LAUNDRY_TITLE;?>
		</h4>
	</div>

	<div class="panel-body">

		<p><?php echo WORD_LAUNDRY_CONTENT;?></p>
		<br />
		<form role="form" action="" method="POST">
			<button type="submit" name="request_laundry" class="btn btn-primary btn-sm pull-right"><?php echo WORD_REQUEST;?></button>
		</form>
		<div class="clearfix"></div>
	</div>
</div> <!-- end of laundry -->

<a class='btn btn-default btn-sm pull-right' href='home'><?php echo WORD_BACK;?></a>