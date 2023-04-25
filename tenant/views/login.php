
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/login-style.css"; ?> />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>Login | D&amp;J Home</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <img class="icon" src=<?php echo LNK_ROOT . "/tenant/images/dnj_logo.png"; ?> />
        </div>
                
        <div class="content">
            <div class="main-content text-center">
                
                <!-- tenant form div -->
                <div id="login-div">				
					<div id="page-title-div">
						<h3>
							<span id="sp-title"><?php echo WORD_LOGIN_TITLE;?></span>
						</h3>
					</div>
					<?php
						if ($login->errors) {
							$content = "<div class='alert alert-danger alert-dismissable' role='alert'>
										<button type='button' class='close' data-dismiss='alert'>
											<span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
										</button>";
							foreach ($login->errors as $error) {
								$content .= "<p>" . $error . "</p>";
							}
							$content .= "<div class='clearfix'></div></div>";
							echo $content;
						}
					?>
					
                    <form class="form-horizontal" role="form" action="" method="POST">
                        <div class="form-group">
                            <label for="form-user" class="control-label col-sm-3"><?php echo WORD_LOGIN_LABEL_1;?></label>
                            <div class="col-sm-9">
                                <input type="text" id="form-user" name="user_email" class="form-control dateshadow" placeholder="email" value=""/>
                            </div>
                        </div>
    
                        <div class="form-group">
                            <label for="form-password" class="control-label col-sm-3"><?php echo WORD_LOGIN_LABEL_2;?></label>
                            <div class="col-sm-9">
                                <input type="password" id="form-password" name="user_password" class="form-control dateshadow" placeholder="password" value=""/>
                            </div>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-primary" id="btn-login" name="login"><?php echo WORD_LOGIN_LABEL_3;?></button>
                        </div>
                    </form>
                </div> <!-- end of div -->
            </div>
        </div>
        
		<div class="footer">
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
    </div>
