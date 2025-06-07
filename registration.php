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

    // Check for empty fields
    if (empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        $sweetAlertConfig = "<script>
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: 'All fields are required.'
            });
        </script>";
    }
    // Password match check
    else if ($password !== $confirm_password) {
        $sweetAlertConfig = "<script>
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: 'Passwords do not match.'
            });
        </script>";
    } else {
        // Check if email or phone already exists
        $stmt = $conn->prepare("SELECT * FROM customer WHERE Cust_Email = ? OR Cust_Phone = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $sweetAlertConfig = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    text: 'Email or phone number is already in use.'
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
        $stmt->close();
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
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="assets/css/registration.css">
  <title>Customer Registration</title>
  <style>
    .custom-container {
      padding: 2rem 1.2rem 1.2rem 1.2rem;
      max-width: 350px;
      background: rgba(255,255,255,0.98);
      border-radius: 1.5rem;
      box-shadow: 0 8px 32px rgba(60, 60, 120, 0.18);
      margin-top: 3.5rem;
    }
    .register-title {
      color: #6366f1;
      font-weight: 800;
      letter-spacing: 1px;
      margin-bottom: 1.2rem;
      text-shadow: 0 2px 8px #a5b4fc33;
    }
    .form-group label {
      font-size: 0.98rem;
      color: #6366f1;
      font-weight: 600;
      margin-bottom: 0.2rem;
    }
    .form-control {
      font-size: 1rem;
      border-radius: 0.8rem;
      border: 1.5px solid #e0e7ff;
      background: #f3f4f6;
      transition: border-color 0.2s, box-shadow 0.2s;
      margin-bottom: 0.7rem;
    }
    .form-control:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 0.13rem #6366f133;
      background: #fff;
    }
    .btn-primary {
      margin-top: 0.2rem;
      font-size: 1.08rem;
      padding: 0.7rem 0;
      border-radius: 2rem;
      font-weight: 700;
      letter-spacing: 1px;
      background: linear-gradient(90deg, #6366f1 60%, #818cf8 100%);
      border: none;
      box-shadow: 0 4px 16px rgba(99,102,241,0.13);
      transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
    }
    .btn-primary:hover, .btn-primary:focus {
      background: linear-gradient(90deg, #4338ca 60%, #6366f1 100%);
      box-shadow: 0 8px 24px rgba(99,102,241,0.18);
      transform: translateY(-2px) scale(1.03);
    }
    .text-center a {
      color: #6366f1;
      font-weight: 500;
      transition: color 0.2s;
      font-size: 0.97rem;
    }
    .text-center a:hover {
      color: #4338ca;
      text-decoration: underline;
    }
    @media (max-width: 400px) {
      .custom-container { padding: 1rem 0.3rem 0.7rem 0.3rem; }
    }
  </style>
</head>
<body>
  <div class="container custom-container shadow">
    <h3 class="text-center register-title">Create Account</h3>
    <form method="post" action="" novalidate autocomplete="off">
      <div class="form-group">
        <label for="Cust_FN">First Name</label>
        <input type="text" class="form-control" name="Cust_FN" placeholder="e.g. Juan" required>
      </div>
      <div class="form-group">
        <label for="Cust_LN">Last Name</label>
        <input type="text" class="form-control" name="Cust_LN" placeholder="e.g. Dela Cruz" required>
      </div>
      <div class="form-group">
        <label for="Cust_Email">Email</label>
        <input type="email" class="form-control" name="Cust_Email" placeholder="e.g. juan@email.com" required>
      </div>
      <div class="form-group">
        <label for="Cust_Phone">Phone</label>
        <input type="text" class="form-control" name="Cust_Phone" placeholder="09XXXXXXXXX" required>
      </div>
      <div class="form-group">
        <label for="Cust_Password">Password</label>
        <input type="password" class="form-control" name="Cust_Password" placeholder="Enter password" required>
      </div>
      <div class="form-group mb-2">
        <label for="Cust_ConfirmPassword">Confirm Password</label>
        <input type="password" class="form-control" name="Cust_ConfirmPassword" placeholder="Re-enter password" required>
      </div>
      <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
      <div class="text-center mt-3">
        <a href="index.php" class="text-decoration-none">Already have an account?</a>
      </div>
    </form>
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
    <script src="./package/dist/sweetalert2.js"></script>
    <?php echo $sweetAlertConfig; ?>
  </div>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.querySelector('input[name="Cust_Email"]');
    const phoneInput = document.querySelector('input[name="Cust_Phone"]');

    function checkField(type, value) {
        const data = {};
        data[type] = value;
        fetch('check_customer.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams(data)
        })
        .then(response => response.json())
        .then(res => {
            let msgId = type + '-msg';
            let msgElem = document.getElementById(msgId);
            if (!msgElem) {
                msgElem = document.createElement('div');
                msgElem.id = msgId;
                msgElem.style.color = 'red';
                msgElem.style.fontSize = '0.95em';
                if (type === 'email') {
                    emailInput.parentNode.appendChild(msgElem);
                } else {
                    phoneInput.parentNode.appendChild(msgElem);
                }
            }
            if (res.exists && res.field === type) {
                msgElem.textContent = res.message;
            } else {
                msgElem.textContent = '';
            }
        });
    }

    emailInput.addEventListener('blur', function() {
        if (this.value.trim() !== '') checkField('email', this.value.trim());
    });

    phoneInput.addEventListener('blur', function() {
        if (this.value.trim() !== '') checkField('phone', this.value.trim());
    });
});
</script>
</body>
</html>