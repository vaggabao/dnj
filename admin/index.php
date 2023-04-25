<?php
	ob_start();
	error_reporting(0);
	date_default_timezone_set("Asia/Manila");

    // check for minimum PHP version
    if (version_compare(PHP_VERSION, '5.3.7', '<')) {
        exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
    } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
        // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
        // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
        require_once('libraries/password_compatibility_library.php');
    }

    // include the config
    require_once("../config/config.php");

    // include dbConnect
    require_once("../config/dbConnect.php");

    // include links
    require_once("../config/links.php");

    // include globals
    require_once("../config/globals.php");

    // include the to-be-used language, english by default. feel free to translate your project and include something else
    require_once("translations/en.php");

    // include the PHPMailer library
    require_once("libraries/PHPMailer.php");

    // load the login class
    require_once("classes/Login.php");

    // load the tenant class
    require_once("classes/Tenant.php");

    // initialize Tenant object
	$tenant = new Tenant();

	$tenant->updateTenantActivity();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_BOOTSTRAP_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_JQUERY_UI_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/main.css"; ?> />
    <link rel="shortcut icon" href=<?php echo LNK_ROOT . "/image/dnj_icon.png"; ?> >
        
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS;?> ></script>

	<?php
		// create a login object. when this object is created, it will do all login/logout stuff automatically
		// so this single line handles the entire login process.
		$login = new Login();

		// ... ask if we are logged in here:
		if ($login->isUserLoggedIn() == true) {
			if (isset($_GET['action'])) {
				$action = $_GET['action'];
				if ($action == "home") {
					include("views/home.php");
				} elseif ($action == "calendar") {
					include("views/calendar.php");
				} elseif ($action == "utilities") {
					include("views/utilities.php");
				} elseif ($action == "messages") {
					include("views/messages.php");
				} else {
					include("views/home.php");
				}
			} else {
				include("views/home.php");
			}
		} else {
			// the user is not logged in.
			include("views/login.php");
		}
	?>

</body>

</html>