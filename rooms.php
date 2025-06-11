<?php
session_start();
require('koneksi.php');
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$activePages = ['rooms'];

$username = $_SESSION['username'] ?? 'Guest';
$loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

// Ambil data kamar unik per tipe (ambil idkmr terkecil per tipe)
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
    <meta charset="UTF-8">
    <title>Rooms - Nexus Hotels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .custom-navbar {
            background-color: #ced4da;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .star-rating {
            color: #ffc107;
            margin-bottom: 10px;
        }

        .review-btn {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php' ?>

    <div class="container my-5">
        <h2 class="text-center mb-4">Our Rooms</h2>
        <div class="row g-4">
            <?php foreach ($rooms as $room): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="<?= $room['gambar'] ?>" class="card-img-top" alt="Room Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($room['tipe']) ?></h5>
                            <p class="card-text fw-bold">Rp. <?= number_format($room['harga'], 0, ',', '.') ?> per night</p>

                            <div class="star-rating">
                                <?php
                                $rating = $room['rating'];
                                $fullStars = floor($rating);
                                $hasHalfStar = ($rating - $fullStars) >= 0.5;

                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $fullStars) {
                                        echo '<i class="bi bi-star-fill"></i>';
                                    } elseif ($i == $fullStars + 1 && $hasHalfStar) {
                                        echo '<i class="bi bi-star-half"></i>';
                                    } else {
                                        echo '<i class="bi bi-star"></i>';
                                    }
                                }
                                ?>
                                <span class="text-muted ms-2"><?= number_format($rating, 1) ?></span>
                            </div>

                            <p><strong>Facilities:</strong> <?= htmlspecialchars($room['fasilitas']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.review-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('selectedRoom').value = this.getAttribute('data-room');
            });
        });
        document.querySelectorAll('.rating-star').forEach(star => {
            star.addEventListener('click', function () {
                const value = this.getAttribute('data-value');
                document.getElementById('ratingValue').value = value;
                document.querySelectorAll('.rating-star').forEach((s, index) => {
                    if (index < value) {
                        s.classList.remove('bi-star');
                        s.classList.add('bi-star-fill');
                    } else {
                        s.classList.remove('bi-star-fill');
                        s.classList.add('bi-star');
                    }
                });
            });
        });
    </script>
</body>

</html>