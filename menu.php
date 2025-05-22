<?php
session_start();
$username = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Guest';
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
?>


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
        }

        .nav-pills .nav-link {
            color: black;
        }

        .nav-pills .nav-link.active {
            background-color: #adb5bd;
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
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <span class="fw-bold me-2">Hi, <?= htmlspecialchars($username) ?></span>
                <a href="logout.php" class="btn btn-primary">Logout</a>
            <?php else: ?>
                <button class="btn btn-outline-primary me-2" data-bs-toggle="modal"
                    data-bs-target="#loginModal">Login</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Booking Form -->
    <div class="container my-5">
        <div class="bg-light p-4 rounded shadow">
            <h4>Check Booking Availability</h4>
            <form action="kamar.php" method="POST" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Check-in</label>
                    <input type="date" name="ci" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Check-out</label>
                    <input type="date" name="co" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kapasitas</label>
                    <select name="kap" class="form-select">
                        <?php for ($i = 1; $i <= 10; $i++)
                            echo "<option>$i</option>"; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tipe Kamar</label>
                    <select name="tipe" class="form-select" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Deluxe Room">Deluxe Room</option>
                        <option value="Luxury Room">Luxury Room</option>
                        <option value="Supreme deluxe room">Supreme Deluxe Room</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" id="bookingSubmit" class="btn btn-success w-100">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lokasi -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Lokasi Kami</h2>
            <div class="ratio ratio-16x9 shadow-sm rounded">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1178.8201746556047!2d106.82556891102848!3d-6.385918137982336!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69eb6817164f0f%3A0x56bc7452dcaac286!2sApartemen%20Mares!5e0!3m2!1sid!2sid!4v1747631028110!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
            <p class="text-center mt-3">Terletak di pusat kota dengan akses mudah ke berbagai tempat menarik.</p>
        </div>
    </section>

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


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const isLoggedIn = <?= (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) ? 'true' : 'false' ?>;

        document.getElementById('bookingSubmit').addEventListener('click', function (event) {
            if (!isLoggedIn) {
                event.preventDefault(); // batalkan submit
                alert('Anda harus login terlebih dahulu untuk melakukan booking.');
            }
        });
    </script>


</body>

</html>