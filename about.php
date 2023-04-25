<?php
    ob_start();
	
	// include links
    include_once("config/links.php");
	
	// require Mobile_Detect Class
	require_once("Classes/Mobile_Detect.php");
	$detect = new Mobile_Detect;
	
	// require Mobile_Detect Class
	require_once("Classes/Mobile_Detect.php");
	$detect = new Mobile_Detect;
	
	if ( $detect->isMobile() ) {
		header("Location: " . LNK_ROOT . "/mobile/about");
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
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_JQUERY_UI_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_FONTS_CSS; ?> />

	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/indexstyle.css?" . md5(uniqid());?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/about-style.css";?> />
	<link href="http://fonts.googleapis.com/css?family=Calligraffitti" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
	
	<link rel="shortcut icon" href="http://dnjlancasterhomesuite.com/image/dnj_icon.png">
    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/dialog.js";?> ></script>
    <script>
        $(function() {
            // $("#left").hide();
            $(".main-content").show("fade", 1000);
            // $("#right-div").hide();
            // $("#right-div").show("fade", 1000);
        });
    </script>
    
	<title>About Us | D&amp;J Lancaster Home Suite</title>
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
        
        <div class="content">
            <div class="main-content row">
                <div class="col-md-6 about-maintxt" id="left-div">
                    <h4 class="page-title text-center">
                        <?php echo WORD_ABOUT; ?>
                    </h4>

                    <p class="default-font left-indent">
                        <?php echo WORD_PARA1; ?>
                    </p>

                    <p class="default-font left-indent">
                        <?php echo WORD_PARA2; ?>
                    </p>

                    <p class="default-font left-indent">
                    	<?php echo WORD_PARA3; ?>
                    </p>
                    <br/>
                     <!-- Images Paypal -->
                    <div>
                        <a href="https://www.facebook.com/pages/Dnjlancasterhome/1536816319868765" target="_blank"> <img src="image/fb.png" width="120px" height="50px" class="pull-right" /></a> 
                        <img src="image/follow-us.gif" class="pull-right"/> 
                    </div>
                    
                    <div>
                	<a href="https://www.paypal.com/ph/webapps/mpp/paypal-popup" target="_blank"> <img src="image/paypals.png" width="350px" height="150px" class="pull-left" /></a> 
               		</div>
                    
                    
                </div>
           
            	
           
                <div class="col-md-6 about-maintxt" id="right-div">
                    <h4 class="page-title text-center">
                        <?php echo WORD_CONTACT; ?>
                    </h4>

                    <div class="row">
                        <div id="contact-details-div" class="default-font padding-20">
                            <p><?php echo WORD_CONTEXT; ?></p>
                            
                            <p>
                                Email Address: administrator@dnjlancasterhomesuite.com or <br />
                                jean_0616@hotmail.com <br />
                                Phone Number:(+63) 9163561238 - GLOBE OR <br />
                                Telephone Number: (02) 954-3676
                            </p>
                        </div>
                        
                        <div class="default-font text-center">
                            <a id="btn-map">
                                <img src="image/map.jpg" class="main" align="center"/>
                                <br/><?php echo WORD_MAP; ?>
                            </a>
                            <a id="btn-guide" class="abouttext"><br/><?php echo WORD_GET; ?></a>
                            <a id="btn-promenade" class="abouttext"><br/><?php echo WORD_PROM; ?></a><br/>
                            <br/>
                        </div>
                        
                       
                        

                        <!-- Vicinity map modal -->
                        <div id="map-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                        </button>

                                        <span class="ab"><?php echo WORD_VIC; ?></span>
                                        <img src="image/map.jpg" id="map-image" /> 
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
                                                <img src="image/piazza.jpg"/>
                                            </div>

                                            <div class="page-header">
                                                <span><strong>Market Market</strong></span>
                                                <img src="image/market.png"/>
                                            </div>

                                            <div class="page-header">
                                                <span><strong>Mall of Asia</strong></span>
                                                <img src="image/MOA.png"/>
                                            </div>

                                            <div class="page-header">
                                                <span><strong>Ayala</strong></span>
                                                <img src="image/ayala.jpg"/>
                                            </div>

                                            <div class="page-header">
                                                <span><strong>The Fort</strong></span>
                                                <img src="image/bhs.png"/>
                                            </div>

                                            <div class="page-header">
                                                <span><strong>Rizal Park</strong></span>
                                                <img src="image/rizal.jpg"/>
                                            </div>

                                            <div class="page-header">
                                                <span><strong>Intramuros</strong></span>
                                                <img src="image/intramuros.jpg"/>
                                            </div>

                                            <div class="page-header">
                                                <span><strong>Star City</strong></span>
                                                <img src="image/starcity.jpg"/>
                                            </div>

                                            <div class="page-header">
                                                <span><strong>Manila Zoo</strong></span>
                                                <img src="image/zoo.jpg"/>
                                            </div>

                                            <div class="page-header">
                                                <span><strong>Manila Ocean Park</strong></span>
                                                <img src="image/aquanaut.jpg"/>
                                            </div>

                                            <div class="page-header">
                                                <span><strong>Manila Bay</strong></span>
                                                <img src="image/bay.jpg"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End of modal -->
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