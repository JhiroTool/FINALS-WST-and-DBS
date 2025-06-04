<?php
session_start();

// Redirect if not logged in as admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <title>Admin Homepage</title>
</head>
<body>
  <div class="container mt-5">
    <div class="alert alert-success">
      <h4>Welcome, Administrator!</h4>
      <p>You are now logged in as an admin.</p>
    </div>
    <div class="mb-3">
      <a href="logout.php" class="btn btn-danger">Logout</a>
      <a href="index.php" class="btn btn-secondary">Back to Login</a>
    </div>
    <!-- Add your admin dashboard features here -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Admin Dashboard</h5>
        <p class="card-text">Here you can manage amenities and more.</p>
        <div class="d-flex flex-wrap gap-2">
          <a href="add_amenity.php" class="btn btn-success">Add Amenity</a>
          <a href="update_amenity.php" class="btn btn-warning">Update Amenity</a>
          <a href="delete_amenity.php" class="btn btn-danger">Delete Amenity</a>
        </div>
        <hr>
        <div class="d-flex flex-wrap gap-2">
          <a href="manage_customers.php" class="btn btn-primary">Manage Customers</a>
          <a href="manage_rooms.php" class="btn btn-primary">Manage Rooms</a>
          <a href="manage_bookings.php" class="btn btn-primary">Manage Bookings</a>
          <a href="manage_amenities.php" class="btn btn-info">Manage Amenities</a>
        </div>
      </div>
    </div>
  </div>
  <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>