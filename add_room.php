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
    $type = trim($_POST['Room_Type']);
    $rate = floatval($_POST['Room_Rate']);
    $cap = intval($_POST['Room_Cap']);
    $result = $db->addRoom($type, $rate, $cap);
    if ($result['success']) {
        header("Location: manage_rooms.php");
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
  <title>Add Room</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="style2.css">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow glass-card">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Add Room</h4>
        </div>
        <div class="card-body">
          <?= $message ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">Type:</label>
              <input type="text" name="Room_Type" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Rate:</label>
              <input type="number" step="0.01" name="Room_Rate" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Capacity:</label>
              <input type="number" name="Room_Cap" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Add</button>
            <a href="manage_rooms.php" class="btn btn-secondary ms-2">Back</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>