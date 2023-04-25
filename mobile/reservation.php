<?php
    ob_start();
	error_reporting(0);
	
	// require PHPMailer Class
	require("../libraries/PHPMailer.php");
	
	// include links
	include_once("../config/links.php");
	
	// include config
	include_once("../config/config.php");
	
	// include dbConnect
	include_once("../config/dbConnect.php");
	
	// include globals
	include_once("../config/globals.php");

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

	include("../includes/payReservation.php");
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
    <link rel="stylesheet" type="text/css" href=<?php echo LNK_INTTELINPUT_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/indexstyle.css";?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/mobile-style.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/datepicker.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/reservation-style.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/mobile/css/mobile-reservation.css?" . md5(uniqid());?> />
    <!--[if (gt IE 8) | (IEMobile)]><!-->
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/css/responsive-layout.css"; ?> />
    <!--<![endif]-->
    <!--[if (lt IE 9) & (!IEMobile)]>
    <link rel="stylesheet" href="css/ie.css">
    <![endif]-->
    <link rel="shortcut icon" href=<?php echo LNK_ROOT . "/image/dnj_icon.png"; ?> >
    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS; ?> ></script>
    <script src=<?php echo LNK_ROOT . "/js/modernizr.js"; ?>></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/jquery.cycle.all.js";?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/mobile/js/dialog.js?" . md5(uniqid());?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/mobile/js/booking.js?" . md5(uniqid());?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/validate-reserve-form.js";?> ></script>
    <script type="text/javascript" src=<?php echo LNK_INTTELINPUT_JS; ?> ></script>	
    <script>
        $(function() {
            $("#main").show("fade", 1000);
			$( '.form-phone' ).intlTelInput({
				utilsScript: '<?php echo LNK_ROOT . "/js/utils.js"; ?>'
			});
			$( '.intl-tel-input' ).css(
				"display", "block"
			);
        });
    </script>
	
	<title>Reservation | D&amp;J Lancaster Home Suite</title>
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
    	<div class="block prose">
			<div class="mobile-content">
            	<!-- select dates div -->
                <div id="dateDiv" class="reserv-border text-center" >
					<div>
                        <a href="https://www.paypal.com/ph/webapps/mpp/paypal-popup" target="_blank"> <img src=<?php echo LNK_ROOT . "/image/Paypal-Logo.png"; ?> width="100px" height="30px" class="pull-left" /></a>
                        <a href="<?php echo LNK_ROOT . '/mobile/calendar'; ?>" class="pull-right"><?php echo WORD_VIEWCAL; ?></a>
						<div class="clearfix"></div>
					</div>
					
                    <h4 class="textreserve">
                        <?php echo WORD_BOOK; ?>
                    </h4>

                    <div id="startDiv" class="arriveDate col-md-6">
                        <label class="control-label" for="startDate">
                            <?php echo WORD_ARRIVED; ?>
                        </label>
                        <input type="text" id="startDate" class="form-control dateshadow text-center" placeholder="YYYY-MM-DD" readonly="readonly" />
                    </div>

                    <div id="endDiv" class="departDate col-md-6">
                        <label class="control-label" for="endDate">
                            <?php echo WORD_DEPART; ?>
                        </label>
                        <input type="text" id="endDate" class="form-control dateshadow text-center" placeholder="YYYY-MM-DD"  readonly />
                    </div>

                    <div class="clearfix"></div>

                    <div id="errMsg" class="alert alert-warning"></div>

                    <button class="btn btn-default btn-margin dateshadow" id="btnBook"><?php echo WORD_CPRICE; ?></button>
                    <br/>
					
					<div class="legends-div">					
						<div class="">
							Legend:
						</div>
						
						<div class="pull-left">
							<div class="pull-left col">
								<div id="icon-available"></div>
							</div>
							<div class="pull-left col">
								Available
							</div>
						</div>
						
						<div class="pull-left">
							<div class="pull-left col">
								<div id="icon-unavailable"></div>
							</div>
							<div class="pull-left col">
								Unavailable
							</div>
						</div>
						
						<div class="clearfix"></div>
					</div>
                    
                </div>
                <!-- end select dates div -->
                    
                <div class="reserv-div">
					<div class="reserve-context">
						<p>
							<?php echo WORD_RESTEXT; ?>
						</p>
					</div>
                   
                    <h3 class="page-title"><?php echo WORD_PRICE; ?></h4>
					
                    <h4 class="page-sub-title"><?php echo WORD_SHORT; ?></h4>
                    <p>
						<?php echo WORD_SHORTTEXT1 . WORD_PHP . number_format(SHORT_TERM_FEE) . WORD_SHORTTEXT1_1; ?>
					</p>
					
                    <p>
						<?php echo WORD_SHORTTEXT4; ?><?php echo WORD_PHP; ?><?php echo number_format(DEPOSIT_FEE); ?><?php echo WORD_SHORTTEXT4_1; ?>
					</p>
					
					<p>
						<?php echo WORD_PHP; ?><?php echo number_format(SHORT_NO_BILLS_FEE); ?><?php echo WORD_SHORTTEXT2; ?>
					</p>
					
					<p>
						<?php echo WORD_PHP; ?><?php echo number_format(SHORT_WITH_BILLS_FEE); ?><?php echo WORD_SHORTTEXT3; ?>
					</p>
					
					<p>
					
                    <h4 class="page-sub-title"><?php echo WORD_LONG; ?></h4>
                    
					<p>
						<?php echo WORD_LONGTEXT1; ?><?php echo WORD_PHP; ?><?php echo number_format(LONG_TERM_FEE); ?>
						<?php echo WORD_LONGTEXT1_1; ?>
					</p>
						
					<p>
						<?php echo WORD_PHP; ?><?php echo number_format(RENT_FEE); ?><?php echo WORD_LONGTEXT2; ?>
					</p>
					
					<p>
						<?php echo WORD_PHP; ?><?php echo number_format(RENT_FEE_3_ABOVE); ?><?php echo WORD_LONGTEXT2_2; ?>
					</p>
					
					<p>
						<?php echo WORD_LONGTEXT3; ?>
						<br/>
						<?php echo WORD_LONGTEXT4; ?>
					</p>
                     
                    <h3 class="page-title"><?php echo WORD_EXTEND; ?></h3>
                    
					<p>
						<?php echo WORD_EXTENDTEXT; ?>
					</p>
                     
                    <h3 class="page-title"><?php echo WORD_CHECKIN; ?></h3>
					
					<p>
						<?php echo WORD_CHECKINTEXT1; ?>
					</p>
					
					<p>
						<?php echo WORD_CHECKINTEXT2; ?>
					</p>

					<div class="reserve-context">
						<p>
							<?php echo WORD_OPEN; ?><br/>  <?php echo WORD_OPEN1; ?>
						</p>
						
						<p>
							<?php echo WORD_OPEN2; ?> <a href="about.php"class="navtext"><?php echo WORD_CONTACT;?>.</a>
						</p>
					</div>
                 
                </div>
                
                <div class="clearfix"></div>
                
                
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
</div><!--/#inner-wrap-->
</div><!--/#outer-wrap-->

