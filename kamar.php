<?php
session_start();
require('koneksi.php');

$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
$username = $_SESSION['username'] ?? 'Guest';
$displayName = $_SESSION['nama'] ?? $username;
$loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

$tipe = "";
$kap = "";
$ci = "";
$co = "";
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipe = $_POST['tipe'] ?? '';
    $kap = $_POST['kap'] ?? '';
    $ci = $_POST['ci'] ?? '';
    $co = $_POST['co'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM kmr WHERE tipe = ? AND kap >= ?");
    $stmt->bind_param("si", $tipe, $kap);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        echo "Query error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Get Hotels - Room Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    .btn-booking {
        white-space: nowrap;
    }
    </style>
    <link rel="shortcut icon" href="img/icon.ico" type="image/x-icon">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <div class="search-results-container mb-5" style="margin-left: 30px;">
        <h4 class="mb-4">Hasil Pencarian</h4>

        <div class="search-details mb-4">
            <p><strong>Tipe Kamar:</strong> <?= htmlspecialchars($tipe ?: '-') ?></p>
            <p><strong>Kapasitas:</strong> <?= htmlspecialchars($kap ?: '-') ?> orang</p>
            <p><strong>Check-in:</strong> <?= $ci ? date('d F Y', strtotime($ci)) : '-' ?></p>
            <p><strong>Check-out:</strong> <?= $co ? date('d F Y', strtotime($co)) : '-' ?></p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" style="width: 95%;">
                <thead class="table-light">
                    <tr>
                        <th>No Kamar</th>
                        <th>Tipe</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th>Harga</th>
                        <th>Pesan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                    <?php
                            // Hitung jumlah malam
                            $checkin_date = new DateTime($ci);
                            $checkout_date = new DateTime($co);
                            $interval = $checkin_date->diff($checkout_date);
                            $nights = $interval->days;

                            while ($row = $result->fetch_assoc()):
                                $harga = 0;
                                if ($row['tipe'] == 'Deluxe Room') {
                                    $harga = 600000;
                                } elseif ($row['tipe'] == 'Suite Room') {
                                    $harga = 500000;
                                } elseif ($row['tipe'] == 'Executive Room') {
                                    $harga = 700000;
                                }

                                $total_harga = $harga * $nights;
                                ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nokmr']) ?></td>
                        <td><?= htmlspecialchars($row['tipe']) ?></td>
                        <td><?= htmlspecialchars($row['fasilitas']) ?></td>
                        <td>
                            <span class="badge <?= $row['status'] == 'Kosong' ? 'bg-success' : 'bg-danger' ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            Rp <?= number_format($harga, 0, ',', '.') ?> / malam
                            <br><small class="text-muted">Total: Rp <?= number_format($total_harga, 0, ',', '.') ?>
                                (<?= $nights ?> malam)</small>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Kosong'): ?>
                            <?php if ($loggedIn): ?>
                            <a href="transaksi.php?room=<?= $row['nokmr'] ?>&tipe=<?= urlencode($row['tipe']) ?>&ci=<?= $ci ?>&co=<?= $co ?>&price=<?= $harga ?>&total=<?= $total_harga ?>"
                                class="btn btn-success btn-sm btn-booking w-100">
                                Pesan Sekarang
                            </a>
                            <?php else: ?>
                            <button class="btn btn-warning btn-sm btn-booking w-100" data-bs-toggle="modal"
                                data-bs-target="#loginModal">
                                Login untuk Pesan
                            </button>
                            <?php endif; ?>
                            <?php else: ?>
                            <button class="btn btn-secondary btn-sm btn-booking w-100" disabled>
                                Tidak Tersedia
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php elseif ($result): ?>
                    <tr>
                        <td colspan="6" class="text-center py-3">Tidak ada kamar tersedia sesuai pencarian Anda.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>