<?php
ob_start();
// error_reporting(0);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
		// require PHPMailer Class
        require("libraries/PHPMailer.php");
		
		// include links
        include_once("config/links.php");
	
		// require Mobile_Detect Class
		require_once("Classes/Mobile_Detect.php");
		$detect = new Mobile_Detect;
		
		if ( $detect->isMobile() ) {
			header("Location: " . LNK_ROOT . "/mobile/reservation");
			exit(0);
		}
		
		// include config
        include_once("config/config.php");
		
		// include dbConnect
        include_once("config/dbConnect.php");
		
		// include globals
        include_once("config/globals.php");
	
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
	
        include("includes/payReservation.php");
    ?>

    <link type="text/css" rel="stylesheet" href=<?php echo LNK_BOOTSTRAP_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_JQUERY_UI_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SCROLLBAR_CSS; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_FONTS_CSS; ?> />
    <link rel="stylesheet" type="text/css" href=<?php echo LNK_INTTELINPUT_CSS; ?> />    
    
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/indexstyle.css?" . md5(uniqid());?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/datepicker.css?" . md5(uniqid());?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/reservation-style.css?" . md5(uniqid());?> />
    <link rel="shortcut icon" href=<?php echo LNK_ROOT . "/image/dnj_icon.png"; ?> >
	<link href="http://fonts.googleapis.com/css?family=Calligraffitti" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/jquery.cycle.all.js?" . md5(uniqid()); ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/dialog.js?" . md5(uniqid());?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/booking.js?" . md5(uniqid());?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/validate-reserve-form.js?" . md5(uniqid());?> ></script>
	<script type="text/javascript" src=<?php echo LNK_INTTELINPUT_JS; ?> ></script>	
    <script>
        $(function() {
            $(".main-content").show("fade", 1000);
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
        
        <div class="content content-reservation">
            <div class="main-content row">
                <div class="reserv-div col-md-7">
                    <h4 class="textreserve">
                        <?php echo WORD_RES; ?>
                    </h4> 
                    <?php echo WORD_RESTEXT; ?><br/>
                   
                    <h4 class="textamenities"><?php echo WORD_PRICE; ?></h4>
                    <h4 class="textamenities"><?php echo WORD_SHORT; ?></h4>
                    <p>
                    <?php echo WORD_SHORTTEXT1; ?><?php echo WORD_PHP; ?><?php echo number_format(SHORT_TERM_FEE); ?>
					<?php echo WORD_SHORTTEXT1_1; ?><br/>
                    <?php echo WORD_SHORTTEXT4; ?><?php echo WORD_PHP; ?><?php echo number_format(DEPOSIT_FEE); ?><?php echo WORD_SHORTTEXT4_1; ?><br/>
                    <?php echo WORD_PHP; ?><?php echo number_format(SHORT_NO_BILLS_FEE); ?><?php echo WORD_SHORTTEXT2; ?><br/>
                    <?php echo WORD_PHP; ?><?php echo number_format(SHORT_WITH_BILLS_FEE); ?><?php echo WORD_SHORTTEXT3; ?><br/>
                    <h4 class="textamenities"><?php echo WORD_LONG; ?></h4>
                    <?php echo WORD_LONGTEXT1; ?><?php echo WORD_PHP; ?><?php echo number_format(LONG_TERM_FEE); ?>
					<?php echo WORD_LONGTEXT1_1; ?><br/>
                    <?php echo WORD_PHP; ?><?php echo number_format(RENT_FEE); ?><?php echo WORD_LONGTEXT2; ?><br/>
                    <?php echo WORD_PHP; ?><?php echo number_format(RENT_FEE_3_ABOVE); ?><?php echo WORD_LONGTEXT2_2; ?><br/>
                    <?php echo WORD_LONGTEXT3; ?> <br/> <?php echo WORD_LONGTEXT4; ?> <br/>
                    <br/>
                     
                    <h4 class="textamenities"><?php echo WORD_EXTEND; ?></h4>
                    <?php echo WORD_EXTENDTEXT; ?><br/>
                     
                    <h4 class="textamenities"><?php echo WORD_CHECKIN; ?></h4>
                    <?php echo WORD_CHECKINTEXT1; ?><br/>
                    <?php echo WORD_CHECKINTEXT2; ?><br/><br/>

                    <?php echo WORD_OPEN; ?><br/>  <?php echo WORD_OPEN1; ?><br/>
                    
                    <?php echo WORD_OPEN2; ?> <a href="about.php"class="navtext"><?php echo WORD_CONTACT;?>.</a><br/><br/><br/>
                    </p>
                 
                </div>

                <div class="reserv-div col-md-5">

                    <!-- select dates div -->
                    <div id="dateDiv" class="reserv-border text-center" style="margin: 20px; padding:30px;">
                    	<div>
                        	<a href="calendar.php" class="calview-fnt pull-right"><?php echo WORD_VIEWCAL; ?></a>
                        </div>
                        <div class="paypal_line">
                        	<a href="https://www.paypal.com/ph/webapps/mpp/paypal-popup" target="_blank"> <img src="image/Paypal-Logo.png" width="100px" height="30px" class="pull-left" /></a> 
                        </div>
						<div class="clearfix"></div>
                        <br/>
                        <h4 class="textreserve">
                            <?php echo WORD_BOOK; ?>
                        </h4>

                        <div id="startDiv" class="arriveDate col-md-6">
                            <label class="control-label" for="startDate">
                                <h4><?php echo WORD_ARRIVED; ?></h4>
                            </label>
                            <input type="text" id="startDate" class="form-control dateshadow text-center" placeholder="YYYY-MM-DD" readonly="readonly" />
                        </div>
    
                        <div id="endDiv" class="departDate col-md-6">
                            <label class="control-label" for="endDate">
                                <h4><?php echo WORD_DEPART; ?></h4>
                            </label>
                            <input type="text" id="endDate" class="form-control dateshadow text-center" placeholder="YYYY-MM-DD"  readonly />
                        </div>

                        <div class="clearfix"></div>

                        <div id="errMsg" class="alert alert-warning" style="margin: 14px; display: none;"></div>

                        <button class="btn btn-default btn-margin dateshadow" id="btnBook"><?php echo WORD_CPRICE; ?></button>
                        <br/>
                        <p class="reserv-fnt"> <?php echo WORD_LEGENDS; ?></p>
                        <div>
                        	<img src="image/Legends.png" />
                        </div>
                        
                    </div>
                    <!-- end select dates div -->
                    
                    <!-- message owner div -->
                    <div class="reserv-border text-center" style="margin: 20px; padding: 20px;">
                        <h4 class="textreserve">
                            <?php echo WORD_MOWNER; ?>
                        </h4>

                        <form class="form" role="form" method="POST">
                            <div id="detailsDiv">
                                <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/message-owner.js?" . md5(uniqid()); ?>></script>
                                <style>
                                    .element-hide {
                                        display: none;
                                    }
                                </style>

                                <div id="send-alert-success" class="alert alert-success element-hide"></div>

                                <div id="send-alert-failed" class="alert alert-danger element-hide"></div>

                                <div class="form-group col-md-6">
                                    <label for="efname" class="control-label">
                                        <h4><?php echo WORD_FNAME; ?></h4>
                                    </label>
                                    <input type="text" id="send-fname" name="fname" class="form-control dateshadow" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="elname" class="control-label">
                                        <h4><?php echo WORD_LNAME; ?></h4>
                                    </label>
                                    <input type="text" id="send-lname" name="lname" class="form-control dateshadow" />
                                </div>
            
                                <div class="form-group col-md-6">
                                    <label for="eemail" class="control-label">
                                        <h4><?php echo WORD_EMAIL; ?></h4>
                                    </label>
                                    <input type="text" id="send-email" name="email" class="form-control dateshadow" />
                                </div>
            
                                <div class="form-group col-md-6 text-left">
                                    <label for="ephone" class="control-label">
                                        <h4><?php echo WORD_PHONE; ?></h4>
                                    </label>
                                    <input type="text" id="send-phone" name="phone" class="form-control dateshadow form-phone" />
                                </div>

                                <div class="form-group col-md-12">
                                    <textarea id="send-msg" name="msgowner" class="form-control dateshadow" cols="60" rows="10" placeholder="Your message here..." style="resize: none;"></textarea>
                                </div>

                                <div class="reserv-margin">
                                    <button class="btn btn-warning" id="btn-send">
                                        <?php echo WORD_SMAIL; ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- end of message owner div -->
                    <div>
                    	
                    </div>
                </div>

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
                                                <p class="pull-left"><span id="sp-item-name"></span></p>
                                                <p class="pull-right">&#8369;<span id="sp-item-cost"></span></p>
                                                <div class="clearfix"></div>
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
                        					<a href="https://www.paypal.com/ph/webapps/mpp/paypal-popup" target="_blank"> <img src="image/paypals.png" width="350px" height="150px" class="pull-right" /></a> 
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