<!-- reservation modal -->
<div id="reserv-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div id="status">
					<div id="loader" class="spinner pull-right">
						<div class="bounce1"></div>
						<div class="bounce2"></div>
						<div class="bounce3"></div>
					</div>
				</div>
				
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h3 class="modal-title title-text"><?php echo WORD_RES; ?></h3>
			</div>

			<form role="form" id="form-pp" class="form-horizontal" action="" method="POST">
			<div class="modal-body row">
				<div id="info-div" class="col-md-6">
					<div class="page-header">
						<h4>
							<?php echo WORD_CUSINFO; ?>
						</h4>
					</div>

					<div class="fields-div">
						<div id="alert-div" class="alert alert-danger"></div>

						<!-- name form-group -->
						<div>
							<div class="form-group">
								<label for="form-fname" class="control-label col-sm-3"><?php echo WORD_NAME; ?></label>

								<div class="col-sm-9">
									<input type="text" id="form-fname" name="fname" class="form-control dateshadow" placeholder="first name" />
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-9 col-sm-offset-3">
									<input type="text" id="form-lname" name="lname" class="form-control dateshadow" placeholder="last name" />
								</div>
							</div>
						</div>
	
						<!-- email form-group -->
						<div>
							<div class="form-group">
								<label for="form-email" class="control-label col-sm-3"><?php echo WORD_EMAIL; ?></label>

								<div class="col-sm-9">
									<input type="text" id="form-email" name="email" class="form-control dateshadow" placeholder="email address" />
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-9 col-sm-offset-3">
									<input type="text" id="form-confirm" name="confirm" class="form-control dateshadow" placeholder="retype email address" />
								</div>
							</div>
						</div>
						
						<!-- phone form-group -->
						<div class="form-group">
							<label for="form-phone" class="control-label col-sm-3"><?php echo WORD_PHONE; ?></label>
							<div class="col-sm-9">
									<input type="text" id="form-phone" name="phone" class="form-control dateshadow form-phone"/>
								
							</div>
						</div>
					</div>
				</div>

				<div id="payment-div" class="col-md-6">
					<!-- <div class="page-header">
						<h4>
							<span id="sp-payment-title">Short Term Reservation</span>   
						</h4>
					</div> -->

					<div class="fields-div">
						<div id="price-div">
							<div class="sub-header">
								<span class="sub-title"><?php echo WORD_PRICESUM; ?></span>
							</div>

							<div class="sub-content">
								<p><strong><span id="sp-item-name"></span></strong</p>
								<p>Amount: &#8369;<span id="sp-item-cost"></span></p>
							</div>
						</div>

						<!-- <div id="future-div">
							<div class="sub-header">
								<span class="sub-title">Future Prices</span>
							</div>

							<div class="sub-content">
								<p class="pull-left"><span class="sp-item-name">Rental Cost</span></p>
								<p class="pull-right">&#8369;<span class="sp-item-cost"><?php echo RENT_FEE; ?></span></p>
								<div class="clearfix"></div>
							</div>
						</div> -->
						
						
						<div>
							<a href="https://www.paypal.com/ph/webapps/mpp/paypal-popup" target="_blank"> <img src=<?php echo LNK_ROOT . "/image/paypals.png"; ?> width="350px" height="150px" class="pull-right" /></a> 
						</div>
					</div>
					
				</div>
			</div>

			<div class="modal-footer clearfix">
				<fieldset id="form-view-fieldset">
					<input type="hidden" id="start-date-hidden" name="sdate" value="">
					<input type="hidden" id="end-date-hidden" name="edate" value="">
					<button id="btn-reserve" name="reserve" class="btn btn-primary"><?php echo WORD_IRES; ?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo WORD_CANCEL; ?></button>
				</fieldset>
			</div>
			</form>
		</div>
	</div>
