<?php
    require_once("../../config/config.php");
    require_once("../classes/Tenant.php");
    include("../translations/en.php");

    $criteria = $_POST['criteria'];
    $search = $_POST['search'];
    $tenant = new Tenant();
    $data = $tenant->getTenants($criteria, $search);


    // $data = objectToArray($data);
    $count = count($data);

    $tenant_table = "<table id='tenant-table' class='table'>";
    $tenant_table_headers = "<tr><th>Tenant Name</th><th>Arrive Date</th><th>Depart Date</th><th>Status</th></tr>";
    $tenant_table .= $tenant_table_headers;

    $tenant_table_mobile = "<div id='tenant-table-mobile'><h3>Result(s)</h3><br>";

    for ($i = 0; $i < $count; $i++) {
        $tenant_id = $data[$i]['id'];
        $tenant_name = ucwords(strtolower($data[$i]['fname'])) . " " . ucwords(strtolower($data[$i]['lname']));
        $tenant_arrive = date("F d, Y", strtotime($data[$i]['start_date']));
        $tenant_depart = date("F d, Y", strtotime($data[$i]['end_date']));
        $tenant_verified = $data[$i]['is_verified'];
        $tenant_expired = $data[$i]['is_expired'];
        $tenant_registered = $data[$i]['is_registered'];
        $tenant_active = $data[$i]['is_active'];

        if ($tenant_active == 1) {
            // active
            $row = "<tr class='row-tenant' data-id=$tenant_id>
                        <td>$tenant_name</td>
                        <td>$tenant_arrive</td>
                        <td>$tenant_depart</td>
                        <td><strong><span class='text-success'>ACTIVE</span></strong></td>
                    </tr>";

            $mrow = "<div class='tenant-row-mobile'>
                        <p>Tenant Name: $tenant_name</p>
                        <p>Arrive Date: $tenant_arrive</p>
                        <p>Depart Date: $tenant_depart</p>
                        <p>Status: <strong><span class='text-success'>ACTIVE</span></strong></p>
                        <div class='text-right'>
                            <button type=submit class='btn btn-primary btn-xs btn-view' name='view-tenant' value='$tenant_id'>View Info</button>
                        </div>
                    </div>";
        } else if ($tenant_active == 0 && $tenant_expired == 0) {
            // inactive
            $row = "<tr class='row-tenant' data-id=$tenant_id>
                        <td>$tenant_name</td>
                        <td>$tenant_arrive</td>
                        <td>$tenant_depart</td>
                        <td><span class='text-muted'>INACTIVE</span></td>
                    </tr>";

            $mrow = "<div class='tenant-row-mobile'>
                        <p>Tenant Name: $tenant_name</p>
                        <p>Arrive Date: $tenant_arrive</p>
                        <p>Depart Date: $tenant_depart</p>
                        <p>Status: <strong><span class='text-muted'>INACTIVE</span></strong></p>
                        <div class='text-right'>
                            <button type=submit class='btn btn-primary btn-xs btn-view' name='view-tenant' value='$tenant_id'>View Info</button>
                        </div>
                    </div>";
        } else if ($tenant_expired == 1) {
            // expired account
            $row = "<tr class='row-tenant' data-id=$tenant_id>
                        <td>$tenant_name</td>
                        <td>$tenant_arrive</td>
                        <td>$tenant_depart</td>
                        <td><strong><span class='text-danger'>EXPIRED</span></strong></td>
                    </tr>";

            $mrow = "<div class='tenant-row-mobile'>
                        <p>Tenant Name: $tenant_name</p>
                        <p>Arrive Date: $tenant_arrive</p>
                        <p>Depart Date: $tenant_depart</p>
                        <p>Status: <strong><span class='text-danger'>EXPIRED</span></strong></p>
                        <div class='text-right'>
                            <button type=submit class='btn btn-primary btn-xs btn-view' name='view-tenant' value='$tenant_id'>View Info</button>
                        </div>
                    </div>";
        }

        $tenant_table .= $row;
        $tenant_table_mobile .= $mrow;
    }

    if ($count == 0) {
        $row = "<tr>
                    <td colspan=4 class=text-center>No tenants found.</td>
                </tr>";

        $mrow = "<div class='tenant-row-mobile text-center'>
                    <p>No tenants found.</p>
                </div>";
        $tenant_table .= $row;
        $tenant_table_mobile .= $mrow;
    }

    $tenant_table .= "</table>";
    $tenant_table_mobile .= "</div>";

    $content = $tenant_table . $tenant_table_mobile;

    echo $content;
?>