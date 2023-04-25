<?php
    require_once("../../config/config.php");
    require_once("../classes/Fee.php");
    include("../translations/en.php");

    // initialize fee class
    $fees = new Fee();

    // get fees array
    $data = $fees->getFees();
    $count = count($data);

    $fee_form = "<form method=POST>";

    for ($i = 0; $i < $count; $i++) {
    	$fee_id = $data[$i]['id'];
    	$fee_name = $data[$i]['fee_name'];
    	$fee_desc = $data[$i]['description'];
    	$fee_amount = $data[$i]['amount'];

    	$row = "
			    <div class='form-group'>
			        <label class='control-label pull-left'>$fee_name</label>
			        <div class='pull-right'>
			        	<div class='input-group'>
	      					<div class='input-group-addon currency-addon'>&#8369;</div>
				            <input class='form-control form-text fees' data-id=$fee_id value=$fee_amount />
			            </div>
			        </div>
			        <div class='clear-fix'></div>
			    </div>
    	";

    	$fee_form .= $row;
    }

    $fee_form .= "<p>&nbsp;</p><button type='submit' id='btn-update' class='btn btn-primary btn-xs pull-right'>Update</button></form>";

    echo $fee_form;
?>