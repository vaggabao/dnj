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
 	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/mobile-style.css";?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/indexstyle.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/mobile/css/calendar-style.css?" . md5(uniqid()); ?> />
	<link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/calendar.css"; ?> />
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
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/mobile/js/calendar.js?" . md5(uniqid()); ?> ></script>
    <script>
        $(function() {
			$("#main").show("fade", 1000);
        });
    </script>
    

    <title>Calendar | D&amp;J Lancaster Home Suite</title>
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
			<div id="filter-div">
				<form id="form-filter" role="form" method="POST">
					<div id="filter-header-div">
						<span>Filter Calendar View</span>
						
						<div class="pull-right">
							<button type="submit" id="btn-filter" class="btn btn-default btn-xs">Filter</button>
						</div>
					</div>
					
					<div id="filter-criteria-div" class="row">
						<div id="start-date-div" class="form-group col-sm-6 text-center">
							<div style="display: inline-block">
								<label class="control-label pull-left" style="width: 60px">From : </label>
								
								<div class="pull-left">
									<div class="pull-left">
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
									</div>

									<div class="pull-left">
										<input type="text" name="start-year-text" id="start-year-text" class="form-control form-year" placeholder="yyyy" value="<?php echo date('Y'); ?>" />
									</div>
								</div>
								
								<div class="clearfix"></div>
							</div>
						</div>

						<div id="end-date-div" class="form-group col-sm-6 text-center">
							<div style="display: inline-block">
								<label class="control-label pull-left" style="width: 60px">To :</label>
								
								<div class="pull-left">
									<div class="pull-left">
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
									</div>
									
									<div class="pull-left">
										<input type="text" name="end-year-text" id="end-year-text" class="form-control form-year" placeholder="yyyy" value="<?php echo date('Y'); ?>" />
									</div>
								</div>
								
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</form>

				<div id="info-div">
					<p class="reserv-fnt-cal"> <?php echo WORD_CALENDAR_MSG; ?></p>
					<br/>
					<p class="reserv-fnt-cal"> <?php echo WORD_CAL_MSG_NOTE; ?></p>
				</div>
				
				<div id="filter-header-div">
					<span>Legend</span>
				</div>
				
				<div id="legends-div">
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
					
					<div class="pull-left">
						<div class="pull-left col">
							<div id="icon-occupied"></div>
						</div>
						
						<div class="pull-left col">
							Occupied
						</div>
					</div>
					
					<div class="pull-left">
						<div class="pull-left col">
							<div id="icon-reserved"></div>
						</div>
						
						<div class="pull-left col">
							Reserved
						</div>
					</div>
					
					<div class="clearfix"></div>
				</div>
			</div>
			

			<!-- Display calendars here -->
			<div id="calendar-div"></div>
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