<?php
// Example data (usually fetched from a database)
$rooms = [
    [
        "title" => "Supreme Deluxe Room",
        "price" => 900,
        "features" => ["Bedroom", "Balcony", "Kitchen"],
        "facilities" => ["Wifi", "Air conditioner", "Room Heater", "Geyser"],
        "image" => "https://via.placeholder.com/400x200"
    ],
    [
        "title" => "Luxury Room",
        "price" => 600,
        "features" => ["Bedroom", "Balcony", "Kitchen"],
        "facilities" => ["Wifi", "Air conditioner", "Room Heater"],
        "image" => "https://via.placeholder.com/400x200"
    ],
    [
        "title" => "Deluxe Room",
        "price" => 500,
        "features" => ["Bedroom", "Balcony", "Kitchen"],
        "facilities" => ["Air conditioner", "Room Heater", "Geyser"],
        "image" => "https://via.placeholder.com/400x200"
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms - Get Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="rooms.php">Rooms</a></li>
            <li class="nav-item"><a class="nav-link" href="facilities.php">Facilities</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
        </ul>
        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
    </div>
</nav>

<!-- Rooms Section -->
<div class="container my-5">
    <h2 class="text-center mb-4">Our Rooms</h2>
    <div class="row g-4">
        <?php foreach ($rooms as $room) : ?>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img src="<?= $room['image'] ?>" class="card-img-top" alt="Room Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $room['title'] ?></h5>
                        <p class="card-text fw-bold">₹<?= $room['price'] ?> per night</p>
                        <p><strong>Features:</strong> <?= implode(", ", $room['features']) ?></p>
                        <p><strong>Facilities:</strong> <?= implode(", ", $room['facilities']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
