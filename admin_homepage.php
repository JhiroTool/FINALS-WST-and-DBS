<?php
session_start();
require_once('classes/database.php');
$db = new Database();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$rooms = $db->getAllRooms();
$amenities = $db->getAllAmenities();
$customers = $db->getAllCustomers();
$bookings = $db->getAllBookings();
$employees = $db->getAllEmployees(); // <-- Add this line
$feedbacks = $db->getRecentFeedback(10);
$services = $db->getAllServices();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style2.css">
  <title>Admin Homepage</title>
</head>
<body>
  <div class="admin-layout">
    <aside class="sidebar">
      <div class="sidebar-brand">
        <i class="bi bi-building"></i> Admin
      </div>
      <ul class="sidebar-nav">
        <li><a href="#rooms"><i class="bi bi-door-closed"></i> Rooms</a></li>
        <li><a href="#amenities"><i class="bi bi-gem"></i> Amenities</a></li>
        <li><a href="#services"><i class="bi bi-briefcase"></i> Services</a></li> <!-- Add this line -->
        <li><a href="#customers"><i class="bi bi-people"></i> Customers</a></li>
        <li><a href="#bookings"><i class="bi bi-calendar-check"></i> Bookings</a></li>
        <li><a href="#employee"><i class="bi bi-person-badge"></i> Employees</a></li>
        <li><a href="#admin-feedback"><i class="bi bi-chat-left-dots"></i> Recent Feedback</a></li>
        <li class="mt-auto"><a href="logout.php" class="btn btn-logout w-100"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <header class="main-header">
        <h1>Welcome, Administrator</h1>
        <p class="text-muted mb-0">You are now logged in as an admin.</p>
      </header>

      <!-- ROOMS SECTION -->
      <section id="rooms" class="dashboard-section">
        <div class="dashboard-card glass-card">
          <div class="dashboard-header">
            <span class="dashboard-title"><i class="bi bi-door-closed"></i> Rooms</span>
            <a href="add_room.php" class="btn btn-action btn-sm"><i class="bi bi-plus-circle"></i> Add Room</a>
          </div>
          <div class="card-body">
            <table class="table dashboard-table align-middle">
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
      </section>

      <!-- AMENITIES SECTION -->
      <section id="amenities" class="dashboard-section">
        <div class="dashboard-card glass-card">
          <div class="dashboard-header">
            <span class="dashboard-title"><i class="bi bi-gem"></i> Amenities</span>
            <a href="add_amenity.php" class="btn btn-action btn-sm"><i class="bi bi-plus-circle"></i> Add Amenity</a>
          </div>
          <div class="card-body">
            <table class="table dashboard-table align-middle">
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
      </section>

      <!-- CUSTOMERS SECTION -->
      <section id="customers" class="dashboard-section">
        <div class="dashboard-card glass-card">
          <div class="dashboard-header">
            <span class="dashboard-title"><i class="bi bi-people"></i> Customers</span>
          </div>
          <div class="card-body">
            <table class="table dashboard-table align-middle">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Password</th>
                  <th>Actions</th> <!-- Added Actions column -->
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
                  <td style="font-size:0.85em;word-break:break-all;"><?= htmlspecialchars($customer['Cust_Password']) ?></td>
                  <td>
                    <!-- Ban/Disable Button -->
                    <?php if (empty($customer['is_banned'])): ?>
                      <a href="ban_customer.php?id=<?= $customer['Cust_ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Ban this customer?');"><i class="bi bi-person-x"></i> Ban</a>
                    <?php else: ?>
                      <span class="badge bg-danger">Banned</span>
                    <?php endif; ?>
                    <!-- View Details Button -->
                    <a href="customer_details.php?id=<?= $customer['Cust_ID'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> View</a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- BOOKINGS SECTION -->
      <section id="bookings" class="dashboard-section">
        <div class="dashboard-card glass-card">
          <div class="dashboard-header">
            <span class="dashboard-title"><i class="bi bi-calendar-check"></i> Bookings</span>
          </div>
          <div class="card-body">
            <table class="table dashboard-table align-middle">
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
      </section>

      <!-- EMPLOYEES SECTION -->
      <section id="employee" class="dashboard-section">
        <div class="dashboard-card glass-card">
          <div class="dashboard-header">
            <span class="dashboard-title"><i class="bi bi-person-badge"></i> Employees</span>
            <a href="add_employee.php" class="btn btn-action btn-sm"><i class="bi bi-plus-circle"></i> Add Employee</a>
          </div>
          <div class="card-body">
            <table class="table dashboard-table align-middle">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($employees as $employee): ?>
                <tr>
                  <td><?= $employee['Emp_ID'] ?></td>
                  <td><?= htmlspecialchars($employee['Emp_FN']) ?></td>
                  <td><?= htmlspecialchars($employee['Emp_LN']) ?></td>
                  <td><?= htmlspecialchars($employee['Emp_Email']) ?></td>
                  <td><?= htmlspecialchars($employee['Emp_Phone']) ?></td>
                  <td>
                    <a href="edit_employee.php?id=<?= $employee['Emp_ID'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                    <a href="assign_task.php?id=<?= $employee['Emp_ID'] ?>" class="btn btn-success btn-sm"><i class="bi bi-list-task"></i> Assign Task</a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- SERVICES SECTION -->
      <section id="services" class="dashboard-section">
        <div class="dashboard-card glass-card">
          <div class="dashboard-header">
            <span class="dashboard-title"><i class="bi bi-briefcase"></i> Services</span>
            <a href="add_service.php" class="btn btn-action btn-sm"><i class="bi bi-plus-circle"></i> Add Service</a>
          </div>
          <div class="card-body">
            <table class="table dashboard-table align-middle">
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
                <?php if ($services): ?>
                  <?php foreach ($services as $service): ?>
                    <tr>
                      <td><?= $service['Service_ID'] ?></td>
                      <td><?= htmlspecialchars($service['Service_Name']) ?></td>
                      <td><?= htmlspecialchars($service['Service_Desc']) ?></td>
                      <td><?= number_format($service['Service_Cost'], 2) ?></td>
                      <td>
                        <a href="update_service.php?id=<?= $service['Service_ID'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                        <a href="delete_service.php?id=<?= $service['Service_ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this service?');"><i class="bi bi-trash"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="5" class="text-muted">No services found.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- FEEDBACK VIEW SECTION -->
      <section class="minimal-section" id="admin-feedback">
          <h2 class="section-title mb-4"><i class="bi bi-chat-left-dots"></i> Recent Feedback</h2>
          <div class="row g-3">
              <?php if ($feedbacks): ?>
                  <?php foreach($feedbacks as $row): ?>
                      <div class="col-md-6">
                          <div class="card shadow-sm border-0 h-100">
                              <div class="card-body d-flex align-items-start">
                                  <div class="me-3">
                                      <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:48px;height:48px;font-size:1.5rem;">
                                          <?= strtoupper(substr($row['Cust_FN'], 0, 1)) ?>
                                      </div>
                                  </div>
                                  <div>
                                      <div class="fw-semibold"><?= htmlspecialchars($row['Cust_FN']) ?></div>
                                      <div class="mb-1" style="color:#ffc107;">
                                          <?php
                                          $stars = intval($row['Feed_Rating']);
                                          for ($i = 0; $i < $stars; $i++) echo '<i class="bi bi-star-fill"></i>';
                                          for ($i = $stars; $i < 5; $i++) echo '<i class="bi bi-star"></i>';
                                          ?>
                                      </div>
                                      <div class="mb-2 text-muted" style="font-size:0.98em;"><?= htmlspecialchars($row['Feed_Comment']) ?></div>
                                      <div class="text-muted small"><i class="bi bi-clock"></i> <?= date('M d, Y H:i', strtotime($row['Feed_DOF'])) ?></div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php endforeach; ?>
              <?php else: ?>
                  <div class="col-12 text-muted">No feedback yet.</div>
              <?php endif; ?>
          </div>
      </section>
    </main>
  </div>
  <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>