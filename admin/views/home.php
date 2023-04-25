	<link rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/main.css"; ?> />
	<link rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/home-style.css"; ?> />
	<link rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/calendar.css"; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/menu-style.css";?> />
    <link rel="stylesheet" href=<?php echo LNK_SLIDEBAR_CSS; ?> />
	
	<script type="text/javascript" src="js/calendar.js"></script>
	<script type="text/javascript">
		$(function() {
			var notifyCount = 0;
			var recentCount = 0;

			// getNotifications();
			// getRecent();

			getNotifyCount();
			getRecentCount();

			/**
			 * Get notification count
			 */
			function getNotifyCount() {
				$.ajax ({
					type: 'POST',
					url: 'includes/getNotifyCount.php',
					success: function(result) {
						// alert(result);
						if (result == 0) {
							content = "<div id='notify-no-row' class='notify-no-row'>No notifications found</div>";
							$( '#notifications-panel-body' ).html(content);
						} else {
							$( '#notify-no-row' ).remove();
						}

						if (result > notifyCount) {
							var count = result - notifyCount;
							notifyCount = result;

							getNotifications(count);
						}
					},
					complete: function() {
						setTimeout(getNotifyCount, 1000);
					}
				});
			}

			/**
			 * Get list notifications
			 */
			function getNotifications(count) {
				var data = "count=" + count;
				$.ajax ({
					data: data,
					type: 'POST',
					url: 'includes/getNotifications.php',
					success: function(result) {
						$( '#notifications-panel-body' ).prepend(result).hide().show('fade');
					}
				});
			}

			/**
			 * Get recent activities count
			 */
			function getRecentCount() {
				$.ajax ({
					type: 'POST',
					url: 'includes/getRecentCount.php',
					success: function(result) {
						// alert(result);
						if (result == 0) {
							content = "<div id='recent-no-row' class='notify-no-row'>No recent activities</div>";
							$( '#recent-panel-body' ).html(content);
						} else {
							$( '#recent-no-row' ).remove();
						}

						if (result > recentCount) {
							var count = result - recentCount;
							recentCount = result;

							getRecent(count);
						}
					},
					complete: function() {
						setTimeout(getRecentCount, 1000);
					}
				});
			}

			/**
			 * Get list of recent
			 */
			function getRecent(count) {
				var data = "count=" + count;
				$.ajax ({
					data: data,
					type: 'POST',
					url: 'includes/getRecent.php',
					success: function(result) {
						$( '#recent-panel-body' ).prepend(result).hide().show('fade');
					}
				});
			}
		});
	</script>
	<title>Home - Admin | D&amp;J Home</title>

<?php
	// get active tenant
	$data = $tenant->getActiveTenant();

	if ($data) {
		$data = objectToArray($data);

		$tenant_id = $data['id'];
		$tenant_name = ucwords(strtolower($data['fname'])) . " " . ucwords(strtolower($data['lname']));
		$tenant_email = strtolower($data['email']);
		$tenant_phone = $data['phone'];
		$tenant_stay = date("F d, Y", strtotime($data['start_date'])) . " to " . date("F d, Y", strtotime($data['end_date']));

	    $home_content = "<div id='tenant-div' class='row form-horizontal'>
					        <div class='form-group'>
					            <label class='control-label col-sm-2'>Name:</label>
					            <div class='col-sm-10'>
					                <p id='form-name' class='form-control-static'>$tenant_name</p>
					            </div>
					        </div>

					        <div class='form-group'>
					            <label class='control-label col-sm-2'>Email:</label>
					            <div class='col-sm-10'>
					                <p id='form-email' class='form-control-static'>$tenant_email</p>
					            </div>
					        </div>

					        <div class='form-group'>
					            <label class='control-label col-sm-2'>Phone:</label>
					            <div class='col-sm-10'>
					                <p id='form-phone' class='form-control-static'>$tenant_phone</p>
					            </div>
					        </div>

					        <div class='form-group'>
					            <label class='control-label col-sm-2'>Stay:</label>
					            <div class='col-sm-10'>
					                <p id='form-stay' class='form-control-static'>$tenant_stay</p>
					            </div>
					        </div>
				        </div>
	";
	} else {
		$home_content = "
						<div class='text-center'>
	                    	<p>No active tenant</p>
	                	</div>
		";
	}


	// get missed due dates of active tenant
	$data = $tenant->getMissedDueDates();
    $count = count($data);

    $missed_table = "<table id='missed-table' class='table table-hover'>";
    $missed_table_headers = "<tr><th>Description</th><th>Amount</th><th>Amount</th><th>Due Date</th></tr>";
    $missed_table .= $missed_table_headers;

    $missed_table_mobile = "<div id='missed-table-mobile'>";
    for ($i = 0; $i < $count; $i++) {
        $missed_id = $data[$i]['id'];
        $missed_name = ucwords($data[$i]['name']);
        $missed_desc = $data[$i]['description'];
        $missed_amount = $data[$i]['amount'];
        $missed_due = date("F d, Y", strtotime($data[$i]['due_date']));
        // $missed_status = $data[$i]['payment_status'];

        $row = "<tr>
                    <td>$missed_name</td>
                    <td>$missed_desc</td>
                    <td>&#8369;$missed_amount</td>
                    <td>$missed_due</td>
                </tr>";

        $mrow = "<div class='missed-row-mobile'>
                    <p><strong>Tenant:</strong> $missed_name</p>
                    <p><strong>Description:</strong> $missed_desc</p>
                    <p><strong>Amount:</strong> &#8369;$missed_amount</p>
                    <p><strong>Due Date:</strong> $missed_due</p>
                </div>";

        $missed_table .= $row;
        $missed_table_mobile .= $mrow;
    }

    if ($count == 0) {
        $row = "<tr>
                    <td colspan=4 class=text-center>No missed due dates</td>
                </tr>";

        $mrow = "<div class='missed-row-mobile text-center'>
                    <p>No missed due dates</p>
                </div>";
        $missed_table .= $row;
        $missed_table_mobile .= $mrow;
    }

    $missed_table .= "</table>";
    $missed_table_mobile .= "</div>";

    // $missed_content = $missed_table . $missed_table_mobile;
    $missed_content = $missed_table_mobile;

	/**
	 * Convert object to array
	 */
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
</head>

