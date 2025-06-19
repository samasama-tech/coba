<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$activePages = ['facilities'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facilities - Nexus Hotels</title>
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

    <?php include 'navbar.php'
        ?>

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
                ["icon" => "cup-hot", "name" => "Restaurant", "desc" => "Delicious cuisine from our in-house chefs."],
                ["icon" => "snow", "name" => "Air Conditioner", "desc" => "Comfortable cooling system for a relaxing stay."],
                ["icon" => "tv", "name" => "Flat-screen TV", "desc" => "Entertainment options with cable access."],
                ["icon" => "water", "name" => "Swimming Pool", "desc" => "Outdoor pool perfect for leisure and relaxation."],
                ["icon" => "car-front-fill", "name" => "Free Parking", "desc" => "Spacious parking area for guests."],
                ["icon" => "activity", "name" => "Gym", "desc" => "Stay fit with our well-equipped fitness center."],
                ["icon" => "bell-fill", "name" => "Room Service", "desc" => "24/7 service to your room for your convenience."],
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

    <footer class="bg-light text-center text-lg-start border-top mt-5">
        <div class="container py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <p class="mb-2 mb-md-0 text-muted">&copy; <?= date("Y") ?> <strong>Nexus Hotels</strong>. All rights
                reserved.</p>

            <div class="d-flex align-items-center">
                <a class="text-muted me-4 text-decoration-none fw-medium">Hubungi Kami</a>
                <a href="https://www.instagram.com/nexushotel" class="text-danger me-3"><i
                        class="bi bi-instagram fs-5"></i></a>
                <a href="https://wa.me/" class="text-success me-3"><i class="bi bi-whatsapp fs-5"></i></a>
                <a href="https://web.facebook.com/share/p/1BM9sLY2A2/" class="text-primary"><i class="bi bi-facebook fs-5"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>