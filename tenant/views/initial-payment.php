
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/initial-style.css";?> />
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/menu-style.css";?> />
    <link rel="stylesheet" href=<?php echo LNK_SLIDEBAR_CSS; ?> />

    <script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/menu-script.js";?> ></script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Verification | D&amp;J Home</title>
</head>

<body>
    <div class="container">
        <div id="sb-site">
            <div class="header header-logged">
                <a id="icon" href=<?php echo LNK_ROOT . "/tenant/dashboard";?> ><span><img class="icon icon-logged" src=<?php echo LNK_ROOT . "/tenant/images/dnj_logo_tenant.png";?> /></span></a>
                <div class="sb-toggle-right navbar-right">
                    <div class="navicon-line"></div>
                    <div class="navicon-line"></div>
                    <div class="navicon-line"></div>
                </div>
                <?php include "views/nav.php"; ?>
            </div>
                
            <div class="content content-logged">
                <div class="main-content">
                    <div id="page-title-div">
                        <h3>
                            <?php echo WORD_WELCOME . ucwords(strtolower($_SESSION['tenant_fname'] . " " . $_SESSION['tenant_lname'])); ?>! 
                        </h3>
                    </div>

                    <!-- initial payment div -->
                    <div id="initial-div">
                        <?php
                            include("includes/payBills.php");
                            require_once("classes/Account.php");
                            require_once("classes/Billing.php");
                            $account = new Account();
                            $billing = new Billing();

                            // fetch tenant info
                            $data_account = $account->getAccountInfo();
                            $data_account = objectToArray($data_account);

                            // fetch first billing period
                            $data_billing = $billing->getBillingPeriods();
                            $billing_id = $data_billing[0]['id'];
                            $billing_description = $data_billing[0]['description'];
                            $billing_amount = $data_billing[0]['amount'];
                            $billing_due = date("F d, Y", strtotime($data_billing[0]['due_date']));

                            $rent_term = $data_account['rent_term'];

                            if (strcasecmp($rent_term, "LONG") == 0) {
                                $content = WORD_INITIAL_CONTENT_1;
                            } else {
                                $content = WORD_INITIAL_CONTENT_2;
                            }

                            function objectToArray($d) {
                                if (is_object($d)) {
                                    // Gets the properties of the given object
                                    // with get_object_vars function
                                    $d = get_object_vars($d);
                                }
                         
                                if (is_array($d)) {
                                    /*
                                    * Return array converted to object
                                    * Using __FUNCTION__ (Magic constant)
                                    * for recursive call
                                    */
                                    return array_map(__FUNCTION__, $d);
                                }
                                else {
                                    // Return array
                                    return $d;
                                }
                            }
                        ?>
                        <div class="panel panel-primary">
							<div class="panel-heading">
								Verification Process: <?php echo $billing_description; ?>
							</div>
							
							<div class="panel-body">		
								<p><?php echo $content; ?></p>		
							
								<div class="text-right">
									<form role="form" method="POST">
										<button type="submit" id="btn-entry-pay" class="btn btn-primary btn-xs" name="pay" value=<?php echo $billing_id; ?> >Pay now</button>
									</form>
									<p><small><i><?php echo WORD_INITIAL_CONTENT_3;?></i></small></p>
								</div>
							</div>
							
							<?php
								// fetch billing details
								$data_billing_details = $billing->getBillingDetails($billing_id);
								$count = count($data_billing_details);
								$billing_table_details = "<table class='table table-hover' style='margin: 20px 0;'>";
								$table_headers = "<tr><th><small>Description</small></th><th><small>Amount</small></th></tr>";
								$billing_table_details .= $table_headers;

								for ($i =  0; $i < $count; $i++) {
									$billing_desc_id = $data_billing_details[$i]['id'];
									$description = $data_billing_details[$i]['description'];
									$amount = $data_billing_details[$i]['amount'];

									$row = "<tr>
												<td><small>$description</small></td>
												<td><small>&#8369;$amount</small></td>
											</tr>
									";

									$billing_table_details .= $row;
								}
								$row = "<tr>
											<td><strong>Total Cost</strong></td>
											<td><strong>&#8369;$billing_amount</strong></td>
										</tr>
								";

								$billing_table_details .= $row;
								$billing_table_details .= "</table>";
								
								echo $billing_table_details;
							?>
                        </div>
                    </div> <!-- end of div -->
                </div>
            </div>
	
			<div class="footer footer-logged">
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
    </div>
	
	<?php
		include("views/sidenav.php");
	?>