
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/home-style.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/menu-style.css";?> />
    <link rel="stylesheet" href=<?php echo LNK_SLIDEBAR_CSS; ?> />

    <script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/menu-script.js";?> ></script>
	
    <title>Home | D&amp;J Home</title>
</head>

<body>
    <div class="container">
		<div id="sb-site">
			<div class="header header-logged">
				<a id="icon" href=<?php echo LNK_ROOT . "/tenant/dashboard";?> ><span><img class="icon icon-logged" src=<?php echo LNK_ROOT . "/tenant/images/dnj_logo_tenant.png";?> /></span></a>
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
						if (isset($_GET['view'])) {
							$home_action = $_GET['view'];
		
							if ($home_action == 1) {
								include("views/default.php");
							} else if ($home_action == 2) {
								include("views/housekeeping.php");
							}
						} else {
							include("views/default.php");
						}
					?>
				</div>
			</div>
	
			<div class="footer footer-logged">
				<div class="text-center">
					D&amp;J Apartment Home Rental | Royal Palm Residences Rawai Tower Unit 1106 11th Floor, Acacia Ave, Taguig City 1106
				</div>
				
				<div class="text-center">
					Copyright &copy; 2014 by D&amp;J Lancaster Rental Home Suite
				</div>

				<div class="text-center">
					<form method="POST">
						<button href="#" class="btn btn-link btn-lang-toggle" name="lang" value="en">English</button> | <button href="#" class="btn btn-link btn-lang-toggle" name="lang" value="tl">Filipino</button>
					</form>
				</div>
			</div>
		</div>
    </div>
	
	<?php
		include("views/sidenav.php");
	?>