<?php
session_start();
require('koneksi.php');

$room = $_POST['room'] ?? '';
$tipe = $_POST['tipe'] ?? '';
$ci = $_POST['ci'] ?? '';
$co = $_POST['co'] ?? '';
$total = $_POST['total'] ?? 0;
$metode = $_POST['metode_pembayaran'] ?? '';

$metodeLabel = '';
switch ($metode) {
    case 'qris_shopeepay':
        $metodeLabel = 'ShopeePay (QRIS)';
        break;
    case 'qris_linkaja':
        $metodeLabel = 'LinkAja (QRIS)';
        break;
    case 'qris_ovo':
        $metodeLabel = 'OVO (QRIS)';
        break;
    case 'va_bca':
        $metodeLabel = 'Virtual Account BCA';
        break;
    case 'bank_bca':
        $metodeLabel = 'Transfer Bank BCA';
        break;
    // Tambahkan lainnya sesuai opsi
    default:
        $metodeLabel = 'Metode tidak dikenal';
}

// Simulasi kode pembayaran unik
$kodePembayaran = strtoupper(substr(md5(uniqid()), 0, 10));
$isi_qr = "Pembayaran Hotel GetHotels\nMetode: $metodeLabel\nKode: $kodePembayaran\nTotal: Rp " . number_format($total, 0, ',', '.');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Instruksi Pembayaran</h3>
    <div class="card p-4 mb-4">
        <p><strong>Metode:</strong> <?= $metodeLabel ?></p>
        <p><strong>Kode Pembayaran:</strong></p>
        <div class="bg-light p-3 rounded border text-center fs-4 fw-bold"><?= $kodePembayaran ?></div>

        <?php if (str_starts_with($metode, 'qris_')): ?>
            <p class="mt-4"><strong>Scan QR untuk membayar:</strong></p>
            <div class="text-center">
                <img src="https://chart.googleapis.com/chart?cht=qr&chs=250x250&chl=<?= urlencode($isi_qr) ?>" alt="QR Pembayaran">
            </div>
            <p class="text-muted mt-2 text-center">Gunakan aplikasi e-wallet Anda untuk scan QR</p>
        <?php else: ?>
            <p class="mt-4"><strong>Langkah Pembayaran:</strong></p>
            <ul>
                <li>Gunakan metode: <strong><?= $metodeLabel ?></strong></li>
                <li>Transfer sejumlah <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></li>
                <li>Ke rekening / VA sesuai petunjuk (simulasi)</li>
            </ul>
        <?php endif; ?>
    </div>
    <a href="home.php" class="btn btn-secondary">Kembali ke Beranda</a>
</div>
</body>
</html>
