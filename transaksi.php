<?php
session_start();
require('koneksi.php');

$username = $_SESSION['username'] ?? 'Guest';
$displayName = $_SESSION['nama'] ?? $username;
$loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

// Ambil data dari URL
$room = $_GET['room'] ?? '';
$tipe = $_GET['tipe'] ?? '';
$ci = $_GET['ci'] ?? '';
$co = $_GET['co'] ?? '';
$total_harga = $_GET['total'] ?? 0;


// Validasi dasar
if (empty($room) || empty($tipe) || empty($ci) || empty($co) || empty($total_harga)) {
    echo "Data tidak lengkap.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Transaksi Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="img/icon.ico" type="image/x-icon" />
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h3>Detail Pemesanan</h3>
        <div class="card p-4 mb-4">
            <p><strong>No. Kamar:</strong> <?= htmlspecialchars($room) ?></p>
            <p><strong>Tipe Kamar:</strong> <?= htmlspecialchars($tipe) ?></p>
            <p class="mb-1">
                <strong>Check-in:</strong>
                <span style="margin-left: 10px;">
                    <?= $ci ? date('d F Y', strtotime($ci)) : '-' ?>
                </span>
            </p>
            <p class="mb-1">
                <strong>Check-out:</strong>
                <span style="margin-left: 10px;">
                    <?= $co ? date('d F Y', strtotime($co)) : '-' ?>
                </span>
            </p>
            <p><strong>Total Harga:</strong> Rp <?= number_format($total_harga, 0, ',', '.') ?></p>
        </div>

        <h5>Pilih Metode Pembayaran</h5>
        <form action="proses_transaksi.php" method="POST">
            <input type="hidden" name="room" value="<?= htmlspecialchars($room) ?>" />
            <input type="hidden" name="tipe" value="<?= htmlspecialchars($tipe) ?>" />
            <input type="hidden" name="ci" value="<?= htmlspecialchars($ci) ?>" />
            <input type="hidden" name="co" value="<?= htmlspecialchars($co) ?>" />
            <input type="hidden" name="total" value="<?= htmlspecialchars($total_harga) ?>" />

            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Pilih Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                    <optgroup label="QRIS">
                        <option value="qris_dana">Dana</option>
                        <!-- <option value="qris_shopeepay">ShopeePay</option>
                        <option value="qris_gopay">Gopay</option> -->
                    </optgroup>
                    <optgroup label="Virtual Account">
                        <option value="#">Coming Soon</option>
                        <!-- <option value="va_bni">BNI</option>
                        <option value="va_mandiri">Mandiri</option> -->
                    </optgroup>
                    <optgroup label="Convenience Store">
                        <option value="#">Coming Soon</option>
                        <!-- <option value="cs_indomaret">Indomaret</option> -->
                    </optgroup>
                    <optgroup label="Transfer Bank">
                        <option value="#">Coming Soon</option>
                        <!-- <option value="bank_seabank">Transfer ke SeaBank</option>
                        <option value="bank_bni">Transfer ke BNI</option>
                        <option value="bank_bri">Transfer ke BRI</option> -->
                    </optgroup>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Lanjutkan Pembayaran</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>

        </form>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>