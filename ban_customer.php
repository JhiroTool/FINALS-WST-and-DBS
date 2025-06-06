<?php
require_once('classes/database.php');
$db = new Database();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $db->conn->prepare("UPDATE customer SET is_banned = 1 WHERE Cust_ID = ?");
    $stmt->execute([$id]);
}
header("Location: admin_homepage.php#customers");
exit();