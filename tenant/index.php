<?php
    ob_start();
	// error_reporting(0);
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

    // include the PHPMailer library
    require_once("libraries/PHPMailer.php");

    // load the login class
    require_once("classes/Login.php");
	
	// include language script
    include_once("includes/change-lang.php");
	
	if (isset($_COOKIE['lang'])) {
		if ($_COOKIE['lang'] == "en") {
			include_once("translations/en.php");
		} else if ($_COOKIE['lang'] == "tl") {
			include_once("translations/fil.php");
		}
	} else {
		include_once("translations/en.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_BOOTSTRAP_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_JQUERY_UI_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/main.css"; ?> />
    <link rel="shortcut icon" href=<?php echo LNK_ROOT . "/image/dnj_icon.png"; ?> >
        
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS;?> ></script>

<?php
    // create a login object. when this object is created, it will do all login/logout stuff automatically
    // so this single line handles the entire login process.
    $login = new Login();;
    $user_id = $_SESSION['tenant_user_id'];

    // ... ask if we are logged in here:
    if ($login->isUserLoggedIn() == 1) {
        if ($login->isUserVerified() == 1) {
            if (isset($_GET['action'])) {
                $action = $_GET['action'];
                if ($action == "home") {
                    include("views/home.php");
                } elseif ($action == "account") {
                    include("views/account.php");
                } elseif ($action == "transactions") {
                    include("views/transactions.php");
                } elseif ($action == "bills") {
                    include("views/bills.php");
                }
            } else {
                header('Location: ' . LNK_ROOT . '/tenant/dashboard/home');
                exit();
            }
        } else {
            include("views/initial-payment.php");
        }
    } else {
        // the user is not logged in. you can do whatever you want here.
        // for demonstration purposes, we simply show the "you are not logged in" view.
        include("views/login.php");
    }
?>
</body>
</html>