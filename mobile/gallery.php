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
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_JQUERY_UI_CSS; ?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/mobile-style.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/gallery-style.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/jquery.flipster.css";?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/indexstyle.css";?> />
    <link rel="shortcut icon" href=<?php echo LNK_ROOT . "/image/dnj_icon.png"; ?> >
    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS; ?> ></script>
	<script type="text/javascript" src=<?php echo LNK_ROOT . "/js/jquery.flipster.js";?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/dialog.js";?> ></script>
    <script>
        $(function() {
            $("#main").show("fade", 1000, function() {
                $(".flipster").init(function() {	
					$(".flipster").flipster({
						style: 'carousel'
					});
				});
            });
        });
    </script>

    <title>Gallery | D&amp;J Lancaster Home Suite</title>

    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/modernizr.js";?> ></script>
    
    <!--[if (gt IE 8) | (IEMobile)]><!-->
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/css/responsive-layout.css"; ?>>
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
        <article class="block prose">
			<div class="mobile-content">
        		<div class="textmain1" align="center">
                    Gallery
                </div>
				
				<!-- Flipster List -->	
                <div class="flipster">
                    <ul>
        			    <a id="btn-gallery">
                        <li><img src='<?php echo LNK_ROOT . "/image/a1.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a2.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a3.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a4.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a5.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a6.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a7.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a8.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a9.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a10.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a11.jpg"; ?>' ></li>	
                        <li><img src='<?php echo LNK_ROOT . "/image/a12.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a13.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a14.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a15.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a16.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a17.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a18.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a19.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a20.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a21.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a22.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a23.jpg"; ?>' ></li>
                        <li><img src='<?php echo LNK_ROOT . "/image/a24.jpg"; ?>' ></li>
            		    </a>
                    </ul>
                </div>
                <!-- End Flipster List -->
                <!-- Gallery image modal -->
                <div id="gallery-image-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                </button>

                                <div id="image-div"></div>     
                            </div>
                        </div>
                    </div>
                </div> <!-- End of modal -->
			</div>
		</article>
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