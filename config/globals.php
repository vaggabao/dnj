<?php
	$sql = "SELECT * FROM tbl_prices";
	$result = mysqli_query($conn, $sql);

	// var_dump($result->fetch_array());
	// exit;

	// fee constants
	while ($rs = $result->fetch_array(MYSQLI_ASSOC)) {
	// while ($rs = mysqli_fetch_array($result)) {
		$description = $rs['description'];

		if ($description == "rent_fee") {
			define('RENT_FEE', $rs['amount']);
		} else if ($description == "rent_fee_3_above") {
			define('RENT_FEE_3_ABOVE', $rs['amount']);
		} else if ($description == "short_reservation_fee") {
			define('SHORT_TERM_FEE', $rs['amount']);
			define('SHORT_TERM_DESCRIPTION', 'D&J Lancaster Reservation (Short Term)');
		} else if ($description == "long_reservation_fee") {
			define('LONG_TERM_FEE', $rs['amount']);
			define('LONG_TERM_DESCRIPTION', 'D&J Lancaster Reservation (Long Term)');
		} else if ($description == "short_term_bills_fee") {
			define('SHORT_WITH_BILLS_FEE', $rs['amount']);
		} else if ($description == "short_term_no_bills_fee") {
			define('SHORT_NO_BILLS_FEE', $rs['amount']);
		} else if ($description == "housekeeping_fee") {
			define("HOUSEKEEPING_FEE", $rs['amount']);
			define("HOUSEKEEPING_DESCRIPTION", 'Housekeeping Fee');
		} else if ($description == "association_fee") {
			define("ASSOCIATION_FEE", $rs['amount']);
		} else if ($description == "rent_deposit_fee") {
			define("DEPOSIT_FEE", $rs['amount']);
		}
	}

	// paypal config
	// define('PP_ACCOUNT', 'voleaggabao-facilitator@yahoo.com');
	define('PP_ACCOUNT', 'jean_0616@hotmail.com');
	define('PP_CURRENCY', 'PHP');

    // paypal URLs
	// define('PP_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
	define('PP_URL', 'https://www.paypal.com/cgi-bin/webscr');
	define('PP_RESERVE_RETURN_URL', LNK_ROOT);
	define('PP_RESERVE_CANCEL_URL', LNK_ROOT . '/reservation/cancel');
	define('PP_RESERVE_NOTIFY_URL', LNK_ROOT . '/includes/payReservation.php');

	define('PP_ENTRY_RETURN_URL', LNK_ROOT . '/tenant/dashboard/');
	define('PP_ENTRY_CANCEL_URL', LNK_ROOT . '/tenant/dashboard/');
	define('PP_ENTRY_NOTIFY_URL', LNK_ROOT . '/tenant/includes/payEntry.php');

	define('PP_BILLS_RETURN_URL', LNK_ROOT . '/tenant/dashboard/bills');
	define('PP_BILLS_CANCEL_URL', LNK_ROOT . '/tenant/dashboard/bills');
	define('PP_BILLS_NOTIFY_URL', LNK_ROOT . '/tenant/includes/payBills.php');
?>