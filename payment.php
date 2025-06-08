<?php
// filepath: c:\xampp\htdocs\Finals_WST&DBS\payment.php
require_once('classes/database.php');
$db = new Database();
$conn = $db->getConnection();
$message = "";

$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $amount = $_POST['payment_amount'];
    $method = $_POST['payment_method'];

    // Insert payment
    $stmt = $conn->prepare("INSERT INTO payment (Booking_ID, Payment_Amount, Payment_Method) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $booking_id, $amount, $method);
    if ($stmt->execute()) {
        // Update booking status to 'Paid'
        $update = $conn->prepare("UPDATE booking SET Booking_Status = 'Paid' WHERE Booking_ID = ?");
        $update->bind_param("i", $booking_id);
        $update->execute();
        $update->close();

        $message = "<div class='alert alert-success'>Payment recorded successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Failed to record payment.</div>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Record Payment</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .payment-glass-card {
            max-width: 480px;
            margin: 48px auto 0 auto;
            background: rgba(255,255,255,0.82);
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.13);
            border: 1.5px solid rgba(120,120,120,0.08);
            backdrop-filter: blur(8px);
            padding: 2.5rem 2rem 2rem 2rem;
            animation: fadeInUp 0.7s;
        }
        .payment-glass-card h2 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #2563eb;
            letter-spacing: 1px;
        }
        .btn-action {
            width: 100%;
        }
        .back-btn {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
<div class="payment-glass-card">
    <a href="admin_homepage.php" class="btn btn-secondary back-btn">
        <i class="bi bi-arrow-left"></i> Back to Admin Homepage
    </a>
    <h2><i class="bi bi-cash-coin"></i> Record Payment</h2>
    <?php echo $message; ?>
    <form method="post">
        <input type="hidden" name="booking_id" id="booking_id" value="<?= $booking_id ?>">
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-journal-bookmark"></i> Booking ID</label>
            <input type="text" class="form-control" value="<?= $booking_id ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="payment_amount" class="form-label"><i class="bi bi-currency-dollar"></i> Amount</label>
            <input type="number" step="0.01" min="0" name="payment_amount" id="payment_amount" class="form-control" required readonly>
        </div>
        <div class="mb-3">
            <label for="payment_method" class="form-label"><i class="bi bi-credit-card"></i> Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="" disabled selected>Select payment method</option>
                <option value="Cash">Cash</option>
                <option value="Credit Card">Credit Card</option>
                <option value="GCash">GCash</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>
        </div>
        <button type="submit" class="btn btn-action"><i class="bi bi-check-circle"></i> Record Payment</button>
    </form>
</div>
<script>
window.addEventListener('DOMContentLoaded', function() {
    var bookingId = document.getElementById('booking_id').value;
    var amountInput = document.getElementById('payment_amount');
    if (bookingId) {
        fetch('get_booking_amount.php?booking_id=' + bookingId)
            .then(response => response.text())
            .then(amount => {
                amountInput.value = amount || '';
            });
    }
});
</script>
</body>
</html>