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
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_BOOTSTRAP_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_JQUERY_UI_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/indexstyle.css?" . md5(uniqid());?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/mobile-style.css?" . md5(uniqid());?> />
    <!--[if (gt IE 8) | (IEMobile)]><!-->
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/css/responsive-layout.css?" . md5(uniqid());?> />
    <!--<![endif]-->
    <!--[if (lt IE 9) & (!IEMobile)]>
    <link rel="stylesheet" href="css/ie.css">
    <![endif]-->
    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/jquery.cycle.all.js";?> ></script>
	<script type="text/javascript" src=<?php echo LNK_ROOT . "/js/slideshow.js?" . md5(uniqid());?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/modernizr.js";?> ></script>
    <script type="text/javascript">
        $(function() {
			$("#main").show();
        });
    </script>
    <title>D&amp;J Lancaster Home Suite</title>
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

    <div id="main">
		<div class="mobile-content">
			<div class="slideshow slideshow-mobile">
				<img src=<?php echo LNK_ROOT . "/image/1.jpg"; ?> class="slideshow-mobile-img" />
				<img src=<?php echo LNK_ROOT . "/image/2.jpg"; ?> class="slideshow-mobile-img" />
				<img src=<?php echo LNK_ROOT . "/image/3.jpg"; ?> class="slideshow-mobile-img" />
				<img src=<?php echo LNK_ROOT . "/image/4.jpg"; ?> class="slideshow-mobile-img" />
				<img src=<?php echo LNK_ROOT . "/image/5.jpg"; ?> class="slideshow-mobile-img" />
				<img src=<?php echo LNK_ROOT . "/image/6.jpg"; ?> class="slideshow-mobile-img" />
			</div>
			
			<div class="text-center">
				<a href="reservation" class="btn mainbutton marginbtn"><?php echo WORD_CHECKAVAIL; ?></a>
				<a href="contact-us" class="btn mainbutton marginbtn"><?php echo WORD_MOWNER; ?></a>
			</div>
			
			<div class="textmain">
				<?php echo WORD_PARA1; ?>
				<br /><br />
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