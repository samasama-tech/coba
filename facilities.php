<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Facilities - Get Hotels</title>
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
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rooms.php">Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="facilities.php">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <span class="fw-bold me-2">Hi, <?= htmlspecialchars($_SESSION['nama']) ?></span>
                <a href="logout.php" class="btn btn-primary">Logout</a>
            <?php else: ?>
                <button class="btn btn-outline-primary me-2" data-bs-toggle="modal"
                    data-bs-target="#loginModal">Login</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
            <?php endif; ?>
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

    <!-- Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">
                        <i class="bi bi-box-arrow-in-right me-2"></i> User Login
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="login.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark w-100">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Register -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">
                        <i class="bi bi-person-plus me-2"></i> User Registration
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="register.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="cpassword" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark w-100">REGISTER</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>