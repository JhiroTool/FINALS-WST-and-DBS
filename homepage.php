<?php
session_start();
require_once('classes/database.php');
$db = new Database();

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
    <link rel="icon" type="image/jpg" href="img/resort.jpg" />
    <style>
        body { font-family: 'Montserrat', sans-serif; background: #f7f7f7; }
        .navbar { background: #fff; }
        .hero-section {
            background: linear-gradient(120deg, #e9f5ec 60%, #b2dfdb 100%);
            padding: 4rem 0 3rem 0;
            margin-bottom: 2rem;
            animation: fadeInDown 1s;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .section-title { font-weight: 800; margin-bottom: 1.5rem; letter-spacing: 1px; }
        .minimal-section {
            background: linear-gradient(120deg, #fff 80%, #e9f5ec 100%);
            border-radius: 18px;
            padding: 2.5rem 2rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 6px 32px rgba(67,160,71,0.07);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .minimal-section:hover {
            box-shadow: 0 12px 48px rgba(67,160,71,0.13);
            transform: translateY(-2px) scale(1.01);
        }
        .btn {
            border-radius: 20px;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(67,160,71,0.07);
        }
        .btn-success:hover, .btn-outline-danger:hover {
            opacity: 0.92;
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(67,160,71,0.13);
        }
        .room-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(67,160,71,0.06);
            margin-bottom: 1.5rem;
            transition: box-shadow 0.2s, transform 0.2s;
            background: linear-gradient(120deg, #fff 80%, #e9f5ec 100%);
        }
        .room-card:hover {
            box-shadow: 0 8px 32px rgba(67,160,71,0.13);
            transform: translateY(-2px) scale(1.01);
        }
        .amenity-icon {
            color: #43a047;
            margin-right: 0.7rem;
            font-size: 1.2rem;
        }
        .blockquote {
            border-left: 4px solid #b2dfdb;
            padding-left: 1rem;
            font-style: italic;
            background: #f8fafb;
            border-radius: 8px;
        }
        .contact-icon {
            color: #43a047;
            margin-right: 0.5rem;
        }
        footer {
            background: #e9f5ec;
            color: #43a047;
            text-align: center;
            padding: 1rem 0 0.5rem 0;
            font-size: 0.95rem;
            border-top: 1px solid #b2dfdb;
            margin-top: 2rem;
        }
        @media (max-width: 576px) {
            .minimal-section { padding: 1.2rem 0.7rem; }
            .hero-section { padding: 2rem 0 1.5rem 0; }
        }
    </style>
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
                            <span class="badge bg-success fs-6">₱<?= number_format($room['Room_Rate'], 2) ?></span>
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
            <div class="row">
                <?php foreach($amenities as $amenity): ?>
                <div class="col-md-6 mb-2">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-circle-check amenity-icon"></i>
                        <span>
                            <strong><?= htmlspecialchars($amenity['Amenity_Name']) ?></strong>
                            <?php if (!empty($amenity['Amenity_Desc'])): ?>
                                - <?= htmlspecialchars($amenity['Amenity_Desc']) ?>
                            <?php endif; ?>
                            <?php if (isset($amenity['Amenity_Cost'])): ?>
                                (₱<?= number_format($amenity['Amenity_Cost'], 2) ?>)
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SERVICES SECTION -->
        <section class="minimal-section" id="services">
            <h2 class="section-title">Our Services</h2>
            <div class="row">
                <?php if ($services && count($services)): ?>
                    <?php foreach ($services as $service): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h5 class="card-title mb-1"><?= htmlspecialchars($service['Service_Name']) ?></h5>
                                    <div class="mb-2 text-muted"><?= htmlspecialchars($service['Service_Desc']) ?></div>
                                    <span class="badge bg-success">₱<?= number_format($service['Service_Cost'], 2) ?></span>
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

                // Get latest booking for this customer
                $booking_id = null;
                $res = $db->getConnection()->query("SELECT Booking_ID FROM booking WHERE Cust_ID = $cust_id ORDER BY Booking_ID DESC LIMIT 1");
                if ($row = $res->fetch_assoc()) {
                    $booking_id = $row['Booking_ID'];
                }

                if ($booking_id) {
                    $stmt = $db->getConnection()->prepare("INSERT INTO feedback (Cust_ID, Booking_ID, Feed_Rating, Feed_Comment) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("iids", $cust_id, $booking_id, $feed_rating, $feed_comment);
                    $stmt->execute();
                    echo '<div class="alert alert-success mt-2">Thank you for your feedback!</div>';
                } else {
                    echo '<div class="alert alert-warning mt-2">You need a booking to leave feedback.</div>';
                }
            }

            // Display recent feedback
            $result = $db->getConnection()->query(
                "SELECT f.Feed_Rating, f.Feed_Comment, f.Feed_DOF, c.Cust_FN 
                 FROM feedback f 
                 JOIN customer c ON f.Cust_ID = c.Cust_ID 
                 ORDER BY f.Feed_DOF DESC LIMIT 5"
            );
            ?>
            <div class="row g-3 mt-4">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
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
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-muted">No feedback yet.</div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Victoria's Garden and Event Center. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>