<?php
session_start();
require_once('classes/database.php');
$db = new Database();
$conn = $db->getConnection();
$sweetAlertConfig = "";

if (isset($_POST['register'])) {
    $fname = trim($_POST['Cust_FN']);
    $lname = trim($_POST['Cust_LN']);
    $email = trim($_POST['Cust_Email']);
    $phone = trim($_POST['Cust_Phone']);
    $password = $_POST['Cust_Password'];
    $confirm_password = $_POST['Cust_ConfirmPassword'];

    // Password match check
    if ($password !== $confirm_password) {
        $sweetAlertConfig = "<script>
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: 'Passwords do not match.'
            });
        </script>";
    } else {
        $result = $db->registerCustomer($fname, $lname, $email, $phone, $password);
        if ($result['success']) {
            $sweetAlertConfig = "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful',
                    text: '{$result['message']}',
                    confirmButtonText: 'Login'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>";
        } else {
            $sweetAlertConfig = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    text: '{$result['message']}'
                });
            </script>";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="./package/dist/sweetalert2.css">
  <title>Customer Registration</title>
</head>
<body>
  <div class="container custom-container rounded-3 shadow p-4 bg-light mt-5">
    <h3 class="text-center mb-4">Register as Customer</h3>
    <form method="post" action="" novalidate>
      <div class="form-group mb-3">
        <label for="Cust_FN">First Name:</label>
        <input type="text" class="form-control" name="Cust_FN" required>
      </div>
      <div class="form-group mb-3">
        <label for="Cust_LN">Last Name:</label>
        <input type="text" class="form-control" name="Cust_LN" required>
      </div>
      <div class="form-group mb-3">
        <label for="Cust_Email">Email:</label>
        <input type="email" class="form-control" name="Cust_Email" required>
      </div>
      <div class="form-group mb-3">
        <label for="Cust_Phone">Phone:</label>
        <input type="text" class="form-control" name="Cust_Phone" required>
      </div>
      <div class="form-group mb-3">
        <label for="Cust_Password">Password:</label>
        <input type="password" class="form-control" name="Cust_Password" required>
      </div>
      <div class="form-group mb-3">
        <label for="Cust_ConfirmPassword">Confirm Password:</label>
        <input type="password" class="form-control" name="Cust_ConfirmPassword" required>
      </div>
      <button type="submit" name="register" class="btn btn-success w-100 py-2">Register</button>
      <div class="text-center mt-4">
        <a href="index.php" class="text-decoration-none">Already have an account? Login here</a>
      </div>
    </form>
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
    <script src="./package/dist/sweetalert2.js"></script>
    <?php echo $sweetAlertConfig; ?>
  </div>
</body>
</html>