<?php
require_once('classes/database.php');
$db = new Database();

$id = intval($_GET['id']);
$service = $db->getServiceById($id);

if (!$service) {
    die("Service not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $cost = floatval($_POST['cost']);
    if ($db->updateService($id, $name, $desc, $cost)) {
        header("Location: admin_homepage.php#services");
        exit();
    } else {
        $error = "Failed to update service.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h2 class="mb-0">Edit Service</h2>
                </div>
                <div class="card-body">
                    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Service Name</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($service['Service_Name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="desc" class="form-control" required><?= htmlspecialchars($service['Service_Desc']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cost</label>
                            <input type="number" name="cost" class="form-control" step="0.01" value="<?= htmlspecialchars($service['Service_Cost']) ?>" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Update Service</button>
                            <a href="admin_homepage.php#services" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>