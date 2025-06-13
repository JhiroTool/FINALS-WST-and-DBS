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

$cust_id = $_SESSION['user_id'] ?? null;
$emp_id = null;
$cost = 0; // Calculate as needed
$status = 'Pending';

if (!$roomType || !$guests || (($roomType !== 'daytour' && $roomType !== 'nighttour') && (!$checkIn || !$checkOut))) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

$room_id = $data['room_id'];
$booking_id = $db->addBookingWithRoom($cust_id, $emp_id, $checkIn, $checkOut, $cost, $status, $guests, $room_id);

if ($booking_id) {
    echo json_encode(['success' => true, 'message' => 'Booking saved!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Booking failed.']);
}