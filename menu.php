<?php
session_start();
$username = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Guest';
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
            <div class="d-flex align-items-center">
                <span class="me-3 fw-semibold">Hi, <?php echo htmlspecialchars($username); ?></span>
                <a href="logout.php" class="btn btn-primary">Logout</a>
            </div>
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
                        <?php for ($i = 1; $i <= 10; $i++)
                            echo "<option>$i</option>"; ?>
                    </select>
                </div>
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


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>