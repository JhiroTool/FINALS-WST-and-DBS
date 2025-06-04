<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}
require_once('classes/database.php');
$db = new Database();
$message = "";

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: manage_amenities.php");
    exit();
}

$amenity = $db->getAmenityById($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['Amenity_Name']);
    $desc = trim($_POST['Amenity_Desc']);
    $cost = floatval($_POST['Amenity_Cost']);
    if ($db->updateAmenity($id, $name, $desc, $cost)) {
        header("Location: manage_amenities.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Error updating amenity.</div>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Update Amenity</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
  <h3>Update Amenity</h3>
  <?= $message ?>
  <form method="post">
    <div class="mb-3">
      <label>Name:</label>
      <input type="text" name="Amenity_Name" class="form-control" value="<?= htmlspecialchars($amenity['Amenity_Name']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Description:</label>
      <input type="text" name="Amenity_Desc" class="form-control" value="<?= htmlspecialchars($amenity['Amenity_Desc']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Cost:</label>
      <input type="number" step="0.01" name="Amenity_Cost" class="form-control" value="<?= htmlspecialchars($amenity['Amenity_Cost']) ?>" required>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
    <a href="manage_amenities.php" class="btn btn-secondary">Back</a>
  </form>
</div>
</body>
</html>