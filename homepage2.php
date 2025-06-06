<!doctype html>
<html lang="en">
<head>
    <title>Victoria's Garden and Event Center</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
 
    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
 
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
 
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
 
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: linear-gradient(135deg, #fff 60%, #ffd700 100%);
            color: #222;
            transition: all 0.3s ease;
        }
        body.dark-mode {
            background: linear-gradient(135deg, #222 60%, #111 100%);
            color: #fff;
        }
        .navbar {
            background: transparent;
            transition: background 0.4s, box-shadow 0.4s;
            padding: 1.5rem 0;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 1.1rem;
            letter-spacing: 1px;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        .navbar.scrolled {
            background: #ffd700 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            backdrop-filter: blur(12px);
        }
        .navbar.dark-mode,
        .navbar.scrolled.dark-mode {
            background: #222 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
        }
        .navbar .navbar-brand {
            color: #006400 !important;
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 0 2px 8px #ffd70044;
        }
        .navbar .nav-link {
            color: #006400 !important;
            font-weight: 700;
            margin-left: 2rem;
            letter-spacing: 1.5px;
            transition: color 0.3s;
            position: relative;
            text-transform: uppercase;
            font-size: 1.05rem;
        }
        .navbar .nav-link:after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: #006400;
            transition: width .3s;
            position: absolute;
            left: 0;
            bottom: -4px;
        }
        .navbar .nav-link:hover:after,
        .navbar .nav-link.active:after {
            width: 100%;
        }
        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: #ffd700 !important;
        }
        .navbar.scrolled .navbar-brand,
        .navbar.scrolled .nav-link {
            color: #006400 !important;
            text-shadow: none;
        }
        .hero-section {
            position: relative;
            width: 100vw;
            min-height: 92vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }
        .hero-bg-img {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            z-index: 1;
            filter: brightness(0.80) contrast(1.18) saturate(1.15) blur(1px);
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(120deg, rgba(0,100,0,0.18) 0%, rgba(255,215,0,0.18) 100%);
            z-index: 2;
        }
        .hero-content {
            position: relative;
            z-index: 3;
            color: #fff;
            text-align: center;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 180px 20px 140px 20px;
            background: rgba(0,0,0,0.18);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            backdrop-filter: blur(2px);
        }
        .hero-content h1 {
            font-size: 3.2rem;
            font-weight: 900;
            color: #ffd700;
            letter-spacing: 3px;
            text-shadow: 0 4px 24px #000, 0 2px 8px #000;
        }
        .hero-content p {
            font-size: 1.4rem;
            color: #fff;
            text-shadow: 0 2px 8px #000;
            margin-bottom: 2.2rem;
        }
        .hero-content .btn-main, .hero-content .btn-custom {
            margin: 0 0.5rem;
        }
        .section-title {
            font-size: 2.7rem;
            font-weight: 800;
            color: #006400;
            margin-bottom: 2.5rem;
            text-align: center;
            letter-spacing: 2px;
            position: relative;
            text-transform: uppercase;
            animation: fadeInDown 1s;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-40px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .section-divider {
            width: 80px;
            height: 5px;
            background: linear-gradient(90deg, #ffd700 0%, #fff 100%);
            margin: 0 auto 2.5rem auto;
            border-radius: 3px;
        }
        .card-custom {
            border-radius: 22px;
            box-shadow: 0 6px 24px rgba(0,0,0,0.13);
            background: #fff;
            transition: box-shadow 0.2s, transform 0.2s;
            border: 2px solid #ffd70022;
            margin-bottom: 2.5rem;
            padding: 2.5rem 1.5rem 2rem 1.5rem;
        }
        .card-custom:hover {
            box-shadow: 0 12px 36px rgba(0,0,0,0.18);
            transform: translateY(-6px) scale(1.03);
        }
        .card-custom i {
            margin-bottom: 1rem;
        }
        .amenities-grid {
            gap: 2.5rem;
            margin-bottom: 2rem;
        }
        .amenity-box {
            background: linear-gradient(120deg, #fff 80%, #ffd70022 100%);
            border-radius: 22px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 2.5rem 1.5rem 2rem 1.5rem;
            text-align: center;
            width: 240px;
            border: 2px solid #ffd70022;
            transition: box-shadow 0.2s, border 0.2s, transform 0.2s;
        }
        .amenity-box:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
            border-color: #ffd700;
            transform: translateY(-6px) scale(1.03);
        }
        .amenity-box i {
            color: #ffd700;
            font-size: 2.7rem;
            margin-bottom: 1.2rem;
        }
        .amenity-box h5 {
            color: #006400;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .room-card {
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            background: #fff;
            margin-bottom: 2.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 2px solid #ffd70022;
            animation: fadeInUp 1s;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .room-card img {
            width: 100%;
            height: 270px;
            object-fit: cover;
            border-bottom: 4px solid #ffd700;
        }
        .room-card-body {
            padding: 2rem 1.5rem 1.5rem 1.5rem;
        }
        .room-card-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #006400;
            margin-bottom: 0.5rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .testimonial-carousel .carousel-item {
            text-align: center;
            padding: 2.5rem 4rem;
        }
        .testimonial-carousel .testimonial-text {
            font-size: 1.25rem;
            color: #222;
            margin-bottom: 1.2rem;
            font-style: italic;
            font-family: 'Montserrat', Arial, sans-serif;
        }
        .testimonial-carousel .testimonial-author {
            font-weight: 800;
            color: #006400;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #ffd700;
            color: #006400;
            padding: 18px 32px;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            font-weight: 800;
            font-size: 1.2rem;
            border: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .floating-btn:hover {
            background-color: #fff;
            color: #006400;
            transform: scale(1.1);
        }
        /* Section backgrounds for separation */
        .section-bg-light {
            background: #f8f9fa;
            border-radius: 32px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            margin-bottom: 40px;
            padding: 40px 0;
        }
        .section-bg-gold {
            background: linear-gradient(90deg, #fff 60%, #ffd70022 100%);
            border-radius: 32px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            margin-bottom: 40px;
            padding: 40px 0;
        }
        /* Sidebar styles */
        .sidebar {
            position: fixed;
            top: 0;
            right: -340px;
            width: 320px;
            height: 100vh;
            background: #222;
            color: #fff;
            z-index: 1200;
            box-shadow: -2px 0 16px rgba(0,0,0,0.18);
            transition: right 0.35s cubic-bezier(.77,0,.18,1);
            padding: 36px 24px 24px 24px;
            overflow-y: auto;
            border-top-left-radius: 24px;
            border-bottom-left-radius: 24px;
        }
        .sidebar.active {
            right: 0;
        }
        .sidebar .btn-custom {
            background: #ffd700;
            color: #222;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar .btn-custom:hover {
            background: #fff;
            color: #006400;
        }
        /* Overlay for sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.35);
            z-index: 1199;
            transition: opacity 0.3s;
        }
        .sidebar-overlay.active {
            display: block;
        }
        /* Responsive tweaks */
        @media (max-width: 767px) {
            .hero-content h1 { font-size: 2.1rem; }
            .section-title { font-size: 1.7rem; }
            .room-card img { height: 170px; }
        }
    </style>
    <link rel="icon" type="image/jpg" href="img/resort.jpg" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Loading Spinner -->
    <div id="loadingSpinner">
        <div class="spinner-border" role="status"></div>
    </div>
    <!-- Settings Button -->
    <button class="settings-btn animate__animated animate__pulse animate__infinite" onclick="toggleSidebar()" style="position:fixed;top:30px;right:30px;z-index:1300;">Settings</button>
 
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
 
    <!-- Sidebar -->
    <div class="sidebar" id="settingsSidebar">
        <span class="close-btn fs-2" style="cursor:pointer;position:absolute;top:10px;right:18px;" onclick="toggleSidebar()">×</span>
        <h4 class="mb-4 text-center" style="color:#ffd700;font-weight:800;letter-spacing:1px;">Settings</h4>
        <div class="d-grid gap-2 mb-3">
            <button class="btn btn-custom" onclick="toggleTheme()">
                <i class="fas fa-adjust me-2"></i>Toggle Theme
            </button>
            <button class="btn btn-custom" onclick="toggleAccessibility()">
                <i class="fas fa-universal-access me-2"></i>Accessibility
            </button>
            <button class="btn btn-custom" onclick="startVirtualTour()">
                <i class="fas fa-vr-cardboard me-2"></i>Virtual Tour
            </button>
            <button class="btn btn-custom" onclick="openLiveChat()">
                <i class="fas fa-comments me-2"></i>Live Chat
            </button>
            <button class="btn btn-custom" onclick="showNewsletterModal()">
                <i class="fas fa-envelope-open-text me-2"></i>Newsletter Signup
            </button>
        </div>
        <div class="mb-2">
            <label for="langSelect" class="form-label" style="color:#ffd700;font-weight:600;">Language</label>
            <select id="langSelect" class="form-select" onchange="changeLanguage(this.value)">
                <option value="en">English</option>
                <option value="es">Spanish</option>
                <option value="fr">French</option>
            </select>
        </div>
        <div class="text-center mt-4" style="font-size:0.95rem;color:#ffd700;">
            <i class="fas fa-cog fa-spin me-1"></i>
            Customize your experience
        </div>
    </div>
 
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Victoria's Garden</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="#about" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="#rooms" class="nav-link">Rooms</a></li>
                    <li class="nav-item"><a href="#amenities" class="nav-link">Amenities</a></li>
                    <li class="nav-item"><a href="#testimonials" class="nav-link">Testimonials</a></li>
                    <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
 
    <!-- HERO SECTION -->
    <div class="hero-section">
        <img src="img/resort.jpg" type="image/jpg" alt="Resort" class="hero-bg-img">
        <div class="hero-overlay"></div>
        <div class="hero-content animate__animated animate__fadeInDown">
            <h1>Welcome to Victoria's Garden</h1>
            <p>Experience riverside luxury, lush gardens, and unforgettable moments. Your perfect escape awaits at Victoria's Garden and Event Center.</p>
            <a href="#rooms" class="btn btn-main shadow-lg me-2">Book Now</a>
            <a href="gallery.html" class="btn btn-custom shadow-lg">View Gallery</a>
        </div>
        <div class="scroll-indicator">
            <div class="mouse"><div class="mouse-wheel"></div></div>
            <span>Scroll Down</span>
        </div>
    </div>
 
    <!-- ABOUT SECTION -->
    <section class="container section-bg-light" id="about">
        <h2 class="section-title">About Us</h2>
        <div class="section-divider"></div>
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="img/resort.jpg" alt="Victoria's Garden" class="img-fluid rounded-4 shadow" style="max-width: 420px;">
            </div>
            <div class="col-lg-6 text-center text-lg-start" style="font-size:1.15rem; color:#444;">
                <p>
                    Nestled in the heart of nature, Victoria's Garden and Event Center offers a serene escape from the hustle and bustle of city life. Our resort combines luxury, comfort, and breathtaking views to create an unforgettable experience.
                </p>
                <a href="about.html" class="btn btn-custom mt-3">
                    Learn More About Us
                </a>
            </div>
        </div>
    </section>
 
    <!-- WHY CHOOSE US SECTION -->
    <section class="container section-bg-gold" id="whychoose">
        <h2 class="section-title">Why Choose Us</h2>
        <div class="section-divider"></div>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card-custom">
                    <i class="fas fa-leaf fa-2x mb-3 text-success"></i>
                    <h5 class="mb-2">Nature Retreat</h5>
                    <p>Enjoy tranquil gardens, riverside walks, and a peaceful environment away from the city.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card-custom">
                    <i class="fas fa-star fa-2x mb-3 text-warning"></i>
                    <h5 class="mb-2">Premium Amenities</h5>
                    <p>Infinity pool, spa, fine dining, and modern rooms for a truly luxurious stay.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card-custom">
                    <i class="fas fa-users fa-2x mb-3 text-primary"></i>
                    <h5 class="mb-2">Events & Gatherings</h5>
                    <p>Perfect for weddings, reunions, and corporate events with expert planning and service.</p>
                </div>
            </div>
        </div>
    </section>
 
    <!-- ROOMS SECTION -->
    <section class="container section-bg-light" id="rooms">
        <h2 class="section-title">Our Rooms</h2>
        <div class="section-divider"></div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="room-card">
                    <img src="img/room-1.jpg" alt="Room 1">
                    <div class="room-card-body">
                        <div class="room-card-title">Room 1</div>
                        <p>A cozy room with two single beds and a scenic view of the pool.</p>
                        <a href="#" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#bookingModal">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="room-card">
                    <img src="img/room-2.jpg" alt="Room 2">
                    <div class="room-card-body">
                        <div class="room-card-title">Room 2</div>
                        <p>Elegant room with two single beds, perfect for couples or friends.</p>
                        <a href="#" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#bookingModal">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="room-card">
                    <img src="img/room-3.jpg" alt="Room 3">
                    <div class="room-card-body">
                        <div class="room-card-title">Room 3</div>
                        <p>A practical room with bunk beds, ideal for families or groups.</p>
                        <a href="#" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#bookingModal">View Details</a>
                    </div>
                   
                </div>
            </div>
        </div>
    </section>
 
    <!-- AMENITIES SECTION -->
    <section class="container section-bg-gold" id="amenities">
        <h2 class="section-title">Amenities</h2>
        <div class="section-divider"></div>
        <div class="amenities-grid d-flex flex-wrap justify-content-center">
            <div class="amenity-box">
                <i class="fas fa-swimming-pool"></i>
                <h5>Swimming Pool</h5>
                <p>Relax and unwind in our infinity pool.</p>
            </div>
            <div class="amenity-box">
                <i class="fas fa-spa"></i>
                <h5>Spa</h5>
                <p>Indulge in rejuvenating spa treatments.</p>
            </div>
            <div class="amenity-box">
                <i class="fas fa-utensils"></i>
                <h5>Fine Dining</h5>
                <p>Enjoy delicious meals at our restaurant.</p>
            </div>
            <div class="amenity-box">
                <i class="fas fa-wifi"></i>
                <h5>Free Wi-Fi</h5>
                <p>Stay connected throughout your stay.</p>
            </div>
            <div class="amenity-box">
                <i class="fas fa-motorcycle"></i>
                <h5>ATV Rentals</h5>
                <p>Explore the area with our ATV rentals.</p>
            </div>
        </div>
    </section>
 
    <!-- TESTIMONIALS SECTION -->
    <section class="container section-bg-light" id="testimonials">
        <h2 class="section-title">Guest Testimonials</h2>
        <div class="section-divider"></div>
        <div id="testimonialCarousel" class="carousel slide testimonial-carousel" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="testimonial-text">"An unforgettable experience! The staff was amazing and the views were breathtaking."</div>
                    <div class="testimonial-author">- Sarah M.</div>
                </div>
                <div class="carousel-item">
                    <div class="testimonial-text">"The perfect getaway. The spa treatments were divine and the food was exceptional."</div>
                    <div class="testimonial-author">- James T.</div>
                </div>
                <div class="carousel-item">
                    <div class="testimonial-text">"Our family had the best vacation ever. The family room was perfect for us."</div>
                    <div class="testimonial-author">- Emily R.</div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
 
    <!-- CONTACT SECTION -->
    <section class="container section-bg-gold" id="contact">
        <h2 class="section-title">Contact Us</h2>
        <div class="section-divider"></div>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <form id="contactForm" onsubmit="return validateForm(event)">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name" required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email" required />
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Enter your message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </section>
 
    <!-- DAY TOUR / NIGHT TOUR / OVERNIGHT SECTION -->
    <section class="container py-5" id="tourchoices">
        <h2 class="section-title">Tour & Stay Choices</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card-custom p-4 h-100">
                    <i class="fas fa-sun fa-2x mb-3 text-warning"></i>
                    <h5 class="mb-2">Day Tour</h5>
                    <p>Enjoy the beauty of Victoria's Garden from sunrise to sunset. Includes access to amenities, gardens, and the pool. Perfect for families and groups seeking a short escape.</p>
                    <a href="#bookingModal" class="btn btn-custom mt-2" data-bs-toggle="modal" onclick="setBookingType('Day Tour')">Book Day Tour</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card-custom p-4 h-100">
                    <i class="fas fa-moon fa-2x mb-3 text-primary"></i>
                    <h5 class="mb-2">Night Tour</h5>
                    <p>Experience the magic of our illuminated gardens and tranquil ambiance at night. Includes evening amenities, dinner options, and live entertainment (on select dates).</p>
                    <a href="#bookingModal" class="btn btn-custom mt-2" data-bs-toggle="modal" onclick="setBookingType('Night Tour')">Book Night Tour</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card-custom p-4 h-100">
                    <i class="fas fa-bed fa-2x mb-3 text-success"></i>
                    <h5 class="mb-2">Overnight Stay</h5>
                    <p>Stay in comfort with our overnight packages. Includes room accommodation, breakfast, and full access to all amenities. Ideal for a relaxing getaway or special celebration.</p>
                    <a href="#bookingModal" class="btn btn-custom mt-2" data-bs-toggle="modal" onclick="setBookingType('Overnight Stay')">Book Overnight</a>
                </div>
            </div>
            <!-- NEW CHOICE: Exclusive Overnight (All Rooms, up to 30 pax) -->
            <div class="col-md-12 mb-4">
                <div class="card-custom p-4 h-100" style="background:linear-gradient(120deg,#ffd70022 80%,#fff 100%);">
                    <i class="fas fa-users fa-2x mb-3 text-danger"></i>
                    <h5 class="mb-2">Exclusive Overnight (All Rooms, up to 30 pax)</h5>
                    <p>Book the entire resort for your group! Enjoy all rooms exclusively for a maximum of 30 guests, including full amenities, breakfast, and privacy for your special event or gathering.</p>
                    <a href="#bookingModal" class="btn btn-custom mt-2" data-bs-toggle="modal" onclick="setBookingType('Exclusive Overnight')">Book Exclusive Overnight</a>
                </div>
            </div>
        </div>
    </section>
 
    <!-- BOOKING MODAL -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Book Your Stay</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookingForm">
                        <div id="dateFields">
                            <div class="mb-3">
                                <label for="checkIn" class="form-label">Check-in Date</label>
                                <input type="date" class="form-control" id="checkIn" />
                            </div>
                            <div class="mb-3">
                                <label for="checkOut" class="form-label">Check-out Date</label>
                                <input type="date" class="form-control" id="checkOut" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="guests" class="form-label">Number of Guests</label>
                            <input type="number" class="form-control" id="guests" min="1" required />
                        </div>
                        <div class="mb-3">
                            <label for="roomType" class="form-label">Room Type / Tour</label>
                            <select class="form-control" id="roomType" required onchange="toggleDateFields()">
                                <option value="">Select Room Type or Tour</option>
                                <option value="deluxe">Deluxe Room</option>
                                <option value="suite">Suite</option>
                                <option value="family">Family Room</option>
                                <option value="daytour">Day Tour</option>
                                <option value="nighttour">Night Tour</option>
                                <option value="overnightstay">Overnight Stay</option>
                                <option value="exclusiveovernight">Exclusive Overnight (All Rooms, up to 30 pax)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitBooking()">Book Now</button>
                </div>
            </div>
        </div>
    </div>
 
    <!-- Newsletter Modal -->
    <div class="modal fade" id="newsletterModal" tabindex="-1" aria-labelledby="newsletterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newsletterModalLabel">Newsletter Signup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newsletterForm">
                        <div class="mb-3">
                            <label for="newsletterEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="newsletterEmail" placeholder="Enter your email" required />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitNewsletter()">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
 
    <!-- Floating Book Now Button -->
    <button class="floating-btn animate__animated animate__pulse animate__infinite" data-bs-toggle="modal" data-bs-target="#bookingModal">Book Now</button>
    <!-- Back to Top Button -->
    <button id="backToTopBtn" title="Back to top"><i class="fas fa-arrow-up"></i></button>
    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <div class="mb-3">
                <strong>Victoria's Garden and Event Center</strong><br>
            Purok 3 Centro Balagbag, Cuenca, Batangas<br>
                Phone: (123) 456-7890 | Email: info@victoriasgarden.com
            </div>
            <div class="footer-social mb-3">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <div>
                <i class="far fa-copyright"></i> 2025 Victoria's Garden and Event Center. All rights reserved.
            </div>
        </div>
    </footer>
 
    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('settingsSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
 
        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            document.querySelector('.navbar').classList.toggle('dark-mode');
            document.querySelector('.hero-section').classList.toggle('dark-mode');
            document.querySelector('.hero-bg-img').classList.toggle('dark-mode');
            document.querySelector('.hero-overlay').classList.toggle('dark-mode');
            document.querySelector('.hero-content').classList.toggle('dark-mode');
            document.querySelectorAll('.section-title').forEach(el => el.classList.toggle('dark-mode'));
            document.querySelectorAll('.room-card').forEach(el => el.classList.toggle('dark-mode'));
            document.querySelectorAll('.amenity-box').forEach(el => el.classList.toggle('dark-mode'));
            document.querySelectorAll('.testimonial-card').forEach(el => el.classList.toggle('dark-mode'));
            document.querySelectorAll('.room-card-title').forEach(el => el.classList.toggle('dark-mode'));
            document.querySelectorAll('.btn-outline-primary').forEach(el => el.classList.toggle('dark-mode'));
            document.querySelector('footer').classList.toggle('dark-mode');
        }
 
        function changeLanguage(lang) {
            // Placeholder for language change logic
            alert(`Language changed to ${lang}`);
        }
 
        function toggleAccessibility() {
            // Placeholder for accessibility options
            alert('Accessibility options opened');
        }
 
        function startVirtualTour() {
            // Placeholder for virtual tour
            alert('Starting virtual tour');
        }
 
        function openLiveChat() {
            // Placeholder for live chat
            alert('Opening live chat');
        }
 
        function showNewsletterModal() {
            const modal = new bootstrap.Modal(document.getElementById('newsletterModal'));
            modal.show();
        }
 
        function submitNewsletter() {
            const email = document.getElementById('newsletterEmail').value;
            if (email) {
                alert('Subscribed successfully!');
                document.getElementById('newsletterForm').reset();
                bootstrap.Modal.getInstance(document.getElementById('newsletterModal')).hide();
            } else {
                alert('Please enter a valid email.');
            }
        }
 
        function validateForm(event) {
            event.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
 
            if (name && email && message) {
                alert('Message sent successfully!');
                document.getElementById('contactForm').reset();
            } else {
                alert('Please fill in all fields.');
            }
            return false;
        }
 
        function toggleDateFields() {
            var roomType = document.getElementById('roomType');
            var dateFields = document.getElementById('dateFields');
            if (!roomType || !dateFields) return;
            var value = roomType.value;
            // Hide date fields for daytour and nighttour, show otherwise
            if (value === 'daytour' || value === 'nighttour') {
                dateFields.style.display = 'none';
                // Remove required attribute if present
                document.getElementById('checkIn').required = false;
                document.getElementById('checkOut').required = false;
            } else {
                dateFields.style.display = '';
                document.getElementById('checkIn').required = true;
                document.getElementById('checkOut').required = true;
            }
        }
 
        function submitBooking() {
            var roomType = document.getElementById('roomType').value;
            var guests = document.getElementById('guests').value;
            var checkIn = document.getElementById('checkIn');
            var checkOut = document.getElementById('checkOut');
            // Only require dates for overnight/rooms
            if (roomType !== 'daytour' && roomType !== 'nighttour') {
                if (!checkIn.value || !checkOut.value || !guests || !roomType) {
                    Swal.fire('Error', 'Please fill in all fields.', 'error');
                    return;
                }
                // Date validation: check-in must be before check-out
                var inDate = new Date(checkIn.value);
                var outDate = new Date(checkOut.value);
                if (inDate >= outDate) {
                    Swal.fire('Invalid Dates', 'Check-in date must be before check-out date.', 'error');
                    return;
                }
            } else {
                if (!guests || !roomType) {
                    Swal.fire('Error', 'Please fill in all fields.', 'error');
                    return;
                }
            }
            Swal.fire({
                icon: 'success',
                title: 'Booking Submitted!',
                text: 'Your booking has been submitted successfully!',
                confirmButtonColor: '#ffd700'
            });
            document.getElementById('bookingForm').reset();
            bootstrap.Modal.getInstance(document.getElementById('bookingModal')).hide();
            toggleDateFields();
        }
 
        function setBookingType(type) {
            var roomType = document.getElementById('roomType');
            if (roomType) {
                let value = '';
                if (type === 'Day Tour') value = 'daytour';
                else if (type === 'Night Tour') value = 'nighttour';
                else if (type === 'Overnight Stay') value = 'overnightstay';
                else if (type === 'Exclusive Overnight') value = 'exclusiveovernight';
                // Optionally, you can add these as options if not present
                let found = false;
                for (let i = 0; i < roomType.options.length; i++) {
                    if (roomType.options[i].value === value) {
                        roomType.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found && value) {
                    let opt = document.createElement('option');
                    opt.value = value;
                    opt.text = type === 'Exclusive Overnight' ? 'Exclusive Overnight (All Rooms, up to 30 pax)' : type;
                    roomType.add(opt);
                    roomType.value = opt.value;
                }
                toggleDateFields();
            }
        }
 
        // Loading Spinner
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('loadingSpinner').classList.add('hide');
            }, 600);
        });
 
        // Back to Top Button
        const backToTopBtn = document.getElementById('backToTopBtn');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 200) {
                backToTopBtn.style.display = 'block';
            } else {
                backToTopBtn.style.display = 'none';
            }
        });
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
 
        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 60) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
 
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
 
        // Ensure correct fields are shown when modal opens
        document.addEventListener('DOMContentLoaded', function() {
            var bookingModal = document.getElementById('bookingModal');
            if (bookingModal) {
                bookingModal.addEventListener('show.bs.modal', function () {
                    toggleDateFields();
                });
            }
        });
    </script>
</body>
</html>