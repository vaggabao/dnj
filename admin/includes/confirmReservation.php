<?php
    // include required files
    require_once("../../config/config.php");
    require_once("../../config/dbConnect.php");
    require_once("../../config/links.php");
    require_once("../../config/globals.php");
    require_once("../libraries/PHPMailer.php");
    require_once("../classes/Reservations.php");
    include("../translations/en.php");

    $tenant_id = $_POST['tenant_id'];
    $rent_fee = $_POST['rent_fee'];

    $reservation = new Reservation();
    $reservation->confirmReservation($tenant_id, $rent_fee);

    if ($reservation->errors) {
        $content = "<div id='info-edit-error-div' class='alert alert-danger alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($reservation->errors as $error) {
            $content .= "<p>" . $error . "</p>";
        }
        $content .= "</div>";
        echo $content;
    } elseif ($reservation->messages) {
        $content = "<div id='info-edit-msg-div' class='alert alert-success alert-dismissable' role='alert'>
                    <button type='button' class='close' data-dismiss='alert'>
                        <span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>
                    </button>";
        foreach ($reservation->messages as $message) {
            $content .= "<p>" . $message . "</p>";
        }
        $content .= "</div>";
        echo $content;
    }
?>