<?php
    ob_start();
    include_once("../config/links.php");
	
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
?>

<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_BOOTSTRAP_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/mobile-style.css";?> />
    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/jquery.cycle.all.js";?> ></script>
	<script type="text/javascript" src=<?php echo LNK_ROOT . "/js/slideshow.js";?> ></script>
    <script>
        $(function() {
			$("#main").show();
        });
    </script>

    <title>Amenities | D&amp;J Lancaster Home Suite</title>

    <script src=<?php echo LNK_ROOT . "/js/modernizr.js"; ?>></script>
    
    <!--[if (gt IE 8) | (IEMobile)]><!-->
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/css/responsive-layout.css?" . md5(uniqid()); ?>>
    <!--<![endif]-->
    <!--[if (lt IE 9) & (!IEMobile)]>
    <link rel="stylesheet" href="css/ie.css">
    <![endif]-->
</head>
<body>

<div id="outer-wrap">
<div id="inner-wrap">

    <header id="top" role="banner">
        <div class="block">
            <h1 class="block-title"><img src=<?php echo LNK_ROOT . "/image/D&JLOGO-Mobile1.png"; ?> class="logohi"></h1>
             <div class="textnav"><?php echo WORD_NAVTEXT; ?></div>
            <a class="nav-btn" id="nav-open-btn" href="#nav">DnJ Navigation</a>
        </div>
    </header>

    
    <?php include_once("views/_nav.php"); ?>

    <div id="main" role="main">
    	<div class="mobile-content">
         	<div class="slideshow slideshow-mobile">
                <img src=<?php echo LNK_ROOT . "/image/a1.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a2.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a3.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a4.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a5.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a6.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a7.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a8.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a9.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a10.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a11.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a12.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a13.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a14.jpg"; ?> class="slideshow-mobile-img" />
                <img src=<?php echo LNK_ROOT . "/image/a15.jpg"; ?> class="slideshow-mobile-img" />
		 	</div>
			
            <div class="textmain">
                <div class="amenity-div">
                    <br/>
                    <h4 class="textmain1">
                   		<?php echo WORD_AMENI; ?>
                    </h4> 
					<?php echo WORD_AMENITEXT; ?><br/><br/>
					
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
                    </ul><br/>
                    <h4 class="textmain1">
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
            </div>
		</div>
    </div>

    <footer role="contentinfo">
        <div class="block prose">			
            <div class="text-center textfoot">
                D&amp;J Apartment Home Rental | Royal Palm Residences Rawai Tower Unit 1106 11th Floor, Acacia Ave, Taguig City 1106
            </div>
            
            <div class="text-center textfoot">
                Copyright &copy; 2014 by D&amp;J Lancaster Rental Home Suite
            </div>

            <div class="text-center textfoot">
				<form method="POST">
					<button href="#" class="btn btn-link btn-lang-toggle" name="lang" value="en">English</button> | <button href="#" class="btn btn-link btn-lang-toggle" name="lang" value="tl">Filipino</button>
				</form>
            </div>
        </div>
    </footer>

</div>
<!--/#inner-wrap-->
</div>
<!--/#outer-wrap-->

<script type="text/javascript" src=<?php echo LNK_ROOT . "/js/main.js";?> ></script>

</body>
</html>