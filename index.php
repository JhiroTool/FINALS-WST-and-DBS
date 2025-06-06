<?php
session_start();
require_once('classes/database.php');
$db = new Database();
$sweetAlertConfig = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $db->loginUser($email, $password);
    if ($result['success']) {
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_type'] = $result['user_type'];
        $_SESSION['user_FN'] = $result['user_FN'];
        $redirectUrl = $result['redirect'];
        $sweetAlertConfig = "<script>
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: 'Welcome, " . addslashes(htmlspecialchars($result['user_FN'])) . "!',
                confirmButtonText: 'Continue'
            }).then(() => {
                window.location.href = '$redirectUrl';
            });
        </script>";
    } else {
        $sweetAlertConfig = "<script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '{$result['message']}'
            });
        </script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="./package/dist/sweetalert2.css">
  <link rel="stylesheet" href="assets/css/login.css"> <!-- Added custom CSS -->
  <title>Guest Accommodation System</title>
</head>
<body>
  <div class="container custom-container rounded-3 shadow p-4 bg-light mt-5">
    <h3 class="text-center mb-4">Login</h3>
    <form method="post" action="" novalidate>
      <div class="form-group mb-3">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" placeholder="Enter email" required>
        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please enter a valid email.</div>
      </div>
      <div class="form-group mb-3">
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" placeholder="Enter password" required>
        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please enter your password.</div>
      </div>
      <button type="submit" name="login" class="btn btn-primary w-100 py-2">Login</button>
      <div class="text-center mt-4">
        <a href="admin_homepage.php" class="text-decoration-none">Access Admin Homepage (For now)</a><br>
        <a href="registration.php" class="text-decoration-none">Don't have an account? Register here</a>
      </div>
      <div class="text-center mt-2">
        <a href="admin_registration.php" class="text-decoration-none">Register as Admin</a>
      </div>
    </form>
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
    <script src="./package/dist/sweetalert2.js"></script>
    <script src="script.js"></script>
    <?php echo $sweetAlertConfig; ?>
  </div>
</body>
</html>
