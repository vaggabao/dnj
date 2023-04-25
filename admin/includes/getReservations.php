<?php
    require_once("../../config/config.php");
    require_once("../classes/Reservations.php");
    include("../translations/en.php");

    $search = $_POST['search'];
    $reservation = new Reservation();
    $data = $reservation->getReservations($search);

    $count = count($data);

    $reservation_table = "<table id='reservation-table' class='table table-hover'>";
    $reservation_table_headers = "<tr><th>Tenant</th><th>Dates Reserved</th><th>Term</th><th></th></tr>";
    $reservation_table .= $reservation_table_headers;

    $reservation_table_mobile = "<div id='reservation-table-mobile'><h3>Reservations</h3><br>";

    for ($i = 0; $i < $count; $i++) {
        $reservation_id = $data[$i]['id'];
		$reservation_name = ucwords(strtolower($data[$i]['fname'])) . " " . ucwords(strtolower($data[$i]['lname']));
		$reservation_dates = date("F d, Y", strtotime($data[$i]['start_date'])) . " to " . date("F d, Y", strtotime($data[$i]['end_date']));
        $reservation_fee = $data[$i]['rent_fee'];
        $reservation_term = strtoupper($data[$i]['rent_term']);
        $reservation_reserved = $data[$i]['is_reserved'];
        $reservation_registered = $data[$i]['is_registered'];

        $row = "<tr>
                    <td>$reservation_name</td>
                    <td>$reservation_dates</td>
                    <td>$reservation_term</td>
                    <td>
                        <button type=submit class='btn btn-danger btn-xs btn-confirm' name='confirm_reservation' data-fee='$reservation_fee' data-term='$reservation_term' value='$reservation_id'>Confirm</button>
                    </td>
                </tr>";

        $mrow = "<div class='reservation-row-mobile'>
                    <p>Tenant Name: $reservation_name</p>
                    <p>Dates Reserved: $reservation_dates</p>
                    <p>Rent Term: $reservation_term</p>
                    <div class='text-right'>
                        <button type=submit class='btn btn-danger btn-xs btn-confirm' name='confirm_reservation' data-term='$reservation_term' value='$reservation_id'>Confirm</button>
                    </div>
                </div>";
        
        $reservation_table .= $row;
        $reservation_table_mobile .= $mrow;
    }

    if ($count == 0) {
        $row = "<tr>
                    <td colspan=4 class=text-center>No reservations found</td>
                </tr>";

        $mrow = "<div class='reservation-row-mobile text-center'>
                    <p>No reservations found</p>
                </div>";
        $reservation_table .= $row;
        $reservation_table_mobile .= $mrow;
    }

    $reservation_table .= "</table>";
    $reservation_table_mobile .= "</div>";

    $content = $reservation_table . $reservation_table_mobile;

    echo $content;
?>