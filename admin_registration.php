<?php
session_start();
require_once('classes/database.php');
$db = new Database();
$conn = $db->getConnection();
$sweetAlertConfig = "";

if (isset($_POST['register'])) {
    $email = trim($_POST['Admin_Email']);
    $password = $_POST['Admin_Password'];
    $confirm_password = $_POST['Admin_ConfirmPassword'];

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
        $result = $db->registerAdmin($email, $password);
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
  <title>Admin Registration</title>
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow glass-card">
          <div class="card-header bg-primary text-white">
            <h3 class="mb-0 text-center">Register as Admin</h3>
          </div>
          <div class="card-body">
            <form method="post" action="" novalidate>
              <div class="mb-3">
                <label for="Admin_Email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="Admin_Email" required>
              </div>
              <div class="mb-3">
                <label for="Admin_Password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="Admin_Password" required>
              </div>
              <div class="mb-3">
                <label for="Admin_ConfirmPassword" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" name="Admin_ConfirmPassword" required>
              </div>
              <button type="submit" name="register" class="btn btn-success w-100 py-2">Register</button>
              <div class="text-center mt-4">
                <a href="index.php" class="text-decoration-none">Back to Login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
    <script src="./package/dist/sweetalert2.js"></script>
    <?php echo $sweetAlertConfig; ?>
  </div>
</body>
</html>