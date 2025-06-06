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
    header("Location: manage_rooms.php");
    exit();
}

$room = $db->getRoomById($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = trim($_POST['Room_Type']);
    $rate = floatval($_POST['Room_Rate']);
    $cap = intval($_POST['Room_Cap']);
    if ($db->updateRoom($id, $type, $rate, $cap)) {
        header("Location: manage_rooms.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Error updating room.</div>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Update Room</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="style2.css">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow glass-card">
        <div class="card-header bg-warning text-dark">
          <h4 class="mb-0">Update Room</h4>
        </div>
        <div class="card-body">
          <?= $message ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">Type:</label>
              <input type="text" name="Room_Type" class="form-control" value="<?= htmlspecialchars($room['Room_Type']) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Rate:</label>
              <input type="number" step="0.01" name="Room_Rate" class="form-control" value="<?= htmlspecialchars($room['Room_Rate']) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Capacity:</label>
              <input type="number" name="Room_Cap" class="form-control" value="<?= htmlspecialchars($room['Room_Cap']) ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Update</button>
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