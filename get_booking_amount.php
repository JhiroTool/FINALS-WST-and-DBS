<?php
require_once('classes/database.php');
$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['booking_id'])) {
    $booking_id = intval($_GET['booking_id']);
    // Fetch Booking_Cost instead of Total_Amount
    $stmt = $conn->prepare("SELECT Booking_Cost FROM booking WHERE Booking_ID = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->bind_result($amount);
    if ($stmt->fetch()) {
        echo $amount;
    }
    $stmt->close();
}
?>