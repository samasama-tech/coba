<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About Us - Get Hotels</title>
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
                    <a class="nav-link" href="facilities.php">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="about.php">About</a>
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

    <!-- About Content -->
    <div class="container my-5">
        <div class="text-center mb-4">
            <h2>About Get Hotels</h2>
            <p class="lead">Your comfort is our priority</p>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="img/hotel.jpg" class="img-fluid rounded shadow" alt="Hotel Image">
            </div>
            <div class="col-md-6">
                <h4>Who We Are</h4>
                <p>
                    Get Hotels is a premier hotel booking platform committed to offering the best accommodation options
                    at the most affordable prices.
                    With a wide range of rooms, state-of-the-art facilities, and top-notch customer service, we ensure
                    your stay is as comfortable as your home.
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

    <!-- About contact -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Connect With Us</h2>
        <div class="row justify-content-center text-center">
            <div class="col-md-6">
                <p class="mb-4">Follow us on our social media for the latest updates and offers:</p>
                <div class="d-flex justify-content-center gap-4 fs-3">
                    <a href="https://facebook.com/aljiba.fatur" class="text-primary" target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://instagram.com/decofra_s" class="text-danger" target="_blank">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://twitter.com/nekopoi" class="text-info" target="_blank">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="https://wa.me/" class="text-success" target="_blank">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="mailto:qpp439@gmail.com" class="text-dark" target="_blank">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </div>
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
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
            aria-hidden="true">
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