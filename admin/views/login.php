
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/login-style.css"; ?> />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login - Admin | D&amp;J Home</title>
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
							<span id="sp-title">Login your account here..</span>
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
                            <label for="form-user" class="control-label col-sm-3">Username :</label>
                            <div class="col-sm-9">
                                <input type="text" id="form-user" name="username" class="form-control dateshadow" placeholder="email" value=""/>
                            </div>
                        </div>
    
                        <div class="form-group">
                            <label for="form-password" class="control-label col-sm-3">Password :</label>
                            <div class="col-sm-9">
                                <input type="password" id="form-password" name="user_password" class="form-control dateshadow" placeholder="password" value=""/>
                            </div>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-primary" id="btn-login" name="login">Log In</button>
                        </div>
                    </form>
                </div> <!-- end of div -->
            </div>
        </div>
        
        <!-- Footer div -->
        <div class="footer footer-logged">
            <div class="text-center">
                D&amp;J Apartment Home Rental | Royal Palm Residences Rawai Tower Unit 1106 11th Floor, Acacia Ave, Taguig City 1106
            </div>
            
            <div class="text-center">
                Copyright &copy; 2014 by D&amp;J Lancaster Rental Home Suite
            </div>
        </div>
        <!-- end of footer -->
    </div>
