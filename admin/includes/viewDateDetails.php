<?php
    include_once("../../config/config.php");
    require_once("../classes/Calendar.php");
    include("../translations/en.php");

    $calendar_id = $_POST['id'];

    // initialize calendar class
    $calendar = new Calendar();

    $data = $calendar->getCalendarInfo($calendar_id);
    $data = objectToArray($data);

    //set calendar info variables
    $tenant_id = $data['tenant_id'];
	echo $tenant_id;
    $name = ($tenant_id != 0 ? $data['name'] : "administrator");
    $name = ucwords(strtolower($name));
    $start_date = date("F d, Y", strtotime($data['start_date']));
    $end_date = date("F d, Y", strtotime($data['end_date']));
    $type = ucwords(strtolower($data['calendar_type']));

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

<!-- View calendar modal -->
<div id="view-dates-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div id="status">
					<div id="loader" class="spinner pull-right">
						<div class="bounce1"></div>
						<div class="bounce2"></div>
						<div class="bounce3"></div>
					</div>
				</div>
				<h4 id="view-title" class="modal-title">Date Information</h4>
			</div>

			<div class="modal-body">
				<div id="error-div" class="bg-warning">

				</div>

				<div id="dates-info-div">
					<div class="form-group row">
						<div class="col-sm-3 col-sm-offset-1">
							<label class="control-label">By</label>
						</div>
						<div class="col-sm-7">
							<p id="start-date-static" class="form-control-static"><?php echo $name; ?></p>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-3 col-sm-offset-1">
							<label class="control-label">Arrive Date</label>
						</div>
						<div class="col-sm-7">
							<p id="start-date-static" class="form-control-static"><?php echo $start_date; ?></p>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-3 col-sm-offset-1">
							<label class="control-label">Depart Date</label>
						</div>
						<div class="col-sm-7">
							<p id="end-date-static" class="form-control-static"><?php echo $end_date; ?></p>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-3 col-sm-offset-1">
							<label class="control-label">Status</label>
						</div>
						<div class="col-sm-7">
							<p id="status-static" class="form-control-static"><?php echo $type; ?></p>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<fieldset id="form-view-fieldset">
					<button id="btn-make-available" type="button" class="btn btn-primary">Make Available</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</fieldset>
			</div>
		</div>
	</div>
</div> <!-- End of modal -->