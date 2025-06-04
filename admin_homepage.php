<?php
session_start();
require_once('classes/database.php');
$db = new Database();

// Redirect if not logged in as admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch data
$rooms = $db->getAllRooms();
$amenities = $db->getAllAmenities();
$customers = $db->getAllCustomers();
$bookings = $db->getAllBookings();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <title>Admin Homepage</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="admin_homepage.php">Admin Dashboard</a>
      <div class="ms-auto">
        <a href="logout.php" class="btn btn-danger ms-2">Logout</a>
      </div>
    </div>
  </nav>
  <div class="container my-5">
    <div class="alert alert-success">
      <h4>Welcome, Administrator!</h4>
      <p>You are now logged in as an admin.</p>
    </div>

    <!-- ROOMS SECTION -->
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
          <span>Rooms</span>
          <a href="add_room.php" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> Add Room</a>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered text-center">
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
            <?php foreach ($rooms as $room): ?>
            <tr>
              <td><?= $room['Room_ID'] ?></td>
              <td><?= htmlspecialchars($room['Room_Type']) ?></td>
              <td><?= number_format($room['Room_Rate'], 2) ?></td>
              <td><?= $room['Room_Cap'] ?></td>
              <td>
                <a href="update_room.php?id=<?= $room['Room_ID'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                <a href="delete_room.php?id=<?= $room['Room_ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this room?');"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- AMENITIES SECTION -->
    <div class="card mb-4">
      <div class="card-header bg-success text-white">
        <div class="d-flex justify-content-between align-items-center">
          <span>Amenities</span>
          <a href="add_amenity.php" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> Add Amenity</a>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered text-center">
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
            <?php foreach ($amenities as $amenity): ?>
            <tr>
              <td><?= $amenity['Amenity_ID'] ?></td>
              <td><?= htmlspecialchars($amenity['Amenity_Name']) ?></td>
              <td><?= htmlspecialchars($amenity['Amenity_Desc']) ?></td>
              <td><?= number_format($amenity['Amenity_Cost'], 2) ?></td>
              <td>
                <a href="update_amenity.php?id=<?= $amenity['Amenity_ID'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                <a href="delete_amenity.php?id=<?= $amenity['Amenity_ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this amenity?');"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- CUSTOMERS SECTION -->
    <div class="card mb-4">
      <div class="card-header bg-warning text-dark">
        <span>Customers</span>
      </div>
      <div class="card-body">
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Password</th> <!-- Add this line -->
            </tr>
          </thead>
          <tbody>
            <?php foreach ($customers as $customer): ?>
            <tr>
              <td><?= $customer['Cust_ID'] ?></td>
              <td><?= htmlspecialchars($customer['Cust_FN']) ?></td>
              <td><?= htmlspecialchars($customer['Cust_LN']) ?></td>
              <td><?= htmlspecialchars($customer['Cust_Email']) ?></td>
              <td><?= htmlspecialchars($customer['Cust_Phone']) ?></td>
              <td style="font-size:0.85em;word-break:break-all;"><?= htmlspecialchars($customer['Cust_Password']) ?></td> <!-- Add this line -->
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- BOOKINGS SECTION -->
    <div class="card mb-4">
      <div class="card-header bg-danger text-white">
        <span>Bookings</span>
      </div>
      <div class="card-body">
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer ID</th>
              <th>Employee ID</th>
              <th>Check-In</th>
              <th>Check-Out</th>
              <th>Cost</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($bookings as $booking): ?>
            <tr>
              <td><?= $booking['Booking_ID'] ?></td>
              <td><?= $booking['Cust_ID'] ?></td>
              <td><?= $booking['Emp_ID'] ?></td>
              <td><?= $booking['Booking_IN'] ?></td>
              <td><?= $booking['Booking_Out'] ?></td>
              <td><?= number_format($booking['Booking_Cost'], 2) ?></td>
              <td><?= htmlspecialchars($booking['Booking_Status']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
  <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>