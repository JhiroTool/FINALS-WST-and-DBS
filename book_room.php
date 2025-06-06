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
    $emp_id = !empty($_POST['emp_id']) ? intval($_POST['emp_id']) : null;
    $amenities = $_POST['amenities'] ?? [];
    $services = $_POST['services'] ?? [];

    $date1 = new DateTime($check_in);
    $date2 = new DateTime($check_out);
    $days = $date1 < $date2 ? $date1->diff($date2)->days : 0;
    $cost = $days * $room['Room_Rate'];

    // Calculate amenities cost
    $amenities_cost = 0;
    foreach ($amenities as $amenity_id) {
        $amenity = $db->getAmenityById($amenity_id);
        if ($amenity) {
            $amenities_cost += $amenity['Amenity_Cost'];
        }
    }

    // Calculate services cost
    $services_cost = 0;
    foreach ($services as $service_id) {
        $service = $db->getServiceById($service_id);
        if ($service) {
            $services_cost += $service['Service_Cost'];
        }
    }

    $total_cost = $cost + $amenities_cost + $services_cost;

    if ($days > 0 && $guests > 0) {
        $status = "Pending";

        // 1. Insert into booking
        $booking_id = $db->bookRoom(
            $_SESSION['Cust_ID'],
            $check_in,
            $check_out,
            $guests,
            $total_cost,
            $status,
            $emp_id
        );
        // 2. Link booking to room
        if ($booking_id) {
            $result = $db->addBookingRoom($booking_id, $room_id);

            // Save amenities if any were selected
            if (!empty($_POST['amenities']) && is_array($_POST['amenities'])) {
                foreach ($_POST['amenities'] as $amenity_id) {
                    $db->addBookingAmenity($booking_id, intval($amenity_id));
                }
            }

            // Save services if any were selected
            if (!empty($_POST['services']) && is_array($_POST['services'])) {
                foreach ($_POST['services'] as $service_id) {
                    $db->addBookingService($booking_id, intval($service_id));
                }
            }

            if ($result) {
                $message = '<div class="alert alert-success mt-3">Booking successful!</div>';
            } else {
                $message = '<div class="alert alert-danger mt-3">Failed to link room to booking.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger mt-3">Booking failed.</div>';
        }
    } else {
        $message = '<div class="alert alert-warning mt-3">Please enter valid dates and number of guests.</div>';
    }
}
$employees = $db->getAllEmployees();
$amenities = $db->getAllAmenities();
$services = $db->getAllServices();
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
<body class="bg-light">
  <div class="container py-5">
    <a href="homepage.php" class="btn btn-secondary mb-4">&larr; Back to Homepage</a>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow glass-card">
          <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?= htmlspecialchars($room['Room_Type']) ?> Room</h4>
          </div>
          <div class="card-body">
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
              <div class="mb-3">
                <label for="emp_id" class="form-label">Assign Employee (optional)</label>
                <select name="emp_id" class="form-select">
                    <option value="">-- Assign Employee (optional) --</option>
                    <?php foreach($employees as $emp): ?>
                        <option value="<?= $emp['Emp_ID'] ?>"><?= htmlspecialchars($emp['Emp_FN'] . ' ' . $emp['Emp_LN']) ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Add Amenities (optional)</label>
                <div class="row">
                  <?php foreach($amenities as $amenity): ?>
                    <div class="col-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="amenities[]" value="<?= $amenity['Amenity_ID'] ?>" id="amenity<?= $amenity['Amenity_ID'] ?>">
                        <label class="form-check-label" for="amenity<?= $amenity['Amenity_ID'] ?>">
                          <?= htmlspecialchars($amenity['Amenity_Name']) ?>
                          <?php if (!empty($amenity['Amenity_Cost'])): ?>
                            (₱<?= number_format($amenity['Amenity_Cost'], 2) ?>)
                          <?php endif; ?>
                        </label>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Add Services (optional)</label>
                <div class="row">
                    <?php foreach($services as $service): ?>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="services[]" value="<?= $service['Service_ID'] ?>" id="service<?= $service['Service_ID'] ?>">
                                <label class="form-check-label" for="service<?= $service['Service_ID'] ?>">
                                    <?= htmlspecialchars($service['Service_Name']) ?>
                                    <?php if (!empty($service['Service_Cost'])): ?>
                                        (₱<?= number_format($service['Service_Cost'], 2) ?>)
                                    <?php endif; ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
              </div>
              <button type="submit" class="btn btn-success w-100">Book Now</button>
            </form>
            <?= $message ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>