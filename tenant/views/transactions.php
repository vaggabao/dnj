
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/transactions-style.css";?> />
    <link rel="stylesheet" href=<?php echo LNK_ROOT . "/tenant/css/menu-style.css";?> />
    <link rel="stylesheet" href=<?php echo LNK_SLIDEBAR_CSS; ?> />

    <script type="text/javascript" src=<?php echo LNK_ROOT . "/tenant/js/menu-script.js";?> ></script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Transactions | D&amp;J Home</title>
    <?php
        require_once("classes/Transaction.php"); 
        $transactions = new Transaction();
        $data = $transactions->getTransactions();

        $count = count($data);

        $trans_table = "<table id='transaction-table' class='table table-hover'>";
        $trans_table_headers = "<tr><th>Description</th><th>Amount</th><th>Paypal Email</th><th>Status</th></tr>";
        $trans_table .= $trans_table_headers;

        $trans_table_mobile = "<div id='transaction-table-mobile'>";

        for ($i = 0; $i < $count; $i++) {
            $trans_date = date("F d, Y", strtotime($data[$i]['processing_date']));
            $trans_description = $data[$i]['description'];
            $trans_amount = $data[$i]['amount'];
            $trans_email = strtolower($data[$i]['payer_email']);
            $trans_status = strtoupper($data[$i]['payment_status']);

            $row = "<tr>
            			<td>$trans_description</td>
            			<td>&#8369;$trans_amount</td>
            			<td>$trans_email</td>
            			<td>$trans_status</td>
            		</tr>
            ";

            $trans_table .= $row;

            $row = "<div class='transaction-row-mobile'>
                        <p><strong>Process Date:</strong> $trans_date</p>
                        <p><strong>Description:</strong> $trans_description</p>
                        <p><strong>Amount:</strong> &#8369;$trans_amount</p>
                        <p><strong>Paypal Email:</strong> $trans_email</p>
                        <p><strong>Payment Status:</strong> $trans_status</p>
                    </div>
            ";

            $trans_table_mobile .= $row;
        }

        $trans_table .= "</table>";

        $trans_table_mobile .= "</div>";
    ?>
</head>

<body>
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
							<?php echo WORD_TRANS_TITLE;?>
						</h3>
					</div>

					<!-- transactions div -->
					<div id="transactions-div">
						<?php
							echo $trans_table;
							echo $trans_table_mobile;
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
	