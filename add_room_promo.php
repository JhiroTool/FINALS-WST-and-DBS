<?php
require_once('classes/database.php');
$db = new Database();

$rooms = $db->getAllRooms();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $price = $_POST['price'];
    $from = $_POST['prom_from'];
    $to = $_POST['prom_to'];

    if ($db->addRoomPromo($room_id, $price, $from, $to)) {
        $message = "<div class='alert alert-success'>Promo added!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Failed to add promo.</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Room Promo</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/room_promo.css">
</head>
<body>
<div class="promo-glass-card card shadow">
    <div class="card-header text-center">
        <h2><i class="bi bi-tag"></i> Add Room Promo</h2>
    </div>
    <div class="card-body">
        <?= $message ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Room</label>
                <select name="room_id" class="form-control" required>
                    <option value="" disabled selected>Select Room</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room['Room_ID'] ?>">
                            <?= htmlspecialchars($room['Room_Type']) ?>
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
                <a href="admin_homepage.php#rooms" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>