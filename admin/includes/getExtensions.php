<?php
    require_once("../../config/config.php");
    require_once("../classes/Extensions.php");
    include("../translations/en.php");

    $criteria = $_POST['criteria'];
    $search = $_POST['search'];
    $extension = new Extension();
    $data = $extension->getExtensions($criteria, $search);


    // $data = objectToArray($data);
    $count = count($data);

    $extensions_table = "<table id='extensions-table' class='table table-hover'>";
    $extensions_table_headers = "<tr><th>Tenant</th><th>Current Stay</th><th>Date Requested</th><th>Status</th></tr>";
    $extensions_table .= $extensions_table_headers;

    $extensions_table_mobile = "<div id='extensions-table-mobile'><h3>Requests</h3><br>";

    for ($i = 0; $i < $count; $i++) {
        $extensions_id = $data[$i]['id'];
		$extensions_name = ucwords(strtolower($data[$i]['fname'])) . " " . ucwords(strtolower($data[$i]['lname']));
		$extensions_stay = date("F d, Y", strtotime($data[$i]['start_date'])) . " to " . date("F d, Y", strtotime($data[$i]['end_date']));
		$extensions_date = date("F d, Y", strtotime($data[$i]['extension_date']));
        $extensions_cancelled = $data[$i]['is_cancelled'];
        $extensions_accepted = $data[$i]['is_accepted'];

        if ($extensions_cancelled == 0 && $extensions_accepted == 0) {
            // new requests
            $row = "<tr>
                        <td>$extensions_name</td>
                        <td>$extensions_stay</td>
                        <td>$extensions_date</td>
                        <td>
                            <button type=submit class='btn btn-primary btn-xs btn-request' name='request-accept' value='$extensions_id'>Accept</button>
                            <button type=submit class='btn btn-danger btn-xs btn-cancel' name='request-cancel' value='$extensions_id'>Reject</button>
                        </td>
                    </tr>";

            $mrow = "<div class='extensions-row-mobile'>
                        <p>Tenant Name: $extensions_name</p>
                        <p>Current Stay: $extensions_stay</p>
                        <p>Date Requested: $extensions_date</p>
                        <div class='text-right'>
                            <button type=submit class='btn btn-primary btn-xs btn-request' name='request-accept' value='$extensions_id'>Accept</button>
                            <button type=submit class='btn btn-danger btn-xs btn-cancel' name='request-cancel' value='$extensions_id'>Reject</button>
                        </div>
                    </div>";
        } else if ($extensions_cancelled == 1) {
            // rejected/cancelled requests
            $row = "<tr>
                        <td>$extensions_name</td>
                        <td>$extensions_stay</td>
                        <td>$extensions_date</td>
                        <td><span class='text-danger'>Cancelled</span></td>
                    </tr>";

            $mrow = "<div class='extensions-row-mobile'>
                        <p>Tenant Name: $extensions_name</p>
                        <p>Current Stay: $extensions_stay</p>
                        <p>Date Requested: $extensions_date</p>
                        <p>Status: <span class='text-danger'>Cancelled</span></p>
                    </div>";
        } else if ($extensions_accepted == 1) {
            // accepted requests
            $row = "<tr>
                        <td>$extensions_name</td>
                        <td>$extensions_stay</td>
                        <td>$extensions_date</td>
                        <td><span class='text-success'>Accepted</span></td>
                    </tr>";

            $mrow = "<div class='extensions-row-mobile'>
                        <p>Tenant Name: $extensions_name</p>
                        <p>Current Stay: $extensions_stay</p>
                        <p>Date Requested: $extensions_date</p>
                        <p>Status: <span class='text-success'>Accepted<span></p>
                    </div>";
        }

        $extensions_table .= $row;
        $extensions_table_mobile .= $mrow;
    }

    if ($count == 0) {
        $row = "<tr>
                    <td colspan=4 class=text-center>No requests found.</td>
                </tr>";

        $mrow = "<div class='extensions-row-mobile text-center'>
                    <p>No requests found.</p>
                </div>";
        $extensions_table .= $row;
        $extensions_table_mobile .= $mrow;
    }

    $extensions_table .= "</table>";
    $extensions_table_mobile .= "</div>";

    $content = $extensions_table . $extensions_table_mobile;

    echo $content;
?>