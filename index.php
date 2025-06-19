<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$activePages = ['home'];
require('koneksi.php');

$query = "SELECT MIN(idkmr) as idkmr, tipe, fasilitas FROM kmr GROUP BY tipe";
$result = $conn->query($query);
$rooms = [];
while ($row = $result->fetch_assoc()) {
    $idkmr = $row['idkmr'];
    $tipe = $row['tipe'];

    // Hitung average rating per tipe
    $stmt = $conn->prepare("SELECT AVG(bintang) as avg_rating FROM review r JOIN kmr k ON r.idkmr = k.idkmr WHERE k.tipe = ?");
    $stmt->bind_param("s", $tipe);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $rating = $res['avg_rating'] ?? 0;
    $stmt->close();

    // Harga per tipe
    $harga = 0;
    if ($tipe == 'Deluxe Room')
        $harga = 600000;
    elseif ($tipe == 'Suite Room')
        $harga = 500000;
    elseif ($tipe == 'Executive Room')
        $harga = 700000;

    // Gambar sesuai tipe
    $gambar = "";
    if ($tipe == 'Deluxe Room')
        $gambar = "img/double.png";
    elseif ($tipe == 'Suite Room')
        $gambar = "img/twin.png";
    elseif ($tipe == 'Executive Room')
        $gambar = "img/king.png";

    $rooms[] = [
        'idkmr' => $idkmr,
        'tipe' => $tipe,
        'harga' => $harga,
        'fasilitas' => $row['fasilitas'],
        'rating' => $rating,
        'gambar' => $gambar
    ];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nexus Hotels</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel='shortcut icon' href="img/favicon.ico" type="image/x-icon">

</head>

<body>
    <!-- alert review -->
    <?php if (isset($_SESSION['flash_review'])): ?>
        <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3"
            role="alert" style="z-index: 9999;">
            Review berhasil dikirim!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <script>
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                }
            }, 2000);
        </script>
        <?php unset($_SESSION['flash_review']); ?>
    <?php endif; ?>


    <?php include 'navbar.php'
        ?>

    <!-- Booking Form -->
    <div class="container my-4">
        <div class="bg-light p-4 rounded shadow">
            <h4>Check Booking Availability</h4>
            <form action="kamar.php" id="bookingForm" method="POST"
                class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-3">
                <div class="col">
                    <label class="form-label">Check-in</label>
                    <input type="date" name="ci" id="ci" class="form-control" required>
                </div>
                <div class="col">
                    <label class="form-label">Check-out</label>
                    <input type="date" name="co" id="co" class="form-control" required>
                </div>
                <div class="col">
                    <label class="form-label">Kapasitas</label>
                    <select name="kap" class="form-select">
                        <?php for ($i = 1; $i <= 2; $i++)
                            echo "<option>$i</option>"; ?>
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">Tipe Kamar</label>
                    <select name="tipe" class="form-select" required>
                        <option value="">Pilih Tipe</option>
                        <option value="Deluxe Room">Deluxe Room</option>
                        <option value="Suite Room">Suite Room</option>
                        <option value="Executive Room">Executive Room</option>
                    </select>
                </div>
                <div class="col d-flex align-items-end">
                    <button type="submit" id="bookingSubmit" class="btn btn-success w-100">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <section class="container my-4">
        <div class="row">
            <!-- Kamar&review -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0 text-center">Rekomendasi Kamar & Review</h4>
                    </div>
                    <div class="card-body">
                        <!-- Carousel Kamar -->
                        <div id="carouselKamar" data-bs-interval="3000" data-bs-ride="carousel" class=" carousel slide
                            mb-4" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($rooms as $index => $room): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <div class="card border-0">
                                            <img src="<?= $room['gambar'] ?>" class="d-block w-100 rounded"
                                                style="height: 200px; object-fit: cover;" alt="...">
                                            <div class="mt-2 text-center">
                                                <h6 class="mb-1"><?= htmlspecialchars($room['tipe']) ?></h6>
                                                <p class="mb-1 fw-bold text-success">Rp
                                                    <?= number_format($room['harga'], 0, ',', '.') ?>/malam
                                                </p>
                                                <div class="text-warning">
                                                    <?php
                                                    $rating = $room['rating'];
                                                    $full = floor($rating);
                                                    $half = ($rating - $full) >= 0.5;
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        if ($i <= $full)
                                                            echo '<i class="bi bi-star-fill"></i>';
                                                        elseif ($i == $full + 1 && $half)
                                                            echo '<i class="bi bi-star-half"></i>';
                                                        else
                                                            echo '<i class="bi bi-star"></i>';
                                                    }
                                                    ?>
                                                    <span
                                                        class="text-muted ms-1 small"><?= number_format($room['rating'], 1) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselKamar"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselKamar"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>

                        <!-- Review Pengunjung -->
                        <div class="text-start">
                            <h6 class="fw-bold mb-2">Review Terbaru:</h6>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <?php
                                $res = $conn->query("
                                        SELECT r.komen, r.bintang, c.username, k.tipe
                                        FROM review r 
                                        JOIN cust c ON r.id_cust = c.id_cust 
                                        JOIN kmr k ON r.idkmr = k.idkmr
                                        ORDER BY r.created_at DESC 
                                        LIMIT 5
                                    ");
                                while ($row = $res->fetch_assoc()):
                                    ?>
                                    <div class="mb-3 border-bottom pb-2">
                                        <div class="fw-semibold">
                                            <?= htmlspecialchars($row['username']) ?>
                                            <span class="text-muted small">• <?= htmlspecialchars($row['tipe']) ?></span>
                                        </div>

                                        <div class="text-warning small">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo $i <= $row['bintang'] ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>';
                                            }
                                            ?>
                                        </div>
                                        <div class="text-muted small"><?= htmlspecialchars($row['komen']) ?></div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Lokasi -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0 text-center">Lokasi Kami</h4>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Lokasi -->
                        <div class="mb-3">
                            <h5 class="fw-bold">AYANA Resort Bali</h5>
                            <p class="mb-1">
                                <i class="bi bi-geo-alt-fill text-primary"></i>
                                Jl. Karang Mas Sejahtera, Jimbaran, Kuta Sel., Kabupaten Badung, Bali
                            </p>
                            <p class="mb-3">
                                <i class="bi bi-star-fill text-warning"></i> 4,7 (9.799 review)
                            </p>
                        </div>

                        <!-- Map -->
                        <div class="map-container mb-3"
                            style="height: 300px; width: 100%; border-radius: 8px; overflow: hidden;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.992047245303!2d115.1374700501162!3d-8.786816156588177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2448af6f410a5%3A0x313ee67691a146ca!2sAYANA%20Resort%20Bali!5e0!3m2!1sid!2sid!4v1748408708735!5m2!1sid!2sid"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                        <!-- Fasilitas Terdekat -->
                        <div>
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