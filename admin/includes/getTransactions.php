<?php
    require_once("../../config/config.php");
    require_once("../classes/Transaction.php");
    include("../translations/en.php");

    $criteria = $_POST['criteria'];
    $search = $_POST['search'];
    $txn = new Transaction();
    $data = $txn->getTransactions($criteria, $search);

    $count = count($data);

    $txn_table = "<table id='txn-table' class='table table-hover'>";
    $txn_table_headers = "<tr><th>Name</th><th>Description</th><th>Amount</th><th>Processing Date</th><th>Status</th></tr>";
    $txn_table .= $txn_table_headers;

    $txn_table_mobile = "<div id='txn-table-mobile'><h3>Transactions</h3><br>";

    for ($i = 0; $i < $count; $i++) {
        $txn_name = ucwords(strtolower($data[$i]['name']));
        $txn_desc = $data[$i]['description'];
        $txn_amount = $data[$i]['amount'];
        $txn_status = $data[$i]['payment_status'];
        $txn_date = date("F d, Y", strtotime($data[$i]['processing_date']));

        if (strcasecmp($txn_status, "pending") == 0) {
            // pending
            $row = "<tr>
                        <td>$txn_name</td>
                        <td>$txn_desc</td>
                        <td>&#8369;$txn_amount</td>
                        <td>$txn_date</td>
                        <td><span class='text-muted'>" . strtoupper($txn_status) . "</span></td>
                    </tr>";

            $mrow = "<div class='txn-row-mobile'>
                        <p>Name: $txn_name</p>
                        <p>Description: $txn_desc</p>
                        <p>Amount: &#8369;$txn_amount</p>
                        <p>Processing Date: $txn_date</p>
                        <p>Status: <span class='text-muted'>" . strtoupper($txn_status) . "</span></p>
                    </div>";
        } else if (strcasecmp($txn_status, "completed") == 0) {
            // completed
            $row = "<tr>
                        <td>$txn_name</td>
                        <td>$txn_desc</td>
                        <td>&#8369;$txn_amount</td>
                        <td>$txn_date</td>
                        <td><span class='text-success'>" . strtoupper($txn_status) . "</span></td>
                    </tr>";

            $mrow = "<div class='txn-row-mobile'>
                        <p>Name: $txn_name</p>
                        <p>Description: $txn_desc</p>
                        <p>Amount: &#8369;$txn_amount</p>
                        <p>Processing Date: $txn_date</p>
                        <p>Status: <span class='text-success'>" . strtoupper($txn_status) . "</span></p>
                    </div>";
        }

        $txn_table .= $row;
        $txn_table_mobile .= $mrow;
    }

    if ($count == 0) {
        $row = "<tr>
                    <td colspan=5 class=text-center>No transactions found</td>
                </tr>";

        $mrow = "<div class='txn-row-mobile text-center'>
                    <p>No transactions found</p>
                </div>";
        $txn_table .= $row;
        $txn_table_mobile .= $mrow;
    }

    $txn_table .= "</table>";
    $txn_table_mobile .= "</div>";

    $content = $txn_table . $txn_table_mobile;

    echo $content;
?>