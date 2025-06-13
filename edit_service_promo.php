<?php
require_once('classes/database.php');
$db = new Database();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

$promo = $db->getServicePromoById($id);

if (!$promo) {
    die("Promo not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $price = $_POST['price'];
    $from = $_POST['prom_from'];
    $to = $_POST['prom_to'];

    if ($db->updateServicePromo($id, $price, $from, $to)) {
        header("Location: admin_homepage.php#service-promos");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Failed to update promo.</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Service Promo</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white text-center">
                    <h2 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Service Promo</h2>
                </div>
                <div class="card-body">
                    <?= $message ?>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Promo Price</label>
                            <input type="number" name="price" class="form-control" step="0.01" min="0" value="<?= htmlspecialchars($promo['Price']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Promo Start</label>
                            <input type="datetime-local" name="prom_from" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($promo['PromValidF'])) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Promo End</label>
                            <input type="datetime-local" name="prom_to" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($promo['PromValidT'])) ?>" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-warning"><i class="bi bi-save"></i> Save Changes</button>
                            <a href="admin_homepage.php#service-promos" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>