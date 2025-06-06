<?php
require_once('classes/database.php');
$db = new Database();

$id = intval($_GET['id']);
$db->deleteService($id);
header("Location: admin_homepage.php#services");
exit();
?>