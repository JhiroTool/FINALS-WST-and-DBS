<?php
require_once('classes/database.php');
$db = new Database();

if (!isset($_GET['id'])) {
    header("Location: admin_homepage.php#customers");
    exit();
}
$id = intval($_GET['id']);
$customer = $db->getCustomerById($id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Details</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style2.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow glass-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Customer Details</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($customer): ?>
                            <p><strong>Name:</strong> <?= htmlspecialchars($customer['Cust_FN'] . ' ' . $customer['Cust_LN']) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($customer['Cust_Email']) ?></p>
                            <p><strong>Phone:</strong> <?= htmlspecialchars($customer['Cust_Phone']) ?></p>
                            <p><strong>Status:</strong> <?= $customer['is_banned'] ? 'Banned' : 'Active' ?></p>
                            <!-- Add more details/history as needed -->
                        <?php else: ?>
                            <p>Customer not found.</p>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-end">
                        <a href="admin_homepage.php#customers" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>