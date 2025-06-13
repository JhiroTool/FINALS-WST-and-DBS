<?php
// filepath: c:\xampp\htdocs\Finals_WST&DBS\payment.php
require_once('classes/database.php');
$db = new Database();

$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;
$payment = $db->getPaymentByBookingId($booking_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_paid']) && $payment && $payment['Payment_ID']) {
    if ($db->markBookingAsPaid($booking_id)) {
        $message = "<div class='alert alert-success'>Booking marked as Paid!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Failed to update status.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Record Payment</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/payment.css">
</head>
<body>
<div class="payment-glass-card">
    <a href="admin_homepage.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Back</a>
    <?php if ($payment && $payment['Receipt_Image']): ?>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-file-earmark-image"></i> Uploaded Receipt</label><br>
            <img src="./upload/<?= htmlspecialchars($payment['Receipt_Image']) ?>" alt="Receipt" style="max-width:200px;">
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
        <div class="mb-3">
            <label for="payment_amount" class="form-label">Amount</label>
            <input type="number" name="payment_amount" id="payment_amount" class="form-control" value="<?= htmlspecialchars($payment['Payment_Amount']) ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <input type="text" name="payment_method" id="payment_method" class="form-control" value="<?= htmlspecialchars($payment['Payment_Method']) ?>" readonly>
        </div>
        <button type="submit" name="mark_paid" class="btn btn-success"><i class="bi bi-check-circle"></i> Mark as Paid</button>
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