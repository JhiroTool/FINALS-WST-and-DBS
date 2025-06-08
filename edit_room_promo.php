<?php
require_once('classes/database.php');
$db = new Database();
$conn = $db->getConnection();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

$stmt = $conn->prepare("SELECT * FROM roomprices WHERE Price_ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$promo = $result->fetch_assoc();
$stmt->close();

if (!$promo) {
    die("Promo not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $price = $_POST['price'];
    $from = $_POST['prom_from'];
    $to = $_POST['prom_to'];

    $stmt = $conn->prepare("UPDATE roomprices SET Price=?, PromValidF=?, PromValidT=? WHERE Price_ID=?");
    $stmt->bind_param("dssi", $price, $from, $to, $id);
    if ($stmt->execute()) {
        header("Location: admin_homepage.php#rooms");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Failed to update promo.</div>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Room Promo</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white text-center">
                    <h2 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Room Promo</h2>
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
                            <a href="admin_homepage.php#rooms" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>