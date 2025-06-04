<?php
session_start();
require_once('classes/database.php');
$db = new Database();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$roomType = $data['roomType'] ?? '';
$guests = $data['guests'] ?? '';
$checkIn = $data['checkIn'] ?? null;
$checkOut = $data['checkOut'] ?? null;

// You may want to get customer ID from session if logged in, or set to NULL for guest
$cust_id = $_SESSION['user_id'] ?? null;
$emp_id = null;
$cost = 0; // You can calculate cost based on your logic
$status = 'Pending';

// Validate required fields
if (!$roomType || !$guests || (($roomType !== 'daytour' && $roomType !== 'nighttour') && (!$checkIn || !$checkOut))) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

// Insert booking
$stmt = $db->getConnection()->prepare(
    "INSERT INTO booking (Cust_ID, Emp_ID, Booking_IN, Booking_Out, Booking_Cost, Booking_Status, Guests)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("iissdsi", $cust_id, $emp_id, $checkIn, $checkOut, $cost, $status, $guests);
$stmt->execute();
$booking_id = $stmt->insert_id;
$stmt->close();

// Insert bookingroom
$room_id = $data['room_id']; // This should come from your booking form
$stmt2 = $db->getConnection()->prepare(
    "INSERT INTO bookingroom (Booking_ID, Room_ID) VALUES (?, ?)"
);
$stmt2->bind_param("ii", $booking_id, $room_id);
$stmt2->execute();
$stmt2->close();

echo json_encode(['success' => true, 'message' => 'Booking saved!']);