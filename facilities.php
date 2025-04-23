<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Facilities - Get Hotels</title>
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
            <li class="nav-item"><a class="nav-link active" href="facilities.php">Facilities</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact us</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        </ul>
        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-primary">Register</button>
    </div>
</nav>

<!-- Facilities Section -->
<div class="container my-5">
    <div class="text-center mb-4">
        <h2>Our Facilities</h2>
        <p class="lead">Enjoy a wide range of amenities during your stay</p>
    </div>

    <div class="row g-4">
        <?php
        $facilities = [
            ["icon" => "wifi", "name" => "Free Wi-Fi", "desc" => "High-speed internet access in all rooms and public areas."],
            ["icon" => "cup-straw", "name" => "Restaurant", "desc" => "Delicious cuisine from our in-house chefs."],
            ["icon" => "snow", "name" => "Air Conditioner", "desc" => "Comfortable cooling system for a relaxing stay."],
            ["icon" => "tv", "name" => "Flat-screen TV", "desc" => "Entertainment options with cable access."],
            ["icon" => "person-swimming", "name" => "Swimming Pool", "desc" => "Outdoor pool perfect for leisure and relaxation."],
            ["icon" => "car-front", "name" => "Free Parking", "desc" => "Spacious parking area for guests."],
            ["icon" => "dumbbell", "name" => "Gym", "desc" => "Stay fit with our well-equipped fitness center."],
            ["icon" => "door-closed", "name" => "Room Service", "desc" => "24/7 service to your room for your convenience."],
        ];

        foreach ($facilities as $f) {
            echo '<div class="col-md-3">';
            echo '<div class="card shadow-sm text-center p-4 h-100">';
            echo "<i class='bi bi-{$f['icon']} display-5 text-primary mb-3'></i>";
            echo "<h5>{$f['name']}</h5>";
            echo "<p class='text-muted'>{$f['desc']}</p>";
            echo '</div></div>';
        }
        ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
