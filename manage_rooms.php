<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}
require_once('classes/database.php');
$db = new Database();
$conn = $db->getConnection();

$result = $conn->query("SELECT * FROM room");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Rooms</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
  <h3>Rooms</h3>
  <a href="add_room.php" class="btn btn-success mb-3">Add Room</a>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Rate</th>
        <th>Capacity</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['Room_ID'] ?></td>
        <td><?= htmlspecialchars($row['Room_Type']) ?></td>
        <td><?= number_format($row['Room_Rate'], 2) ?></td>
        <td><?= $row['Room_Cap'] ?></td>
        <td>
          <a href="update_room.php?id=<?= $row['Room_ID'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="delete_room.php?id=<?= $row['Room_ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this room?');">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <a href="admin_homepage.php" class="btn btn-secondary">Back to Admin Homepage</a>
</div>
</body>
</html>