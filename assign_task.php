<?php
require_once('classes/database.php');
$db = new Database();

if (!isset($_GET['id'])) {
    header("Location: admin_homepage.php#employees");
    exit();
}
$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST['task'];
    // You should have a tasks table or a field in employees for this
    $stmt = $db->conn->prepare("UPDATE employee SET Emp_Role=? WHERE Emp_ID=?");
    $stmt->execute([$task, $id]);
    header("Location: admin_homepage.php#employees");
    exit();
}

$stmt = $db->conn->prepare("SELECT * FROM employee WHERE Emp_ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assign Task</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style2.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow glass-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Assign Task to <?= htmlspecialchars($employee['Emp_FN'] . ' ' . $employee['Emp_LN']) ?></h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="task" class="form-label">Task/Shift</label>
                                <input type="text" class="form-control" id="task" name="task" placeholder="Enter task or shift" required>
                            </div>
                            <button type="submit" class="btn btn-success">Assign</button>
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