	<link rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/main.css"; ?> />
	<link rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/message-style.css"; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/admin/css/menu-style.css";?> />
    <link rel="stylesheet" href=<?php echo LNK_SLIDEBAR_CSS; ?> />

	<title>Messages - Admin | D&amp;J Home</title>
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
							$messages_action = $_GET['view'];
							
							if ($messages_action == 1) {
								include("views/guest-messages.php");
							} else if ($messages_action == 2) {
								include("views/tenant-messages.php");
							}
							// else if ($messages_action == 3) {
							// 	include("views/email-messages.php");
							// }
						} else {
							include("views/guest-messages.php");
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

<div id="view-message-modal-div"></div>