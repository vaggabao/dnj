	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/main.css"; ?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/calendar-style.css"; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/menu-style.css";?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/calendar.css"; ?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/spinner.css"; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SLIDEBAR_CSS; ?> />
	
	<script type="text/javascript" src=<?php echo LNK_ROOT . "/admin/js/calendar.js?" . md5(uniqid()); ?> ></script>
	<script type="text/javascript" src=<?php echo LNK_ROOT . "/admin/js/manage-calendar.js?" . md5(uniqid()); ?> ></script>
	<title>Calendar - Admin | D&amp;J Home</title>

	<?php require_once("classes/Calendar.php"); ?>
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
				<div class="main-content">

	                <div id="alert-div">
	                	
	                </div>

					<div>
						<div id="filter-div">
							<form id="form-filter" role="form" method="POST">
								<div id="filter-header-div">
									<span>Filter Calendar View</span>
									
									<div class="pull-right">
										<button type="submit" id="btn-filter" class="btn btn-default btn-xs">Filter</button>
									</div>
								</div>
								
								<div id="filter-criteria-div" class="row">
									<div id="start-date-div" class="form-group col-md-6 text-center">
										<label class="control-label">From : </label>
										<div class="form-inline">
											<select name="start-month-select" id="start-month-select" class="form-control form-select">
												<option value="0">SELECT MONTH</option>
												<option value="1">January</option>
												<option value="2">February</option>
												<option value="3">March</option>
												<option value="4">April</option>
												<option value="5">May</option>
												<option value="6">June</option>
												<option value="7">July</option>
												<option value="8">August</option>
												<option value="9">September</option>
												<option value="10">October</option>
												<option value="11">November</option>
												<option value="12">December</option>
											</select>

											<input type="text" name="start-year-text" id="start-year-text" class="form-control form-year" placeholder="yyyy" value="<?php echo date('Y'); ?>" />
										</div>
									</div>

									<div id="end-date-div" class="form-group col-md-6 text-center">
										<label class="control-label">To :</label>
										<div class="form-inline">
											<select name="end-month-select" id="end-month-select" class="form-control form-select">
												<option value="0">SELECT MONTH</option>
												<option value="1">January</option>
												<option value="2">February</option>
												<option value="3">March</option>
												<option value="4">April</option>
												<option value="5">May</option>
												<option value="6">June</option>
												<option value="7">July</option>
												<option value="8">August</option>
												<option value="9">September</option>
												<option value="10">October</option>
												<option value="11">November</option>
												<option value="12">December</option>
											</select>

											<input type="text" name="end-year-text" id="end-year-text" class="form-control form-year" placeholder="yyyy" value="<?php echo date('Y'); ?>" />
										</div>
									</div>
								</div>
							</form>
						</div>

						<div id="legends-div">

						</div>
					</div>

					<div id="info-div">

					</div>

					<!-- Display calendars here -->
					<div id="calendar-div">

					</div>
				</div>
			</div> <!-- end content -->
			
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
	
	<!-- Save calendar modal -->
	<div id="save-dates-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
					<h4 id="save-title" class="modal-title">Save date</h4>
				</div>

				<form id="form-save" role="form">
					<div class="modal-body">
						<div id="error-div" class="bg-warning">

						</div>
						<fieldset id="form-save-fieldset">
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
										<select name="status-select" id="status-select" class="form-control">
											<option value="unavailable">Unavailable</option>
											<option value="reserved">Reserved</option>
											<option value="occupied">Occupied</option>
										</select>
									</div>
								</div>
							</div>
					</div>

					<div class="modal-footer">
						<button id="btn-save" class="btn btn-primary">Save</button>
						<button id="btn-cancel" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div> <!-- End of modal -->

	<div id="display-info-modal"></div>
	<!-- View calendar modal -->
	<!-- <div id="view-dates-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
					<fieldset id="form-view-fieldset">
						<button id="btn-make-available" type="button" class="btn btn-primary">Make Available</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</fieldset>
				</div>
			</div>
		</div>
	</div> --> <!-- End of modal -->