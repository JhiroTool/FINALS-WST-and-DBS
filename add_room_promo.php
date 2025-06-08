<?php
require_once('classes/database.php');
$db = new Database();
$conn = $db->getConnection();

$rooms = $db->getAllRooms();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $price = $_POST['price'];
    $from = $_POST['prom_from'];
    $to = $_POST['prom_to'];

    $stmt = $conn->prepare("INSERT INTO roomprices (Room_ID, Price, PromValidF, PromValidT) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $room_id, $price, $from, $to);
    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Promo added!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Failed to add promo.</div>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Room Promo</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(120deg, #e0e7ff 0%, #f8fafc 100%);
            min-height: 100vh;
        }
        .promo-glass-card {
            max-width: 500px;
            margin: 60px auto 0 auto;
            background: rgba(255,255,255,0.92);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.13);
            border: 1.5px solid rgba(120,120,120,0.08);
            backdrop-filter: blur(8px);
            padding: 2.5rem 2rem 2rem 2rem;
            animation: fadeInUp 0.7s;
        }
        .promo-glass-card .card-header {
            background: linear-gradient(90deg, #2563eb 60%, #60a5fa 100%);
        }
        .promo-glass-card h2 {
            font-weight: 700;
            margin-bottom: 0;
            color: #fff;
            letter-spacing: 1px;
        }
        .promo-glass-card .form-label {
            font-weight: 500;
        }
        .btn-primary {
            background: #2563eb;
            border: none;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
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