<?php
    ob_start();
	
	// include links
    include_once("config/links.php");
	
	// require Mobile_Detect Class
	require_once("Classes/Mobile_Detect.php");
	$detect = new Mobile_Detect;
	
	if ( $detect->isMobile() ) {
		header("Location: " . LNK_ROOT . "/mobile/gallery");
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
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/gallery-style.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/jquery.flipster.css";?> />
    <link type="text/css" rel="stylesheet" href=<?php echo LNK_ROOT . "/css/lightbox.css";?> media="screen" />
    <link rel="shortcut icon" href=<?php echo LNK_ROOT . "/image/dnj_icon.png"; ?> >
	<link href="http://fonts.googleapis.com/css?family=Calligraffitti" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

    
    <script type="text/javascript" src=<?php echo LNK_JQUERY_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_JQUERY_UI_JS; ?> ></script>
    <script type="text/javascript" src=<?php echo LNK_BOOTSTRAP_JS; ?> ></script>
    
	<script type="text/javascript" src=<?php echo LNK_ROOT . "/js/jquery.flipster.js";?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/dialog.js";?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/js/lightbox.js";?> ></script>
    <script>
        $(function() {
            $(".main-content").show("fade", 1000, function() {
                $(".flipster").init();
				$(".flipster").flipster({
					style: 'carousel',
					start: 0
				});
            });
        });
    </script>

	<title>Gallery | D&amp;J Lancaster Home Suite</title>
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
            <div class="main-content">
                <div class="textgallery">
                	Gallery
                </div>                
                <!-- Flipster List -->	
                <div class="flipster">
                    <ul>
        			    <a id="btn-gallery">
                        <li><img src="<?php echo LNK_ROOT . '/image/a1.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a2.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a3.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a4.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a5.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a6.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a7.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a8.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a9.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a10.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a11.jpg?' . md5(uniqid());?>" /></li>	
                        <li><img src="<?php echo LNK_ROOT . '/image/a12.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a13.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a14.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a15.jpg?' . md5(uniqid());?>" /></li>
						<li><img src="<?php echo LNK_ROOT . '/image/a19.jpg?' . md5(uniqid());?>" /></li>	
                        <li><img src="<?php echo LNK_ROOT . '/image/a20.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a21.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a22.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a23.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a24.jpg?' . md5(uniqid());?>" /></li>
						<li><img src="<?php echo LNK_ROOT . '/image/a25.jpg?' . md5(uniqid());?>" /></li>	
                        <li><img src="<?php echo LNK_ROOT . '/image/a26.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a27.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a28.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a29.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a30.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a31.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a32.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a33.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a34.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a35.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a36.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a37.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a38.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a39.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a41.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a42.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a43.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a44.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a45.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a46.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a47.jpg?' . md5(uniqid());?>" /></li>
                        <li><img src="<?php echo LNK_ROOT . '/image/a48.jpg?' . md5(uniqid());?>" /></li>
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
