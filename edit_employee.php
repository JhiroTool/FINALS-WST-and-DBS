<?php
require_once('classes/database.php');
$db = new Database();

if (!isset($_GET['id'])) {
    header("Location: admin_homepage.php#employees");
    exit();
}
$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    if ($db->updateEmployee($id, $fname, $lname, $email, $phone)) {
        header("Location: admin_homepage.php#employees");
        exit();
    }
}

$employee = $db->getEmployeeById($id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style2.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow glass-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Employee</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($employee): ?>
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="fname" class="form-control" value="<?= htmlspecialchars($employee['Emp_FN']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="lname" class="form-control" value="<?= htmlspecialchars($employee['Emp_LN']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($employee['Emp_Email']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($employee['Emp_Phone']) ?>" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="admin_homepage.php#employees" class="btn btn-secondary ms-2">Back</a>
                        </form>
                        <?php else: ?>
                            <p>Employee not found.</p>
                            <a href="admin_homepage.php#employees" class="btn btn-secondary">Back</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>