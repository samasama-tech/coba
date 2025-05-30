<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$activePages = ['rooms'];
$rooms = [
    [
        "title" => "Deluxe Room",
        "price" => 600000, // Hapus titik dan ubah ke integer
        "features" => ["Double Bed", "Balcony", "Kitchen"],
        "facilities" => ["Wifi, Ac, Luas 28m²"],
        "image" => "img/double.png"
    ],
    [
        "title" => "Suite Room",
        "price" => 500000, // Hapus titik dan ubah ke integer
        "features" => ["Twin Bed", "Balcony", "Kitchen"],
        "facilities" => ["Wifi, Ac, Luas 20m²"],
        "image" => "img/twin.png"
    ],
    [
        "title" => "Executive Room",
        "price" => 700000, // Hapus titik dan ubah ke integer
        "features" => ["King Bed", "Balcony", "Kitchen"],
        "facilities" => ["Wifi, Ac, Luas 35m²"],
        "image" => "img/king.png"
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rooms - Nexus Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    </style>
</head>

<body>

    <?php include 'navbar.php' ?>

    <!-- Rooms Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Our Rooms</h2>
        <div class="row g-4">
            <?php foreach ($rooms as $room): ?>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img src="<?= $room['image'] ?>" class="card-img-top" alt="Room Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $room['title'] ?></h5>
                        <p class="card-text fw-bold">Rp. <?= number_format($room['price'], 0, ',', '.') ?> per night</p>
                        <p><strong>Features:</strong> <?= implode(", ", $room['features']) ?></p>
                        <p><strong>Facilities:</strong> <?= implode(", ", $room['facilities']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
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

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>