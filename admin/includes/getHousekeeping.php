<?php
    require_once("../../config/config.php");
    require_once("../classes/Housekeeping.php");
    include("../translations/en.php");

    $criteria = $_POST['criteria'];
    $search = $_POST['search'];
    $housekeeping = new Housekeeping();
    $data = $housekeeping->getHousekeeping($criteria, $search);


    // $data = objectToArray($data);
    $count = count($data);

    $hk_table = "<table id='hk-table' class='table table-hover'>";
    $hk_table_headers = "<tr><th>Tenant</th><th>Cleaning Date</th><th>Status</th></tr>";
    $hk_table .= $hk_table_headers;

    $hk_table_mobile = "<div id='hk-table-mobile'><h3>Requests</h3><br>";

    for ($i = 0; $i < $count; $i++) {
        $hk_id = $data[$i]['id'];
        $hk_name = ucwords(strtolower($data[$i]['fname'])) . " " . ucwords(strtolower($data[$i]['lname']));
        $hk_date = date("F d, Y", strtotime($data[$i]['housekeeping_date']));
        $hk_cancelled = $data[$i]['is_cancelled'];
        $hk_paid = $data[$i]['is_paid'];
        $hk_done = $data[$i]['is_done'];

        if ($hk_cancelled == 0 && $hk_paid == 0 && $hk_done == 0) {
            // new
            $row = "<tr>
                        <td>$hk_name</td>
                        <td>$hk_date</td>
                        <td>
                            <button type=submit class='btn btn-danger btn-xs btn-cancel' name='request-cancel' value='$hk_id'>Cancel</button>
                        </td>
                    </tr>";

            $mrow = "<div class='hk-row-mobile'>
                        <p>Tenant Name: $hk_name</p>
                        <p>Cleaning Date: $hk_date</p>
                        <div class='text-right'>
                            <button type=submit class='btn btn-danger btn-xs btn-cancel' name='request-cancel' value='$hk_id'>Cancel</button>
                        </div>
                    </div>";
        } else if ($hk_cancelled == 0 && $hk_paid == 1 && $hk_done == 1 ) {
            // done
            $row = "<tr>
                        <td>$hk_name</td>
                        <td>$hk_date</td>
                        <td><strong><span class='text-success'>DONE</span></strong></td>
                    </tr>";

            $mrow = "<div class='hk-row-mobile'>
                        <p>Tenant Name: $hk_name</p>
                        <p>Cleaning Date: $hk_date</p>
                        <p>Status: <strong><span class='text-success'>DONE</span></strong></p>
                    </div>";
        } else if ($hk_cancelled == 0 && $hk_paid == 1 && $hk_done == 0) {
            // not done
            $row = "<tr>
                        <td>$hk_name</td>
                        <td>$hk_date</td>
                        <td>
                            <button type=submit class='btn btn-success btn-xs btn-done' name='request-done' value='$hk_id'>Done</button>
                        </td>
                    </tr>";

            $mrow = "<div class='hk-row-mobile'>
                        <p>Tenant Name: $hk_name</p>
                        <p>Cleaning Date: $hk_date</p>
                        <div class='text-right'>
                            <button type=submit class='btn btn-success btn-xs btn-done' name='request-done' value='$hk_id'>Done</button>
                        </div>
                    </div>";
        } else if ($hk_cancelled == 1 && $hk_paid == 0 && $hk_done == 0) {
            // cancelled
            $row = "<tr>
                        <td>$hk_name</td>
                        <td>$hk_date</td>
                        <td><strong><span class='text-danger'>CANCELLED</span></strong></td>
                    </tr>";

            $mrow = "<div class='hk-row-mobile'>
                        <p>Tenant Name: $hk_name</p>
                        <p>Cleaning Date: $hk_date</p>
                        <p>Status: <strong><span class='text-danger'>CANCELLED</span></strong></p>
                    </div>";
        }

        $hk_table .= $row;
        $hk_table_mobile .= $mrow;
    }

    if ($count == 0) {
        $row = "<tr>
                    <td colspan=4 class=text-center>No requests found.</td>
                </tr>";

        $mrow = "<div class='hk-row-mobile text-center'>
                    <p>No requests found.</p>
                </div>";
        $hk_table .= $row;
        $hk_table_mobile .= $mrow;
    }

    $hk_table .= "</table>";
    $hk_table_mobile .= "</div>";

    $content = $hk_table . $hk_table_mobile;

    echo $content;
?>