<?php
    ob_start();
	
	// include links
    include_once("config/links.php");
	
	// require Mobile_Detect Class
	require_once("Classes/Mobile_Detect.php");
	$detect = new Mobile_Detect;
	
	if ( $detect->isMobile() ) {
		header("Location: " . LNK_ROOT . "/mobile/amenities");
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
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_BOOTSTRAP_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_JQUERY_UI_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_FONTS_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/indexstyle.css?" . md5(uniqid());?> />
	<link href="http://fonts.googleapis.com/css?family=Calligraffitti" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
	
	<link rel="shortcut icon" href="http://dnjlancasterhomesuite.com/image/dnj_icon.png">
    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/jquery.cycle.all.js";?> ></script>
	<script type="text/javascript" src=<?php echo LNK_ROOT . "/js/slideshow.js";?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/dialog.js";?> ></script>
    <script>
        $(function() {
            $(".main-content").show("fade", 1000);
        });
    </script>
    

    <title>Amenities | D&amp;J Lancaster Home Suite</title>
</head>

<body>
    <div class="container">
        <div class="header">
			<a class="icon" href=<?php echo LNK_ROOT; ?> >
				<img src="<?php echo LNK_ROOT . "/image/D&amp;JLOGO.png"; ?>"/>
			</a>

            <div class="login-div">
                <a href=<?php echo LNK_ROOT . "/tenant/dashboard"; ?> class="buttonslogin"><img class="iconlogin" src="image/ownericon.png" />Login</a>
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
        
        <div class="content content-amenities">
            <div class="main-content no-right-pd">
                <div class="amenity-div">
                    <h4 class="textamenities">
                   		<?php echo WORD_AMENI; ?>
                    </h4> 
                   <?php echo WORD_AMENITEXT; ?><br/>
                    <ul>
                        <li>51sq.m Two bedroom newly furnished Condominium for rent (11th floor Room 1106)</li>
                        <li>Leather living room furniture with satin cover</li>
                        <li>Large flat-screen television (with HD basic cable packages)</li> 
                        <li>DVD player and home theatre</li>
                        <li>High speed and reliable internet connection with WIFI </li>
                        <li>Coffee and end tables</li>
                        <li>Three electric stand fans </li>
                        <li>Lamps and lighting fixtures</li>
                        <li>Dining table and chairs</li>
                        <li>Top quality queen-sized bed in master’s bedroom </li>
                        <li>Single bed with pull out single bed in the second bedroom</li>
                        <li>Air condition in both bedrooms</li>
                        <li>Toilet with hot shower</li>
                        <li>Washing machine With own cage/padlock</li>
                        <li>Iron and ironing board</li>
                        <li>Fully equipped kitchen </li>
                        <li>Fridge, stove, and microwave</li>
                        <li>Electric kettle and bread toaster</li>
                    </ul>
                    <h4 class="textamenities">
                        <?php echo WORD_AMENIOUT; ?><br/>
                    </h4> 
                    <ul>
                        <li>Clubhouse with WiFi</li>
                        <li>Fitness Gym</li>
                        <li>Games Room</li>
                        <li>Lap pool with pool deck</li>
                        <li>Kiddie pool</li>
                        <li>Leisure pool</li>
                        <li>Playground</li>
                        <li>Jogging paths</li>
                        <li>Gazebos</li>
                        <li>Picnic areas</li>
                        <li>Basketball court</li>
					</ul>
                    
              	</div>
                
                <div class="amenity-slide-div">
                    <div class="slideshow">
                        <img src="image/a1.jpg" width="500" height="370" />
                        <img src="image/a2.jpg" width="500" height="370"  />
                        <img src="image/a3.jpg" width="500" height="370"  />
                        <img src="image/a4.jpg" width="500" height="370"  />
                        <img src="image/a5.jpg" width="500" height="370"  />
                        <img src="image/a6.jpg" width="500" height="370"  />
                        <img src="image/a7.jpg" width="500" height="370" />
                        <img src="image/a8.jpg" width="500" height="370"  />
                        <img src="image/a9.jpg" width="500" height="370"  />
                        <img src="image/a10.jpg" width="500" height="370"  />
                        <img src="image/a11.jpg" width="500" height="370"  />
                        <img src="image/a12.jpg" width="500" height="370"  />
                        <img src="image/a13.jpg" width="500" height="370"  />
                        <img src="image/a14.jpg" width="500" height="370"  />
                        <img src="image/a15.jpg" width="500" height="370"  />
                    </div> 
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
		<!-- end footer -->
    </div>
</body>
</html>
