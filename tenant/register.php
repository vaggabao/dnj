<?php
    ob_start();
    // set default timezone
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
    require_once('../config/config.php');

    // include the config
    require_once('../config/links.php');

    // include the PHPMailer library
    require_once('libraries/PHPMailer.php');
	
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

    // load the registration class
    require_once('classes/Registration.php');

    // create the registration object. when this object is created, it will do all registration stuff automatically
    // so this single line handles the entire registration process.
    $registration = new Registration();

    $token = $_GET['k'];
    $valid = $registration->checkToken($token);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_BOOTSTRAP_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_JQUERY_UI_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
	
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/register-style.css"; ?> />
    <link rel="shortcut icon" href=<?php echo LNK_ROOT . "/image/dnj_icon.png"; ?> >
    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS; ?> ></script>

    <title>Register | D&amp;J Home</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <img class="icon" src=<?php echo LNK_ROOT . "/tenant/images/dnj_logo.png"; ?> />
        </div>
                
        <div class="content">
            <div class="main-content">
                <?php
                    if ($registration->registration_successful) {
                        include("views/register-success.php");
                    } else {
                        if ($valid) {
                            include("views/valid-registration.php");
                        } else {
                            include("views/invalid-registration.php");
                        }
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
					</form>
				</div>
        </div>
    </div>

</body>

</html>
