<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT id_cust FROM cust WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$id_cust = $user['id_cust'];
$stmt->close();

// Proses submit review
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idkmr = $_POST['idkmr'];
    $nokmr = $_POST['nokmr'];
    $bintang = $_POST['bintang'];
    $komen = $_POST['komen'];

    $stmt = $conn->prepare("INSERT INTO review (idkmr, nokmr, id_cust, bintang, komen, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("isiss", $idkmr, $nokmr, $id_cust, $bintang, $komen);
    $stmt->execute();
    $stmt->close();

    // Redirect dengan query string
    header("Location: home.php?review=success");
    exit();
}



$stmt = $conn->prepare("
    SELECT k.idkmr, k.nokmr, k.tipe, k.harga, r.id_review
    FROM transaksi t
    JOIN kmr k ON t.nokmr = k.nokmr
    LEFT JOIN review r ON r.nokmr = k.nokmr AND r.id_cust = ?
    WHERE t.id_cust = ?
");
$stmt->bind_param("ii", $id_cust, $id_cust);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Review Kamar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .star {
            font-size: 2rem;
            color: gray;
            cursor: pointer;
        }

        .star.selected {
            color: gold;
        }
    </style>
</head>

<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center">Beri Review Kamar</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="row justify-content-center">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">

                            <h5 class="mb-3">Kamar: <?= htmlspecialchars($row['nokmr']) ?> - <?= htmlspecialchars($row['tipe']) ?></h5>
                            <p>Harga: Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>

                            <?php if (empty($row['id_review'])): ?>
                                <form method="POST" class="review-form">
                                    <input type="hidden" name="idkmr" value="<?= $row['idkmr'] ?>">
                                    <input type="hidden" name="nokmr" value="<?= $row['nokmr'] ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Bintang:</label><br>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star star" data-value="<?= $i ?>"></i>
                                        <?php endfor; ?>
                                        <input type="hidden" name="bintang" class="bintang-value" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Komentar:</label>
                                        <textarea name="komen" class="form-control" rows="3" required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-dark w-100">Kirim Review</button>
                                </form>
                            <?php else: ?>
                                <div class="alert alert-success mb-0">
                                    Review untuk kamar ini sudah dikirim.
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Belum ada transaksi yang bisa direview.</div>
    <?php endif; ?>
</div>

<script>
    document.querySelectorAll('.review-form').forEach(form => {
        const stars = form.querySelectorAll('.star');
        const bintangInput = form.querySelector('.bintang-value');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.dataset.value;
                bintangInput.value = value;

                stars.forEach(s => {
                    s.classList.toggle('selected', s.dataset.value <= value);
                });
            });
        });
    });
</script>

</body>
</html>