</div> <!-- End of modal -->

<script type="text/javascript" src=<?php echo LNK_ROOT . "/js/main.js";?> ></script>

<?php
	if(isset($available) && !$available) {
		$content = "
				  <div class='modal fade' id='unavailable-prompt-modal'>
					<div class='modal-dialog modal-sm'>
					  <div class='modal-content'>
						<div class='modal-body'>
							<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
							<h4 class='modal-title'>Oops..</h4>
							<p>&nbsp;</p>
							<p>The dates you selected are no longer available. Please choose other dates available. Thank you.</p>
							<button type='button' class='btn btn-default pull-right' data-dismiss='modal'>OK</button>
							<div class='clearfix'></div>
						</div>
					  </div>
					</div>
				  </div>
				  ";

		echo $content;
	}

	if( (isset($exists)) && ($exists == 1) ) {
		if ( isset($reserved) && $reserved == 0 ) {
			$content = "
					  <div class='modal fade' id='exists-prompt-modal'>
						<div class='modal-dialog'>
							<div class='modal-content'>
								<div class='modal-header'>
									<button type='button' class='close' data-dismiss='modal'>
										<span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
									</button>
									<div class='clearfix'></div>
								</div>

								<div class='modal-body'>
									<p>A pending reservation has been made with this email address. You can complete your pending reservation by visiting the link sent to your email address or choose YES if you wish to replace it with your new reservation.</p>
									<div class='clearfix'></div>
								</div>

								<div class='modal-footer'>
									<form action='' method='POST'>
										<input type='hidden' name='fname' value='$fname'>
										<input type='hidden' name='lname' value='$lname'>
										<input type='hidden' name='email' value='$email'>
										<input type='hidden' name='phone' value='$phone'>
										<input type='hidden' name='sdate' value='$start_date'>
										<input type='hidden' name='edate' value='$end_date'>
										<button id='btn-yes' name='overwrite' class='btn btn-primary btn-sm'>Yes</button>
										<button type='button' class='btn btn-default btn-sm' data-dismiss='modal'>No</button>
									</form>
								</div>
							</div>
						</div>
					  </div>
			";
		} else if ( isset($reserved) && $reserved != 0 ) {
			$content = "
					  <div class='modal fade' id='exists-prompt-modal'>
						<div class='modal-dialog'>
							<div class='modal-content'>
								<div class='modal-header'>
									<button type='button' class='close' data-dismiss='modal'>
										<span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
									</button>
									<div class='clearfix'></div>
								</div>

								<div class='modal-body'>
									<p>This email has been used on a completed reservation before. Please use other email if you want to make another reservation.</p>
									<div class='clearfix'></div>
								</div>

								<div class='modal-footer'>
									<button type='button' class='btn btn-default btn-sm' data-dismiss='modal'>Close</button>
								</div>
							</div>
						</div>
					  </div>
			";
		}

		echo $content;
	}
?>
</body>
</html>