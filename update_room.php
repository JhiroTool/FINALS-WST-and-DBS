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
    header("Location: manage_rooms.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM room WHERE Room_ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = trim($_POST['Room_Type']);
    $rate = floatval($_POST['Room_Rate']);
    $cap = intval($_POST['Room_Cap']);
    $stmt = $conn->prepare("UPDATE room SET Room_Type=?, Room_Rate=?, Room_Cap=? WHERE Room_ID=?");
    $stmt->bind_param("sdii", $type, $rate, $cap, $id);
    if ($stmt->execute()) {
        header("Location: manage_rooms.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Error updating room.</div>";
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Update Room</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
  <h3>Update Room</h3>
  <?= $message ?>
  <form method="post">
    <div class="mb-3">
      <label>Type:</label>
      <input type="text" name="Room_Type" class="form-control" value="<?= htmlspecialchars($room['Room_Type']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Rate:</label>
      <input type="number" step="0.01" name="Room_Rate" class="form-control" value="<?= htmlspecialchars($room['Room_Rate']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Capacity:</label>
      <input type="number" name="Room_Cap" class="form-control" value="<?= htmlspecialchars($room['Room_Cap']) ?>" required>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
    <a href="manage_rooms.php" class="btn btn-secondary">Back</a>
  </form>
</div>
</body>
</html>