<?php
require_once('classes/database.php');
$db = new Database();

$services = $db->getAllServices();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'];
    $price = $_POST['price'];
    $from = $_POST['prom_from'];
    $to = $_POST['prom_to'];

    if ($db->addServicePromo($service_id, $price, $from, $to)) {
        $message = "<div class='alert alert-success'>Promo added!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Failed to add promo.</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Service Promo</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/service_promo.css">
</head>
<body>
<div class="promo-glass-card card shadow">
    <div class="card-header text-center">
        <h2><i class="bi bi-tag"></i> Add Service Promo</h2>
    </div>
    <div class="card-body">
        <?= $message ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Service</label>
                <select name="service_id" class="form-control" required>
                    <option value="" disabled selected>Select Service</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?= $service['Service_ID'] ?>">
                            <?= htmlspecialchars($service['Service_Name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Promo Price</label>
                <input type="number" name="price" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Promo Start</label>
                <input type="datetime-local" name="prom_from" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Promo End</label>
                <input type="datetime-local" name="prom_to" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Promo</button>
                <a href="admin_homepage.php#services" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>