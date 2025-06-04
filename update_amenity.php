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

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: manage_amenities.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM amenity WHERE Amenity_ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$amenity = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['Amenity_Name']);
    $desc = trim($_POST['Amenity_Desc']);
    $cost = floatval($_POST['Amenity_Cost']);
    $stmt = $conn->prepare("UPDATE amenity SET Amenity_Name=?, Amenity_Desc=?, Amenity_Cost=? WHERE Amenity_ID=?");
    $stmt->bind_param("ssdi", $name, $desc, $cost, $id);
    if ($stmt->execute()) {
        header("Location: manage_amenities.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Error updating amenity.</div>";
    }
    $stmt->close();
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