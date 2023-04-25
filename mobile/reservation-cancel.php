<?php
    ob_start();
	// error_reporting(0);

    // include the config
    require_once("../config/config.php");

    // include dbConnect
    require_once("../config/dbConnect.php");

    // include links
    require_once("../config/links.php");
	
	// include language script
    include_once("../includes/change-lang.php");
	
	if (isset($_COOKIE['lang'])) {
		if ($_COOKIE['lang'] == "en") {
			include_once("../translations/en.php");
		} else if ($_COOKIE['lang'] == "tl") {
			include_once("../translations/fil.php");
		}
	} else {
		include_once("../translations/en.php");
	}

    // include globals
    require_once("../config/globals.php");

    // include the to-be-used language, english by default. feel free to translate your project and include something else
    require_once("../translations/en.php");

	$token = $_GET['token'];
	$sql = "DELETE t, tr FROM tbl_tenant t, tbl_transaction tr WHERE t.id = tr.tenant_id AND token = '$token'";
	$result = mysqli_query($conn, $sql);
	$num_rows = mysqli_affected_rows($conn);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_BOOTSTRAP_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_JQUERY_UI_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
    
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/reservation-pending-style.css"; ?> />
    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS; ?> ></script>

    <title>Reservation - Cancel | D&amp;J Lancaster Home Suite</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="<?php echo LNK_ROOT;?>"><img class="icon" src=<?php echo LNK_ROOT . "/image/D&amp;JLOGO.png"; ?> /></a>
        </div>

    	<div class="content">
            <div class="main-content">
                <?php
					if ($num_rows > 0) {
						include("../views/reservation-cancelled.php");
						header( "refresh:5;url=" . LNK_ROOT . "/mobile/reservation" );
					} else {
						header( "Location: " . LNK_ROOT . "/mobile/reservation" );
					}
                ?>
            </div>
        </div>
        
        <div class="footer">
            <div class="text-center">
                D&amp;J Apartment Home Rental | Royal Palm Residences Rawai Tower Unit 1106 11th Floor, Acacia Ave, Taguig City 1106
            </div>
            
            <div class="text-center">
                Copyright &copy; 2014 by D&amp;J Lancaster Rental Home Suite
            </div>

            <div class="text-center">
				<form method="POST">
					<button href="#" class="btn btn-link btn-lang-toggle" name="lang" value="en">English</button> | <button href="#" class="btn btn-link btn-lang-toggle" name="lang" value="tl">Filipino</button>
				</form>            </div>
        </div>
    </div>
</body>

</html>