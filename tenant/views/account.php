
    <title>Account | D&amp;J Home</title>
    
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/account-style.css"; ?> />
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/menu-style.css"; ?> />
    <link rel="stylesheet" href=<?php echo LNK_SLIDEBAR_CSS; ?> />

    <script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/menu-script.js"; ?> ></script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
        require_once("classes/Account.php"); 
        $account = new Account();
		
		// fetch tenant info
        $data = $account->getAccountInfo();
        $data = objectToArray($data);
		
		// set tenant info variables
		$tenant_id = $data['tenant_id'];
        $email = $data['email'];
        $fname = ucwords(strtolower($data['fname']));
        $lname = ucwords(strtolower($data['lname']));
        $phone = $data['phone'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $rent_term = ucwords(strtolower($data['rent_term']));
        $registration_date = strtotime($data['registration_datetime']);
		
		// if updated password is submitted
        if (isset($_POST['update-pass'])) {
            $old = $_POST['old-password'];
            $new = $_POST['new-password'];
            $retype = $_POST['re-password'];

            $account->updatePassword($old, $new, $retype);
        }

		// if update personal is submitted
        if (isset($_POST['update-personal'])) {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $phone= $_POST['phone'];

            $account->updatePersonalInfo($fname, $lname, $phone);
        }
		
		// request is submitted
        if (isset($_POST['request_extension'])) {
            $extension_date = $_POST['extension_date'];

            $account->extendContract($extension_date);
        }		
		
		// cancel request is submitted
		if (isset($_POST['cancel_extension'])) {
			$account->cancelExtension($tenant_id);
		}
		
		// get existing request. if there is
		$sql_get_extension = "SELECT * FROM tbl_extension WHERE tenant_id = $tenant_id AND is_accepted = 0 AND is_cancelled = 0";
		$result_get_extension = mysqli_query($conn, $sql_get_extension);
		$rs = $result_get_extension->fetch_array(MYSQLI_ASSOC);
		$extension_date = $rs['extension_date'];
		
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
    <title>Account | D&amp;J Home</title>
</head>

<body>
    <div class="container">
		<div id="sb-site">
			<div class="header header-logged">
				<a id="icon" href=<?php echo LNK_ROOT . "/tenant/dashboard"; ?> ><span><img class="icon icon-logged" src=<?php echo LNK_ROOT . "/tenant/images/dnj_logo_tenant.png";?> /></span></a>
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
							$account_action = $_GET['view'];

							if ($account_action == "1") {
								include "account-info.php";
							} elseif ($account_action == "2") {
								include "personal-info.php";
							} elseif ($account_action == "3") {
								include "rent-info.php";
							}
						} elseif (isset($_GET['edit'])) {
							$account_action = $_GET['edit'];

							if ($account_action == "1") {
								include "account-edit.php";
							} elseif ($account_action == "2") {
								include "personal-edit.php";
							} elseif ($account_action == "3") {
								include "rent-edit.php";
							}
						} else {
							include "account-info.php";
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