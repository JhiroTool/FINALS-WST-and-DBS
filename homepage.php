<?php
session_start();
require_once('classes/database.php');
require_once('classes/functions.php');
$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header("Location: index.php");
    exit();
}

$rooms = $db->getAllRooms();
$amenities = $db->getAllAmenities();
$services = $db->getAllServices();
?>
<!doctype html>
<html lang="en">
<head>
    <title>Victoria's Garden and Event Center</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
    <link href="assets/css/homepage.css" rel="stylesheet" />
    <link rel="icon" type="image/jpg" href="img/resort.jpg" />
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-light shadow-sm mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="navbar-brand fw-bold fs-4">Victoria's Garden</span>
            <span class="text-success fw-semibold"><?= htmlspecialchars($_SESSION['user_FN']) ?></span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <div class="hero-section text-center">
        <h1 class="display-5 fw-bold mb-3">Victoria's Garden and Event Center</h1>
        <p class="text-muted fs-5 mb-0">Experience comfort and elegance in every stay.</p>
    </div>

    <div class="container" style="max-width: 950px;">
        <!-- ABOUT SECTION -->
        <section class="minimal-section" id="about">
            <h2 class="section-title">About Us</h2>
            <p class="text-muted mb-0 fs-5">
                Welcome to Victoria's Garden and Event Center, your perfect destination for relaxation and memorable events.
            </p>
        </section>

        <!-- WHY CHOOSE US SECTION -->
        <section class="minimal-section" id="whychoose">
            <h2 class="section-title">Why Choose Us?</h2>
            <div class="row text-muted fs-6">
                <div class="col-md-4 mb-2"><i class="fa-solid fa-leaf amenity-icon"></i>Beautiful garden ambiance</div>
                <div class="col-md-4 mb-2"><i class="fa-solid fa-bolt amenity-icon"></i>Modern amenities</div>
                <div class="col-md-4 mb-2"><i class="fa-solid fa-users amenity-icon"></i>Friendly staff</div>
            </div>
        </section>

        <!-- ROOMS SECTION (Dynamic) -->
        <section class="minimal-section" id="rooms">
            <h2 class="section-title">Available Rooms</h2>
            <div class="row">
                <?php foreach($rooms as $room): ?>
                <div class="col-md-6">
                    <div class="card room-card p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0"><?= htmlspecialchars($room['Room_Type']) ?></h5>
                            <span class="badge bg-success fs-6">
                                ₱<?= number_format($db->getRoomPrice($room['Room_ID'], $room['Room_Rate']), 2) ?>
                            </span>
                        </div>
                        <div class="mb-2 text-muted">Capacity: <?= $room['Room_Cap'] ?></div>
                        <a href="book_room.php?id=<?= $room['Room_ID'] ?>" class="btn btn-success btn-sm w-100">Book</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- AMENITIES SECTION -->
        <section class="minimal-section" id="amenities">
            <h2 class="section-title">Amenities</h2>
            <div class="row g-3">
                <?php foreach($amenities as $amenity): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100 glass-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fa-solid fa-circle-check amenity-icon fs-2"></i>
                            </div>
                            <div>
                                <div class="fw-semibold"><?= htmlspecialchars($amenity['Amenity_Name']) ?></div>
                                <?php if (!empty($amenity['Amenity_Desc'])): ?>
                                    <div class="text-muted small mb-1"><?= htmlspecialchars($amenity['Amenity_Desc']) ?></div>
                                <?php endif; ?>
                                <span class="badge bg-success">
                                    ₱<?= number_format($db->getAmenityPrice($amenity['Amenity_ID'], $amenity['Amenity_Cost']), 2) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SERVICES SECTION -->
        <section class="minimal-section" id="services">
            <h2 class="section-title">Our Services</h2>
            <div class="row g-3">
                <?php if ($services && count($services)): ?>
                    <?php foreach ($services as $service): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card shadow-sm border-0 h-100 glass-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa-solid fa-gear text-info fs-2 me-2"></i>
                                        <h5 class="card-title mb-0"><?= htmlspecialchars($service['Service_Name']) ?></h5>
                                    </div>
                                    <div class="mb-2 text-muted small"><?= htmlspecialchars($service['Service_Desc']) ?></div>
                                    <span class="badge bg-info text-dark">
                                        ₱<?= number_format($db->getServicePrice($service['Service_ID'], $service['Service_Cost']), 2) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-muted">No services available at the moment.</div>
                <?php endif; ?>
            </div>
        </section>

        <!-- TESTIMONIALS SECTION -->
        <section class="minimal-section" id="testimonials">
            <h2 class="section-title">Testimonials</h2>
            <blockquote class="blockquote text-muted mb-0">
                <p class="mb-0">"A wonderful place to stay!"</p>
                <footer class="blockquote-footer">Happy Guest</footer>
            </blockquote>
        </section>

        <!-- CONTACT SECTION -->
        <section class="minimal-section" id="contact">
            <h2 class="section-title">Contact Us</h2>
            <p class="text-muted mb-0">
                <i class="fa-solid fa-envelope contact-icon"></i>Email: info@victoriasgarden.com
            </p>
            <p class="text-muted">
                <i class="fa-solid fa-phone contact-icon"></i>Phone: 123-456-7890
            </p>
        </section>

        <!-- FEEDBACK SECTION -->
        <section class="minimal-section" id="feedback">
            <h2 class="section-title">Feedback</h2>
            <form method="post" class="mb-4">
                <div class="mb-2">
                    <label for="feed_rating" class="form-label">Rating</label>
                    <select name="feed_rating" id="feed_rating" class="form-select" required>
                        <option value="">Select rating</option>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Good</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="feed_comment" class="form-label">Comment</label>
                    <textarea name="feed_comment" id="feed_comment" class="form-control" rows="3" placeholder="Your feedback..." required></textarea>
                </div>
                <button type="submit" name="submit_feedback" class="btn btn-success">Submit Feedback</button>
            </form>
            <?php
            // Handle feedback submission
            if (isset($_POST['submit_feedback'], $_POST['feed_rating'], $_POST['feed_comment']) && !empty(trim($_POST['feed_comment']))) {
                $feed_rating = floatval($_POST['feed_rating']);
                $feed_comment = trim($_POST['feed_comment']);
                $cust_id = $_SESSION['user_id'];
                $booking_id = $db->getLatestBookingId($cust_id);

                if ($booking_id && $db->addFeedback($cust_id, $booking_id, $feed_rating, $feed_comment)) {
                    echo '<div class="alert alert-success mt-2">Thank you for your feedback!</div>';
                } else {
                    echo '<div class="alert alert-warning mt-2">You need a booking to leave feedback.</div>';
                }
            }

            $recentFeedback = $db->getRecentFeedback(5);
            ?>
            <div class="row g-3 mt-4">
                <?php if ($recentFeedback && count($recentFeedback)): ?>
                    <?php foreach ($recentFeedback as $row): ?>
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body d-flex align-items-start">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:44px;height:44px;font-size:1.3rem;">
                                            <?= strtoupper(substr($row['Cust_FN'], 0, 1)) ?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-semibold"><?= htmlspecialchars($row['Cust_FN']) ?></div>
                                        <div class="mb-1" style="color:#ffc107;">
                                            <?php
                                            $stars = intval($row['Feed_Rating']);
                                            for ($i = 0; $i < $stars; $i++) echo '<i class="fa fa-star"></i>';
                                            for ($i = $stars; $i < 5; $i++) echo '<i class="fa-regular fa-star"></i>';
                                            ?>
                                        </div>
                                        <div class="mb-2 text-muted" style="font-size:0.98em;"><?= htmlspecialchars($row['Feed_Comment']) ?></div>
                                        <div class="text-muted small"><i class="fa fa-clock"></i> <?= date('M d, Y H:i', strtotime($row['Feed_DOF'])) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-muted">No feedback yet.</div>
                <?php endif; ?>
            </div>
        </section>

        <!-- PAYMENT SECTION -->
        <?php
        // PAYMENT SECTION
        $paymentMsg = '';
        if (isset($_POST['submit_payment'])) {
            $cust_id = $_SESSION['user_id'];
            $result = handlePaymentUpload($db, $cust_id, $_POST, $_FILES);
            $paymentMsg = '<div class="alert alert-' . $result['status'] . ' mt-2">' . $result['msg'] . '</div>';
        }
        ?>

        <!-- PAYMENT SECTION -->
        <section class="minimal-section" id="payment">
            <h2 class="section-title">Upload Payment Receipt</h2>
            <?= $paymentMsg ?>
            <?php
            $cust_id = $_SESSION['user_id'];
            $latestBooking = $db->getLatestUnpaidBooking($cust_id);

            if ($latestBooking) {
                $booking_id = $latestBooking['Booking_ID'];
                $booking_time = strtotime($latestBooking['Booking_IN']);
                $now = time();
                $timeout = 12 * 60 * 60; // 12 hours in seconds
                $time_left = ($booking_time + $timeout) - $now;

                if ($time_left > 0 && $latestBooking['Booking_Status'] === 'Pending') {
                    // Payment form
                    ?>
                    <form method="post" enctype="multipart/form-data" class="mb-3">
                        <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                        <div class="mb-2">
                            <label for="payment_amount" class="form-label">Amount</label>
                            <input type="number" name="payment_amount" id="payment_amount" class="form-control" value="<?= htmlspecialchars($latestBooking['Booking_Cost']) ?>" readonly>
                        </div>
                        <div class="mb-2">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="" disabled selected>Select payment method</option>
                                <option value="Cash">Cash</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="GCash">GCash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="receipt_image" class="form-label">Upload Receipt Image</label>
                            <input type="file" name="receipt_image" id="receipt_image" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" name="submit_payment" class="btn btn-primary">Submit Payment</button>
                        <div class="mt-2 text-muted small">
                            Time left to upload: <span id="timeLeft"></span>
                        </div>
                    </form>
                    <script>
                    // Countdown timer
                    let timeLeft = <?= $time_left ?>;
                    function updateTimer() {
                        if (timeLeft <= 0) {
                            document.getElementById('timeLeft').textContent = "Time expired!";
                            document.querySelector('form[method="post"]').style.display = "none";
                            return;
                        }
                        let hours = Math.floor(timeLeft / 3600);
                        let minutes = Math.floor((timeLeft % 3600) / 60);
                        let seconds = timeLeft % 60;
                        document.getElementById('timeLeft').textContent =
                            hours + "h " + minutes + "m " + seconds + "s";
                        timeLeft--;
                        setTimeout(updateTimer, 1000);
                    }
                    updateTimer();
                    </script>
                    <?php
                } else {
                    echo '<div class="alert alert-warning">Payment upload time has expired for your latest booking.</div>';
                }
            } else {
                echo '<div class="alert alert-info">No pending bookings found for payment.</div>';
            }
            ?>
        </section>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Victoria's Garden and Event Center. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>