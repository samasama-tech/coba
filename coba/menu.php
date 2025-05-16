<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Get Hotels</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    .custom-navbar {
        background-color: #ced4da;
        /* Abu-abu terang agak gelap */
    }

    .nav-pills .nav-link {
        color: black;
    }

    .nav-pills .nav-link.active {
        background-color: #adb5bd;
        /* Abu-abu lebih gelap untuk tab aktif */
        color: black !important;
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar px-4">
        <a class="navbar-brand fw-bold" href="#">Get Hotels</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav nav-pills me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link  active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rooms.php">Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="facilities.php">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
            <!-- Perbaikan (BENAR) -->
            <a href="logot.php" class="btn btn-primary">Logout</a>

        </div>
    </nav>

    <!-- Booking Form -->
    <div class="container my-5">
        <div class="bg-light p-4 rounded shadow">
            <h4>Check Booking Availability</h4>
            <form action="search.php" method="POST" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Check-in</label>
                    <input type="date" name="checkin" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Check-out</label>
                    <input type="date" name="checkout" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kapasitas</label>
                    <select name="adults" class="form-select">
                        <?php for ($i = 1; $i <= 10; $i++) echo "<option>$i</option>"; ?>
                    </select>
                </div>
                <!-- Tambahkan di dalam <form> sebelum tombol Submit -->
                <div class="col-md-2">
                    <label class="form-label">Tipe Kamar</label>
                    <select name="tipe_kamar" class="form-select" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Supreme deluxe room">Supreme Deluxe Room</option>
                        <option value="Luxury Room">Luxury Room</option>
                        <option value="Deluxe Room">Deluxe Room</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="kamar.php" class="btn btn-success w-100">Submit</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Rooms Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Our Rooms</h2>
        <div class="row g-4">
            <?php
        $rooms = [
            ["title" => "Supreme deluxe room", "price" => 900, "features" => ["bedroom", "balcony", "kitchen"], "facilities" => ["Wifi", "Air conditioner", "Room Heater", "Geyser"]],
            ["title" => "Luxury Room", "price" => 600, "features" => ["bedroom", "balcony", "kitchen"], "facilities" => ["Wifi", "Air conditioner", "Room Heater"]],
            ["title" => "Deluxe Room", "price" => 500, "features" => ["bedroom", "balcony", "kitchen"], "facilities" => ["Air conditioner", "Room Heater", "Geyser"]],
        ];

        foreach ($rooms as $room) {
            echo '<div class="col-md-4">';
            echo '<div class="card shadow-sm h-100">';
            echo '<img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Room Image">';
            echo '<div class="card-body">';
            echo "<h5 class='card-title'>{$room['title']}</h5>";
            echo "<p class='card-text fw-bold'>₹{$room['price']} per night</p>";
            echo "<p><strong>Features:</strong> " . implode(", ", $room['features']) . "</p>";
            echo "<p><strong>Facilities:</strong> " . implode(", ", $room['facilities']) . "</p>";
            echo '</div></div></div>';
        }
        ?>
        </div>
    </div>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>