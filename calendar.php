<?php
    ob_start();
	
	// include links
    include_once("config/links.php");
	
	// require Mobile_Detect Class
	require_once("Classes/Mobile_Detect.php");
	$detect = new Mobile_Detect;
	
	if ( $detect->isMobile() ) {
		header("Location: " . LNK_ROOT . "/mobile/calendar");
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
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_FONTS_CSS; ?> />

	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/main.css"; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/about-style.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/indexstyle.css?" . md5(uniqid());?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/calendar-style.css"; ?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/calendar.css"; ?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_SLIDEBAR_CSS; ?> />
	<link href="http://fonts.googleapis.com/css?family=Calligraffitti" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    
    <link rel="shortcut icon" href=<?php echo LNK_ROOT . "/image/dnj_icon.png"; ?> >
	<script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/calendar.js"; ?> ></script>
    <script>
        $(function() {
			$("#main").show("fade", 1000);
            // $("#left").hide();
            $(".main-content").show("fade", 1000);
            // $("#right-div").hide();
            // $("#right-div").show("fade", 1000);
        });
    </script>
	
	<title>Calendar | D&amp;J Lancaster Home Suite</title>
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
            <div class="main-content">
            
                <div id="filter-divmain" class="text-center">
                    <form id="form-filter" role="form" method="POST">
                        <div id="filter-header-divmain">
                            <h4 class="page-title">Filter Calendar View</h4>
                        </div>
                        
                        <div id="filter-criteria-div" class="row">
                            <div id="start-date-div" class="form-group col-md-6">
                                <div class="form-inline pull-right">
                                    <select name="start-month-select" id="start-month-select" class="form-control form-select">
                                        <option value="0">SELECT MONTH</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <input type="text" name="start-year-text" id="start-year-text" class="form-control form-year" placeholder="yyyy" value="<?php echo date('Y'); ?>" />
                                </div>
                                <label class="control-label pull-right">From:</label>
                            </div>
                
                            <div id="end-date-div" class="form-group col-md-6">
                                <label class="control-label pull-left">To:</label>
                                <div class="form-inline pull-left">
                                    <select name="end-month-select" id="end-month-select" class="form-control form-select">
                                        <option value="0">SELECT MONTH</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                
                                    <input type="text" name="end-year-text" id="end-year-text" class="form-control form-year" placeholder="yyyy" value="<?php echo date('Y'); ?>" />
                                </div>
                                    
                            <div class="pull-left">
                                <button type="submit" id="btn-filter" class="calview-fnt">Filter</button>
                            </div>
                            </div>
                            
                            <div class="clearfix"></div>
                                                      
                            <p class="reserv-fnt-cal"> <?php echo WORD_CALENDAR_MSG; ?></p>
                            <p class="reserv-fnt-cal"> <?php echo WORD_CALENDAR_MSG1; ?></p>
                            <br/>
                            <p class="reserv-fnt-cal italicfont"> <?php echo WORD_CAL_MSG_NOTE; ?></p>
                             
                            <div id="legends-div" align="center">
                                <img src="image/viewcalegends.png" />
                            </div>
                        </div>
                    </form>
                </div>
        
                <!-- Display calendars here -->
                <div id="calendar-div">
        
                </div>
            
                <div class="clearfix"></div>
            </div>
		</div> <!-- end content -->
		
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