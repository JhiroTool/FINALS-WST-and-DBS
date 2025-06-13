<?php
require_once('classes/database.php');
$db = new Database();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db->banCustomer($id);
}
header("Location: admin_homepage.php#customers");
exit();