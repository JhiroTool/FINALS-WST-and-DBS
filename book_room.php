<?php
session_start();
require_once('classes/database.php');
$db = new Database();

// Redirect if not logged in as user
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: index.php");
    exit();
}

// Get room info
$room_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$room = null;
if ($room_id) {
    $rooms = $db->getAllRooms();
    foreach ($rooms as $r) {
        if ($r['Room_ID'] == $room_id) {
            $room = $r;
            break;
        }
    }
}
if (!$room) {
    die("Room not found.");
}

// Handle booking form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';
    $guests = intval($_POST['guests'] ?? 1);

    $date1 = new DateTime($check_in);
    $date2 = new DateTime($check_out);
    $days = $date1 < $date2 ? $date1->diff($date2)->days : 0;
    $cost = $days * $room['Room_Rate'];

    if ($days > 0 && $guests > 0) {
        $status = "Pending";
        $emp_id = null;

        $result = $db->bookRoom(
            $_SESSION['user_id'],
            $room_id,
            $check_in,
            $check_out,
            $guests,
            $cost,
            $status,
            $emp_id
        );
        if ($result) {
            $message = '<div class="alert alert-success mt-3">Booking successful!</div>';
        } else {
            $message = '<div class="alert alert-danger mt-3">Booking failed. Please try again.</div>';
        }
    } else {
        $message = '<div class="alert alert-warning mt-3">Please enter valid dates and number of guests.</div>';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="style2.css">
  <title>Book Room</title>
</head>
<body>
  <div class="container my-5">
    <a href="homepage.php" class="btn btn-secondary mb-4">&larr; Back to Homepage</a>
    <div class="user-card mx-auto" style="max-width:500px;">
      <h3 class="mb-3"><?= htmlspecialchars($room['Room_Type']) ?> Room</h3>
      <div class="mb-2 text-muted">Capacity: <?= $room['Room_Cap'] ?></div>
      <div class="mb-2">Rate: <span class="fw-bold text-primary">₱<?= number_format($room['Room_Rate'], 2) ?></span> / night</div>
      <form method="post" class="mt-4">
        <div class="mb-3">
          <label for="check_in" class="form-label">Check-In Date</label>
          <input type="date" class="form-control" id="check_in" name="check_in" required>
        </div>
        <div class="mb-3">
          <label for="check_out" class="form-label">Check-Out Date</label>
          <input type="date" class="form-control" id="check_out" name="check_out" required>
        </div>
        <div class="mb-3">
          <label for="guests" class="form-label">Number of Guests</label>
          <input type="number" class="form-control" id="guests" name="guests" min="1" max="<?= $room['Room_Cap'] ?>" value="1" required>
        </div>
        <button type="submit" class="btn btn-action">Book Now</button>
      </form>
      <?= $message ?>
    </div>
  </div>
  <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>