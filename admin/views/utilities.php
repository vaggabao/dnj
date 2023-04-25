	<link rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/main.css"; ?> />
	<link rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/utilities-style.css"; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/menu-style.css";?> />
    <link rel="stylesheet" href=<?php echo LNK_SLIDEBAR_CSS; ?> />

	<title>Utilities - Admin | D&amp;J Home</title>
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
					<?php
						// include files here
						if (isset($_GET['view'])) {
							$utilities_action = $_GET['view'];
							
							if ($utilities_action == 1) {
								include("views/reservations.php");
							} else if ($utilities_action == 2) {
								include("views/extensions.php");
							} else if ($utilities_action == 3) {
								include("views/housekeeping.php");
							} else if ($utilities_action == 4) {
								include("views/tenant.php");
							} else if ($utilities_action == 5) {
								include("views/fee.php");
							} else if ($utilities_action == 6) {
								include("views/transactions.php");
							} else if ($utilities_action == 7) {
								include("views/myaccount.php");
							}
						} else {
							include("views/reservations.php");
						}
					?>
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

	<!-- confirmation modal -->
	<div id="confirm-modal" class="modal fade  bs-example-modal-sm">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title">Confirm Action</h4>
	            </div>

	            <div class="modal-body">
	            
	            </div>

	            <div class="modal-footer">
	                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
	                <button type="button" id="btn-reserve" class="btn btn-danger btn-sm" data-dismiss="modal">Confirm</button>
	            </div>
	        </div>
	    </div>
	</div>