<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}
require_once('classes/database.php');
$db = new Database();
$conn = $db->getConnection();

$result = $conn->query("SELECT * FROM amenity");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Amenities</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
</head>
<body>
<div class="container mt-5">
  <h3>Amenities</h3>
  <a href="add_amenity.php" class="btn btn-success mb-3">Add Amenity</a>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Cost</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['Amenity_ID'] ?></td>
        <td><?= htmlspecialchars($row['Amenity_Name']) ?></td>
        <td><?= htmlspecialchars($row['Amenity_Desc']) ?></td>
        <td><?= number_format($row['Amenity_Cost'], 2) ?></td>
        <td>
          <a href="update_amenity.php?id=<?= $row['Amenity_ID'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="delete_amenity.php?id=<?= $row['Amenity_ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this amenity?');">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <a href="admin_homepage.php" class="btn btn-secondary">Back to Admin Homepage</a>
</div>
</body>
</html>