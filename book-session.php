<?php
session_start();
$isLoggedIn = isset($_SESSION["user_id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Session</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Ensure this matches your signup page styling -->
</head>
<body class="d-flex flex-column min-vh-100">

<header class="bg-dark text-white text-center py-3">
    <h1 class="fw-bold">Seven Flicks Photography</h1>
</header>

<!-- Navigation Bar (unchanged) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="home.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="services.html">Services</a></li>
                <li class="nav-item"><a class="nav-link active" href="book-session.html">Book a Session</a></li>
                <li class="nav-item"><a class="nav-link" href="quote.html">Get a Quote</a></li>
                <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="partner.html">Our Partners</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Booking Section -->
<section class="d-flex flex-grow-1 justify-content-center align-items-center">
    <div class="card p-4 shadow-lg rounded w-50">
        <h2 class="text-center mb-4">Book a Session</h2>

        <?php if ($isLoggedIn): ?>
            <form action="submit_booking.php" method="POST" class="needs-validation" id="booking-form" novalidate>

                <div class="form-floating mb-3">
                    <input type="text" id="name" name="name" class="form-control" required placeholder="Name">
                    <label for="name">Your Name</label>
                    <div class="invalid-feedback">Please enter your name.</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="tel" id="phone" name="phone" class="form-control" required placeholder="Phone Number">
                    <label for="phone">Phone Number</label>
                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" id="email" name="email" class="form-control" required placeholder="Email">
                    <label for="email">Your Email</label>
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>

                <div class="form-floating mb-3">
                    <select id="event" name="event" class="form-select" required>
                        <option value="photography">Photography</option>
                        <option value="videography">Videography</option>
                        <option value="catering">Catering</option>
                        <option value="event_planning">Event Planning</option>
                        <option value="venue_booking">Venue Booking</option>
                    </select>
                    <label for="event">Event Type</label>
                    <div class="invalid-feedback">Please select an event type.</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="date" id="date" name="date" class="form-control" required>
                    <label for="date">Event Date</label>
                    <div class="invalid-feedback">Please select a valid date.</div>
                </div>

                <div class="form-floating mb-3">
                    <select id="service" name="service" class="form-select" required>
                        <option value="photography">Photography</option>
                        <option value="videography">Videography</option>
                        <option value="catering">Catering</option>
                        <option value="event_planning">Event Planning</option>
                        <option value="venue_booking">Venue Booking</option>
                    </select>
                    <label for="service">Types of Service</label>
                    <div class="invalid-feedback">Please select a service type.</div>
                </div>

                <div class="form-floating mb-3">
                    <select id="style" name="style" class="form-select" required>
                        <option value="traditional">Traditional</option>
                        <option value="modern">Modern</option>
                        <option value="vintage">Vintage</option>
                    </select>
                    <label for="style">Preferred Style</label>
                    <div class="invalid-feedback">Please select a style.</div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Book Now</button>
            </form>
        <?php else: ?>
            <div class="text-center">
                <p class="text-danger">You must <a href="login.html" class="text-decoration-none">log in</a> to book a session.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Footer (unchanged) -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <p class="mb-0">&copy; 2025 Seven Flicks Photography. All rights reserved.</p>
</footer>

<script>
    // Prevent selecting past dates
    document.addEventListener("DOMContentLoaded", function () {
        const dateInput = document.getElementById("date");
        if (dateInput) {
            let today = new Date().toISOString().split("T")[0];
            dateInput.setAttribute("min", today);
        }
    });

    // Form validation with Bootstrap styling
    document.getElementById("booking-form")?.addEventListener("submit", function (e) {
        e.preventDefault();
        if (!this.checkValidity()) {
            this.classList.add("was-validated");
            return;
        }
        this.submit();
    });
</script>

</body>
</html>
