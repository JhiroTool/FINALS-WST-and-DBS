<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}
require_once('classes/database.php');
$db = new Database();

$id = $_GET['id'] ?? null;
if ($id) {
    $db->deleteRoom($id);
}
header("Location: manage_rooms.php");
exit();
?>