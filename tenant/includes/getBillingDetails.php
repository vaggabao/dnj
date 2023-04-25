<?php
    require_once("../../config/config.php");
    require_once("../classes/Billing.php");
    include("../translations/en.php");

    $billing = new Billing();

    $billing_id = $_POST['billing_id'];
    $data = $billing->getBillingDetails($billing_id);

    $count = count($data);
    $billing_table = "<table class='table table-hover' style='width: 90%; margin: 0 auto; margin-top: 20px'>";
	$table_headers = "<tr><th>Description</th><th>Amount</th></tr>";
	$billing_table .= $table_headers;

    for ($i =  0; $i < $count; $i++) {
        $billing_desc_id = $data[$i]['id'];
		$description = $data[$i]['description'];
		$amount = $data[$i]['amount'];

		$row = "<tr>
					<td>$description</td>
					<td>&#8369;$amount</td>
				</tr>
		";

        $billing_table .= $row;
    }
	$billing_table .= "</table>";
    echo $billing_table;
?>