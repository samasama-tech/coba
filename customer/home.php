<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$activePages = ['home'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nexus Hotels</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel='shortcut icon' href="img/favicon.ico" type="image/x-icon">

</head>

<body>

    <?php include 'navbar.php'
        ?>

    <!-- Booking Form -->
    <div class="container my-5">
        <div class="bg-light p-4 rounded shadow">
            <h4>Check Booking Availability</h4>
            <form action="kamar.php" id="bookingForm" method="POST" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Check-in</label>
                    <input type="date" name="ci" id="ci" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Check-out</label>
                    <input type="date" name="co" id="co" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kapasitas</label>
                    <select name="kap" class="form-select">
                        <?php for ($i = 1; $i <= 2; $i++)
                            echo "<option>$i</option>"; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tipe Kamar</label>
                    <select name="tipe" class="form-select" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Deluxe Room">Deluxe Room</option>
                        <option value="Suite Room">Suite Room</option>
                        <option value="Executive Room">Executive Room</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" id="bookingSubmit" class="btn btn-success w-100">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!--Lokasi Kami-->
    <section class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0 text-center">Lokasi Kami</h3>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Lokasi -->
                        <div class="mb-4">
                            <h5 class="fw-bold">AYANA Resort Bali</h5>
                            <p class="mb-1">
                                <i class="bi bi-geo-alt-fill text-primary"></i>
                                Jl. Karang Mas Sejahtera, Jimbaran, Kuta Sel., Kabupaten Badung, Bali
                            </p>
                            <p class="mb-3">
                                <i class="bi bi-star-fill text-warning"></i> 4,7 (9.799 review)
                            </p>
                        </div>

                        <!-- Map Container yang Diperbaiki -->
                        <div class="map-container" style="height: 300px; border-radius: 8px; overflow: hidden;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.992047245303!2d115.1374700501162!3d-8.786816156588177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2448af6f410a5%3A0x313ee67691a146ca!2sAYANA%20Resort%20Bali!5e0!3m2!1sid!2sid!4v1748408708735!5m2!1sid!2sid"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                        <!-- Fasilitas Terdekat -->
                        <div class="mt-4">
                            <h6 class="fw-bold">Fasilitas Terdekat:</h6>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-building text-primary me-2"></i> AYANA Segara Bali</li>
                                <li><i class="bi bi-house text-primary me-2"></i> AYANA Villas Bali</li>
                                <li><i class="bi bi-utensils text-primary me-2"></i> PURI BHAGAWAN Lounge & Seafood
                                    Restaurant</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const isLoggedIn = <?= (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) ? 'true' : 'false' ?>;

        document.getElementById('bookingForm').addEventListener('submit', function (event) {
            if (!isLoggedIn) {
                event.preventDefault();
                const alertLoginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                alertLoginModal.show();
                return;
            }

            const ci = document.getElementById('ci').value;
            const co = document.getElementById('co').value;

            if (ci === '' || co === '') {
                return;
            }

            if (ci > co) {
                event.preventDefault();
                alert('Tanggal check-out harus lebih besar dari tanggal check-in!');
            }
        });
    </script>


</body>

</html>