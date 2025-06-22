<?php
session_start();
require('koneksi.php');

// Validasi data POST
if (!isset($_POST['room'], $_POST['tipe'], $_POST['ci'], $_POST['co'], $_POST['harga_permalam'], $_POST['total'], $_POST['metode_pembayaran'])) {
    die("Data tidak lengkap.");
}

// Cek apakah user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Ambil data user berdasarkan email dari session
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT id_cust, no_hp FROM cust WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$id_cust = $user['id_cust'];
$no_hp = $user['no_hp'];
$stmt->close();

// Ambil data dari POST
$room = $_POST['room'];
$tipe = $_POST['tipe'];
$ci = $_POST['ci'];
$co = $_POST['co'];
$harga_permalam = (int)$_POST['harga_permalam'];
$total = (int)$_POST['total'];
$metode = $_POST['metode_pembayaran'];

// Simpan transaksi ke database
$stmt = $conn->prepare("INSERT INTO transaksi (nokmr, no_hp, harga, total, id_cust, tipe, check_in, check_out) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiiisss", $room, $no_hp, $harga_permalam, $total, $id_cust, $tipe, $ci, $co);
$stmt->execute();
$stmt->close();

// Update status kamar
$stmt = $conn->prepare("UPDATE kmr SET status = 'Terisi' WHERE nokmr = ?");
$stmt->bind_param("s", $room);
$stmt->execute();
$stmt->close();

// Simpan data pembayaran ke session
$_SESSION['payment_data'] = [
    'room' => htmlspecialchars($room),
    'tipe' => htmlspecialchars($tipe),
    'ci' => $ci,
    'co' => $co,
    'harga' => $harga_permalam,
    'total' => $total,
    'metode' => htmlspecialchars($metode)
];

// Mapping metode pembayaran
$metodeLabels = [
    'qris_shopeepay' => 'ShopeePay (QRIS)',
    'qris_dana' => 'Dana (QRIS)',
    'qris_gopay' => 'Gopay (QRIS)',
];

$metodeLabel = $metodeLabels[$metode] ?? 'Metode tidak dikenal';

// QR Code berdasarkan metode
switch ($metode) {
    case 'qris_dana':
        $isi_qr = "https://link.dana.id/minta?full_url=https://qr.dana.id/v1/281012012022050100222768";
        break;
    case 'qris_shopeepay':
    case 'qris_gopay':
    default:
        $isi_qr = "soon";
        break;
}

$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($isi_qr);

// Buat kode pembayaran unik
$kodePembayaran = strtoupper(bin2hex(random_bytes(5)));
?>

<!-- Tampilan HTML -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .payment-card {
            max-width: 600px;
            margin: 0 auto;
        }
        .qr-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <div class="card payment-card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Instruksi Pembayaran</h4>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                <h5 class="<?= str_starts_with($metode, 'qris_') ? 'text-success' : 'text-primary' ?>">
                    <i class="bi bi-qr-code-scan"></i> Pembayaran <?= $metodeLabel ?>
                </h5>
            </div>

            <div class="text-center">
                <div class="qr-container mb-3">
                    <img src="<?= $qrCodeUrl ?>" alt="QR Pembayaran" class="img-fluid">
                </div>
                <p class="text-muted">Scan QR code di atas untuk melakukan pembayaran</p>
            </div>

            <div class="payment-details mt-4">
                <h5>Detail Pembayaran</h5>
                <table class="table table-bordered">
                    <tr><th>No. Kamar</th><td><?= $room ?></td></tr>
                    <tr><th>Tipe Kamar</th><td><?= $tipe ?></td></tr>
                    <tr><th>Harga per Malam</th><td>Rp <?= number_format($harga_permalam, 0, ',', '.') ?></td></tr>
                    <tr><th>Check-in</th><td><?= date('d F Y', strtotime($ci)) ?></td></tr>
                    <tr><th>Check-out</th><td><?= date('d F Y', strtotime($co)) ?></td></tr>
                    <tr><th>Total Pembayaran</th><td class="fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></td></tr>
                    <tr><th>Kode Pembayaran</th><td class="text-danger fw-bold"><?= $kodePembayaran ?></td></tr>
                </table>
            </div>
        </div>
        <div class="card-footer text-center d-flex justify-content-between">
            <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
            <div>
                <button onclick="window.print()" class="btn btn-secondary me-2"><i class="bi bi-printer"></i> Cetak QR</button>
                <a href="struk.php" class="btn btn-success"><i class="bi bi-file-earmark-text"></i> Cetak Struk</a>
            </div>
        </div>
    </div>
</div>

<footer class="bg-light text-center text-lg-start border-top mt-5">
    <div class="container py-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
        <p class="mb-2 mb-md-0 text-muted">&copy; <?= date("Y") ?> <strong>Nexus Hotels</strong>. All rights reserved.</p>
        <div class="d-flex align-items-center">
            <a class="text-muted me-4 text-decoration-none fw-medium">Hubungi Kami</a>
            <a href="https://www.instagram.com/nexushotel" class="text-danger me-3"><i class="bi bi-instagram fs-5"></i></a>
            <a href="https://wa.me/" class="text-success me-3"><i class="bi bi-whatsapp fs-5"></i></a>
            <a href="https://web.facebook.com/share/p/1BM9sLY2A2/" class="text-primary"><i class="bi bi-facebook fs-5"></i></a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
