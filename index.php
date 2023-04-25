<?php
    ob_start();
	
	// require Mobile_Detect Class
	require_once("Classes/Mobile_Detect.php");
	$detect = new Mobile_Detect;
	
	// include links
    include_once("config/links.php");
	
	if ( $detect->isMobile() ) {
		header("Location: " . LNK_ROOT . "/mobile");
		exit(0);
	}
	
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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_BOOTSTRAP_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_FONTS_CSS; ?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/style.css?" . md5(uniqid());?> />
	<link href="http://fonts.googleapis.com/css?family=Calligraffitti" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
	
    <link rel="shortcut icon" href="http://dnjlancasterhomesuite.com/image/dnj_icon.png">
	
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/jquery.cycle.all.js?" . md5(uniqid());?> ></script>
	<script type="text/javascript" src=<?php echo LNK_ROOT . "/js/slideshow.js?" . md5(uniqid());?> ></script>
    
    <title>D&amp;J Lancaster Home Suite</title>
</head>

<body>
    <div class="container">
        <div class="header">
			<a class="icon" href=<?php echo LNK_ROOT; ?> >
				<img src="<?php echo LNK_ROOT . "/image/D&amp;JLOGO.png"; ?>"/>
			</a>

            <div class="login-div">
                <a href=<?php echo LNK_ROOT . "/tenant/dashboard"; ?> class="buttonslogin"><img class="iconlogin" src="<?php echo LNK_ROOT . '/image/ownericon.png'; ?>" />Login</a>
            </div>
        </div>
        
    	<div id="head">
            <?php
                /**
                 * Include nav bar
                 */
                include("views/_nav.php");
            ?>
            
            <div class="navtext"><?php echo WORD_NAVTEXT; ?></div>
    	</div>
        
    	<div class="content">
        	<div class="slideshow">
                <img src="image/1.jpg" width="100%" height="100%" />
                <img src="image/2.jpg" width="100%" height="100%" />
                <img src="image/3.jpg" width="100%" height="100%" />
                <img src="image/4.jpg" width="100%" height="100%" />
                <img src="image/5.jpg" width="100%" height="100%" />
                <img src="image/6.jpg" width="100%" height="100%" />
		 	</div>
            
            <div class="main">
            	<div>
                	<img src="image/main.png"/>
                </div>
                
                <div class="buttondiv">
                	<a href="reservation" class="mainbutton"><?php echo WORD_CHECKAVAIL; ?></a>
                </div>
            </div>
    	</div>
        
        <div class="footer">
            <img src="image/footer.png"/>
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
