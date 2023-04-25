
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/billing-style.css";?> />
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/menu-style.css";?> />
    <link rel="stylesheet" href=<?php echo LNK_SLIDEBAR_CSS; ?> />

    <script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/menu-script.js";?> ></script>
    <script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/dialog.js";?> ></script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Bills | D&amp;J Home</title>
    <?php
        include("includes/payBills.php");
        require_once("classes/Billing.php");
        $billing = new Billing();
        $data = $billing->getBillingPeriods();

        $count = count($data);

        $billing_table = "<table id='billing-table' class='table table-hover'>";
        $billing_table_headers = "<tr><th>Description</th><th>Amount</th><th>Due Date</th><th>Payment Status</th></tr>";
        $billing_table .= $billing_table_headers;
        $billing_form = "<form role='form' method='POST'>";
        $billing_table .= $billing_form;

        $billing_table_mobile = "<div id='billing-table-mobile'><form role='form' method='POST'>";

        for ($i = 0; $i < $count; $i++) {
            $billing_id = $data[$i]['id'];
            $billing_description = $data[$i]['description'];
            $billing_amount = $data[$i]['amount'];
            $billing_status = strtoupper($data[$i]['payment_status']);
            $billing_due = date("F d, Y", strtotime($data[$i]['due_date']));

            if (!strcasecmp($billing_status, "Paid")) {
                $row = "<tr class='billing-row' data-id='$billing_id'>
                            <td>$billing_description</td>
                            <td>&#8369;$billing_amount</td>
                            <td>$billing_due</td>
                            <td><img src=" . LNK_ROOT . "/tenant/images/check-icon.gif width='15' height='15' style='margin-top: -3px' /> <span>$billing_status</span></td>
                        </tr>";
            } else {
                $row = "<tr class='billing-row' data-id='$billing_id'>
                            <td>$billing_description</td>
                            <td>&#8369;$billing_amount</td>
                            <td>$billing_due</td>
                            <td>$billing_status <button type='submit' class='btn btn-primary btn-xs' name='pay' value='$billing_id'>Pay Now</button>
                            </td>
                        </tr>";
            }
            $billing_table .= $row;


            if (!strcasecmp($billing_status, "Paid")) {
                $row = "<div class='billing-row-mobile billing-row' data-id='$billing_id'>
                            <p><strong>Description:</strong> $billing_description</p>
                            <p><strong>Amount:</strong> &#8369;$billing_amount</p>
                            <p><strong>Due Date:</strong> $billing_due</p>
                            <p><strong>Payment Status:</strong> <img src=" . LNK_ROOT . "/tenant/images/check-icon.gif width='15' height='15' style='margin-top: -3px' /> <span>$billing_status</span></p>
                        </div>";
            } else {
                $row = "<div class='billing-row-mobile billing-row' data-id='$billing_id'>
                            <p><strong>Description:</strong> $billing_description</p>
                            <p><strong>Amount:</strong> &#8369;$billing_amount</p>
                            <p><strong>Due Date:</strong> $billing_due</p>
                            <p><strong>Payment Status:</strong> $billing_status <button type='submit' class='btn btn-primary btn-xs' name='pay' value='$billing_id'>Pay Now</button>
                            </p>
                        </div>";
            }

            $billing_table_mobile .= $row;
        }

        $billing_table .= "</form></table>";
        
        $billing_table_mobile .= "</form></div>";
    ?>
</head>

<body>
	<!-- Billing Summary modal -->
	<div id="billing-summary-modal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><?php echo WORD_BILL_SUMMARY_TITLE;?></h4>
				</div>

				<div class="modal-body">
					<p><?php echo WORD_BILL_SUMMARY_CONTENT;?></p>
				
					<div id="price-summary-table">
					
					</div>
				</div>

				<div class="modal-footer">
					<!--<button id="btn-pay" name="pay" class="btn btn-primary"><?php echo WORD_PAY;?></button>-->
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo WORD_CLOSE;?></button>
				</div>
			</div>
		</div>
	</div> <!-- End of modal -->
	
    <div class="container">
		<div id="sb-site">
			<div class="header header-logged">
				<a id="icon" href=<?php echo LNK_ROOT . "/tenant/dashboard";?> ><span><img class="icon icon-logged" src=<?php echo LNK_ROOT . "/tenant/images/dnj_logo_tenant.png";?> /></span></a>
				<div class="sb-toggle-right	navbar-right">
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
							<?php echo WORD_BILLING_TITLE;?>
						</h3>
					</div>
					
					<p><?php echo WORD_BILLING_CONTENT;?></p>
					<br />

					<!-- transactions div -->
					<div id="billing-div">
						<?php 
							echo $billing_table;
							echo $billing_table_mobile;
						?>
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