<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}
require_once('classes/database.php');
$db = new Database();
$conn = $db->getConnection();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['Amenity_Name']);
    $desc = trim($_POST['Amenity_Desc']);
    $cost = floatval($_POST['Amenity_Cost']);
    $result = $db->addAmenity($name, $desc, $cost);
    if ($result['success']) {
        header("Location: manage_amenities.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>{$result['message']}</div>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Amenity</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
  <h3>Add Amenity</h3>
  <?= $message ?>
  <form method="post">
    <div class="mb-3">
      <label>Name:</label>
      <input type="text" name="Amenity_Name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Description:</label>
      <input type="text" name="Amenity_Desc" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Cost:</label>
      <input type="number" step="0.01" name="Amenity_Cost" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Add</button>
    <a href="manage_amenities.php" class="btn btn-secondary">Back</a>
  </form>
</div>
</body>
</html>