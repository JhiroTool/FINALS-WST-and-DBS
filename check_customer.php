<?php
require_once('classes/database.php');
$db = new Database();
$conn = $db->getConnection();

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

$response = ['exists' => false, 'field' => '', 'message' => ''];

if (!empty($email)) {
    $stmt = $conn->prepare("SELECT Cust_Email FROM customer WHERE Cust_Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $response = ['exists' => true, 'field' => 'email', 'message' => 'Email is already in use.'];
    }
    $stmt->close();
}

if (!empty($phone)) {
    $stmt = $conn->prepare("SELECT Cust_Phone FROM customer WHERE Cust_Phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $response = ['exists' => true, 'field' => 'phone', 'message' => 'Phone number is already in use.'];
    }
    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($response);