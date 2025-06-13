<?php
require_once('classes/database.php');
$db = new Database();

if (isset($_GET['booking_id'])) {
    $booking_id = intval($_GET['booking_id']);
    $amount = $db->getBookingAmount($booking_id);
    if ($amount !== null) {
        echo $amount;
    }
}
?>