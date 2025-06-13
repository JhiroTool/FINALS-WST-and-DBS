<?php
require_once('../classes/database.php');
$db = new Database();

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

$response = ['exists' => false, 'field' => '', 'message' => ''];

if (!empty($email)) {
    $exists = $db->customerExists($email, null);
    if ($exists) {
        $response = ['exists' => true, 'field' => 'email', 'message' => 'Email is already in use.'];
    }
}

if (!empty($phone)) {
    $exists = $db->customerExists(null, $phone);
    if ($exists) {
        $response = ['exists' => true, 'field' => 'phone', 'message' => 'Phone number is already in use.'];
    }
}

header('Content-Type: application/json');
echo json_encode($response);