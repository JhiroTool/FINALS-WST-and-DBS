<?php
require_once('classes/database.php');
$db = new Database();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $admin_id = $_SESSION['user_id']; // assuming admin is logged in

    $stmt = $db->conn->prepare("INSERT INTO employee (Emp_FN, Emp_LN, Emp_Email, Emp_Phone, Admin_ID) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $fname, $lname, $email, $phone, $admin_id);
    $stmt->execute();
    header("Location: admin_homepage.php#employees");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style2.css">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow glass-card">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Add Employee</h4>
        </div>
        <div class="card-body">
          <form method="post">
            <div class="mb-3">
              <label class="form-label">First Name</label>
              <input type="text" name="fname" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Last Name</label>
              <input type="text" name="lname" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Add</button>
            <a href="admin_homepage.php#employees" class="btn btn-secondary ms-2">Back</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>