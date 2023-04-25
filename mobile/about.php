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
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_JQUERY_UI_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
 	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/mobile-about.css";?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/indexstyle.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/about-style.css";?> />
    <link rel="shortcut icon" href=<?php echo LNK_ROOT . "/image/dnj_icon.png"; ?> >
    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/dialog.js";?> ></script>
    <script type="text/javascript">
        $(function() {
			$("#main").show("fade", 1000);
        });
    </script>
    

    <title>About Us | D&amp;J Lancaster Home Suite</title>

    <script src=<?php echo LNK_ROOT . "/js/modernizr.js"; ?>></script>

    <!--[if (gt IE 8) | (IEMobile)]><!-->
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/css/responsive-layout.css"; ?> />
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
            <h1 class="block-title"><img src=<?php echo LNK_ROOT . "/image/D&JLOGO-Mobile1.png"?> class="logohi"></h1>
             <div class="textnav" align="center"><?php echo WORD_NAVTEXT; ?></div>
            <a class="nav-btn" id="nav-open-btn" href="#nav">DnJ Navigation</a>
        </div>
    </header>

    
    <?php include_once("views/_nav.php"); ?>

    <div id="main" role="main">
        <article class="block ">
			<div class="textmain">
				<h4 class="textmain1">
					<?php echo WORD_ABOUT; ?>
				</h4>
				<?php echo WORD_PARA1; ?><br/>
				<br/>
				<?php echo WORD_PARA2; ?><br/>
				<br/>
				<?php echo WORD_PARA3; ?>
			</div>
           
			<div class="textmain">
				<h4 class="textmain1" ><br/>
					<?php echo WORD_CONTACT; ?>
				</h4>
				
				<div>
					<div class="textmain" align="center">
						<?php echo WORD_CONTEXT; ?><br/> 
						Email Address: administrator@dnjlancasterhomesuite.com OR jean_0616@hotmail.com<br/>
						Phone Number:(+63) 9361591995 / (+63) 9164369996 - GLOBE<br/>
						Phone Number:(+63) 9212111945 - SMART   OR   Telephone Number: (02) 954-3676<br/>
					</div>
                    
                    <div class="default-font text-center">
                            <a id="btn-map">
                                <img src=<?php echo LNK_ROOT . "/image/map.jpg";?> class="main" align="center"/>
                                <br/><?php echo WORD_MAP; ?>
                            </a>
                            <a id="btn-guide" class="abouttext"><br/><?php echo WORD_GET; ?></a>
                            <a id="btn-promenade" class="abouttext"><br/><?php echo WORD_PROM; ?></a><br/>
                            <br/>
                        </div>
                        
				</div>
                <!-- Images Paypal -->
            <div>
               <a href="https://www.facebook.com/pages/Dnjlancasterhome/1536816319868765" target="_blank"> <img src=<?php echo LNK_ROOT . "/image/fb.png"; ?>  class="center fb" /></a> 
            </div>
                    
            <div>
               <a href="https://www.paypal.com/ph/webapps/mpp/paypal-popup" target="_blank" > <img src=<?php echo LNK_ROOT . "/image/paypals.png"; ?> class="center paypals" /></a> 
            </div><!-- Images Paypal -->
            </div>
            <div class="clearfix"></div>
             
           
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

<!-- Vicinity map modal -->
<div id="map-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>

                <span class="ab"><?php echo WORD_VIC; ?></span>
                <img src=<?php echo LNK_ROOT . "/image/map.jpg";?> id="map-image" /> 
            </div>
        </div>
    </div>
</div> <!-- End of modal -->


<!-- How to get there modal -->
<div id="travel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">           
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>

                <span class="ab"><?php echo WORD_GET; ?></span>

                <div class="modal-body guidefont">
                    <div class="page-header">
                        <strong><?php echo WORD_C5; ?></strong>
                    </div>

                    <div>
                        <?php echo WORD_C5TEXT; ?>
                    </div>

                    <div class="page-header">
                        <strong><?php echo WORD_EDSA; ?></strong>
                    </div>

                    <div>
                        <?php echo WORD_EDSATEXT; ?>
                    </div>

                    <div class="page-header">
                        <strong><?php echo WORD_DISTANCE; ?></strong>
                    </div>


                    <div class="col-md-6">
                        <p><strong>Business Districts</strong></p>
                        <p>
                            Bonifacio Global City - 3.65 km <br />
                            Makati - 7.50 km <br />
                            Ortigas - 8.14 km
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Commercial Establishments</strong></p>
                        <p>
                            Market! Market! - 3.65 km <br />
                            Bonifacio High Street - 4.03 km <br />
                            Glorietta - 7.61 km <br />
                            SM Megamall - 9.95 km <br />
                        </p>

                    </div>

                    <div class="col-md-6">
                        <p><strong>Schools</strong></p>
                        <p>
                            International School - 4.06 km <br />
                            Colegio de San Agustin - 5.14 km <br />
                            Assumption College - 8.01 km <br />
                            Centro Escolar University - Makati - 8.32 km <br />
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Hospitals</strong></p>
                        <p>
                            Ospital ng Makati - 3.05 km <br />
                            St. Luke's Medical Center BGC - 4.40 km <br />
                            Makati Medical Center - 9.18 km
                        </p>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End of modal -->

<!-- Promenades modal -->
<div id="promenades-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">           
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>

                <span class="ab"><?php echo WORD_PROMNADE; ?></span>

                <div class="modal-body guidefont">
                    <div class="page-header">
                        <span><strong>Venice Piazza</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/piazza.jpg";?> />
                    </div>

                    <div class="page-header">
                        <span><strong>Market Market</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/market.png";?> />
                    </div>

                    <div class="page-header">
                        <span><strong>Mall of Asia</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/MOA.png";?> />
                    </div>

                    <div class="page-header">
                        <span><strong>Ayala</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/ayala.jpg";?> />
                    </div>

                    <div class="page-header">
                        <span><strong>The Fort</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/bhs.png";?> />
                    </div>

                    <div class="page-header">
                        <span><strong>Rizal Park</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/rizal.jpg";?> />
                    </div>

                    <div class="page-header">
                        <span><strong>Intramuros</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/intramuros.jpg";?> />
                    </div>

                    <div class="page-header">
                        <span><strong>Star City</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/starcity.jpg";?> />
                    </div>

                    <div class="page-header">
                        <span><strong>Manila Zoo</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/zoo.jpg";?> />
                    </div>

                    <div class="page-header">
                        <span><strong>Manila Ocean Park</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/aquanaut.jpg";?> />
                    </div>

                    <div class="page-header">
                        <span><strong>Manila Bay</strong></span>
                        <img src=<?php echo LNK_ROOT . "/image/bay.jpg";?> />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End of modal -->

<script type="text/javascript" src=<?php echo LNK_ROOT . "/js/main.js";?> ></script>

</body>
</html>