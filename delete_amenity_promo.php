<?php
require_once('classes/database.php');
$db = new Database();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$db->deleteAmenityPromo($id);

header("Location: admin_homepage.php#amenity-promos");
exit();
?>