<body>
	<div class="container">
		<div id="sb-site">
			<div class="header header-logged">
				<a id="icon" href=<?php echo LNK_ROOT . "/admin/";?> ><span><img class="icon icon-logged" src=<?php echo LNK_ROOT . "/admin/images/dnj_logo_admin.png";?> /></span></a>
				<div class="sb-toggle-right	navbar-right">
					<div class="navicon-line"></div>
					<div class="navicon-line"></div>
					<div class="navicon-line"></div>
				</div>
				<?php include "views/nav.php"; ?>
			</div>

			<div class="content content-logged">
				<div class="main-content row">

					<!-- home div -->
					<div id="home-div" class="col-md-8">
						<!-- home panel div -->
						<div class="panel panel-danger">

						    <div class="panel-heading">
						      	<h4 class="panel-title">
						         	Home
						      	</h4>
						    </div>

							<div class="panel-body">
								<div class="page-header">
									<h4>
										Current Tenant
									</h4>
								</div>
								<?php
									echo $home_content;
								?>

								<div class="page-header">
									<h4>
										Missed Due Dates
									</h4>
								</div>
								<div id='due-dates-div'>
								<?php
									echo $missed_content;
								?>
						        </div>
							</div>
						</div>
						<!-- end panel -->
					</div>
					<!-- end home -->

					<!-- sidebar div -->
					<div id="sidebar-div" class="col-md-4">

						<!-- notifications div -->
						<div class="panel panel-danger" id="notification-div">

						    <div class="panel-heading">
						      	<h4 class="panel-title">
						        	<a data-toggle="collapse" data-parent="#accordion" href="#notify-collapse">
						         	Notifications
						        	</a>
						      	</h4>
						    </div>

						    <div id="notify-collapse" class="panel-collapse collapse in">
								<div class="panel-body" id="notifications-panel-body"></div>
							</div>
						</div>
						<!-- end notifications -->

						<!-- recent activities div -->
						<div class="panel panel-danger" id="recent-div">
						    <div class="panel-heading">
						      	<h4 class="panel-title">
						        	<a data-toggle="collapse" data-parent="#accordion" href="#recent-collapse">
						         	Recent Activities
						        	</a>
						      	</h4>
						    </div>

						    <!-- <div class="panel-heading">
						      	<h4 class="panel-title">
						         	Recent Activities
						      	</h4>
						    </div> -->

						    <div id="recent-collapse" class="panel-collapse collapse in">
								<div class="panel-body" id="recent-panel-body"></div>
							</div>
						</div>
						<!-- end recent activities -->

					</div>
					<!-- end sidebar -->
				</div>
			</div>
			<!-- end content -->
			
			<!-- Footer div -->
			<div class="footer footer-logged">
				<div class="text-center">
					D&amp;J Apartment Home Rental | Royal Palm Residences Rawai Tower Unit 1106 11th Floor, Acacia Ave, Taguig City 1106
				</div>
				
				<div class="text-center">
					Copyright &copy; 2014 by D&amp;J Lancaster Rental Home Suite
				</div>
			</div>
			<!-- end of footer -->

		</div>
	</div>

	<?php
		include("views/sidenav.php");
	?>
	
	
	<!-- View calendar modal -->
	<div id="view-dates-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 id="save-title" class="modal-title">Date Information</h4>
				</div>

				<div class="modal-body">
					<div id="error-div" class="bg-warning">

					</div>

					<div id="dates-info-div">
						<div class="form-group row">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label">Start Date</label>
							</div>
							<div class="col-sm-7">
								<p id="start-date-static" class="form-control-static"></p>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label">End Date</label>
							</div>
							<div class="col-sm-7">
								<p id="end-date-static" class="form-control-static"></p>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-3 col-sm-offset-1">
								<label class="control-label">Status</label>
							</div>
							<div class="col-sm-7">
								<p id="status-static" class="form-control-static"></p>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div> <!-- End of modal -->