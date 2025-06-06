<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}
require_once('classes/database.php');
$db = new Database();

$amenities = $db->getAllAmenities();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Amenities</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="style2.css">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow glass-card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Amenities</h4>
          <a href="add_amenity.php" class="btn btn-success">Add Amenity</a>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Cost</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($amenities as $row): ?>
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