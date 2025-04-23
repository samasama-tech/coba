<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - Get Hotels</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
    <a class="navbar-brand fw-bold" href="#">Get Hotels</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
            <li class="nav-item"><a class="nav-link" href="facilities.php">Facilities</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact us</a></li>
            <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
        </ul>
        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-primary">Register</button>
    </div>
</nav>

<!-- About Content -->
<div class="container my-5">
    <div class="text-center mb-4">
        <h2>About Get Hotels</h2>
        <p class="lead">Your comfort is our priority</p>
    </div>

    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="https://via.placeholder.com/600x400" class="img-fluid rounded shadow" alt="Hotel Image">
        </div>
        <div class="col-md-6">
            <h4>Who We Are</h4>
            <p>
                Get Hotels is a premier hotel booking platform committed to offering the best accommodation options at the most affordable prices. 
                With a wide range of rooms, state-of-the-art facilities, and top-notch customer service, we ensure your stay is as comfortable as your home.
            </p>

            <h5 class="mt-4">Our Vision</h5>
            <p>To be the most trusted hospitality partner for travelers worldwide.</p>

            <h5 class="mt-4">Our Mission</h5>
            <ul>
                <li>Provide high-quality accommodations at competitive rates</li>
                <li>Ensure excellent guest experiences</li>
                <li>Continuously innovate in hospitality services</li>
            </ul>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
