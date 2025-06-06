<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}
require_once('classes/database.php');
$db = new Database();

$rooms = $db->getAllRooms();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Rooms</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="style2.css">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow glass-card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Rooms</h4>
          <a href="add_room.php" class="btn btn-success">Add Room</a>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Rate</th>
                <th>Capacity</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($rooms as $row): ?>
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
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-end">
          <a href="admin_homepage.php" class="btn btn-secondary">Back to Admin Homepage</a>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>