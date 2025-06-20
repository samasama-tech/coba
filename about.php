<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$activePages = ['about'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Nexus Hotels</title>
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

    <!-- About Content -->
    <div class="container my-5">
        <div class="text-center mb-4">
            <h2>About Nexus Hotels</h2>
            <p class="lead">Your comfort is our priority</p>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="img/hotel.png" class="img-fluid rounded shadow" alt="Hotel Image">
            </div>
            <div class="col-md-6">
                <h4>Who We Are</h4>
                <p>
                    Nexus Hotels is a premier hotel booking platform committed to offering the best accommodation
                    options
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
                    <a href="https://web.facebook.com/share/p/1BM9sLY2A2/" class="text-primary" target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/nexushotel" class="text-danger" target="_blank">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://twitter.com/nexushotel" class="text-info" target="_blank">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="https://wa.me/" class="text-success" target="_blank">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="#" class="text-dark" target="_blank">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-lg-start border-top mt-5" style="background: #41c1ba;">
        <div class="container py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <p class="mb-2 mb-md-0 text-muted">&copy; <?= date("Y") ?> <strong>Nexus Hotels</strong>. All rights
                reserved.</p>
            <img src="img/favicon.ico" alt="Nexus Hotels Logo" class="img-fluid ms-md-3"
                style="width: 40px; height: 40px;">
        </div>
        </div>
    </footer>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>