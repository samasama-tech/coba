<?php
session_start();
require('koneksi.php');

// Validasi data POST
if (!isset($_POST['room'], $_POST['tipe'], $_POST['ci'], $_POST['co'], $_POST['total'], $_POST['metode_pembayaran'])) {
    die("Data tidak lengkap.");
}

// ---- PENAMBAHAN KODE SIMPAN KE DATABASE TRANSAKSI ----

// Pastikan user sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Ambil id_cust dari session berdasarkan email
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT id_cust FROM cust WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$id_cust = $user['id_cust'];
$stmt->close();

// Ambil no_hp user dari database
$stmt = $conn->prepare("SELECT no_hp FROM cust WHERE id_cust = ?");
$stmt->bind_param("i", $id_cust);
$stmt->execute();
$result = $stmt->get_result();
$cust_data = $result->fetch_assoc();
$no_hp = $cust_data['no_hp'];
$stmt->close();

// Ambil data yang sudah di POST
$room = $_POST['room'];
$tipe = $_POST['tipe'];
$total = $_POST['total'];
$ci = $_POST['ci'];
$co = $_POST['co'];

// Simpan ke tabel transaksi
$stmt = $conn->prepare("INSERT INTO transaksi (nokmr, no_hp, harga, id_cust, tipe, check_out) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisss", $room, $no_hp, $total, $id_cust, $tipe, $co);
$stmt->execute();
$stmt->close();

// Update status kamar menjadi 'Terisi'
$stmt = $conn->prepare("UPDATE kmr SET status = 'Terisi' WHERE nokmr = ?");
$stmt->bind_param("s", $room);
$stmt->execute();
$stmt->close();

// ---------------------------------------------------------

// Store payment data in session for receipt page
$_SESSION['payment_data'] = [
    'room' => htmlspecialchars($_POST['room']),
    'tipe' => htmlspecialchars($_POST['tipe']),
    'ci' => htmlspecialchars($_POST['ci']),
    'co' => htmlspecialchars($_POST['co']),
    'total' => (float) $_POST['total'],
    'metode' => htmlspecialchars($_POST['metode_pembayaran'])
];

// --- lanjut kode kamu di bawah ini ---
$room = $_SESSION['payment_data']['room'];
$tipe = $_SESSION['payment_data']['tipe'];
$ci = $_SESSION['payment_data']['ci'];
$co = $_SESSION['payment_data']['co'];
$total = $_SESSION['payment_data']['total'];
$metode = $_SESSION['payment_data']['metode'];

// Mapping metode pembayaran ke label yang lebih deskriptif
$metodeLabels = [
    'qris_shopeepay' => 'ShopeePay (QRIS)',
    'qris_dana' => 'Dana (QRIS)',
    'qris_ovo' => 'OVO (QRIS)',
    'va_bca' => 'Virtual Account BCA',
    'va_bni' => 'Virtual Account BNI',
    'va_mandiri' => 'Virtual Account Mandiri',
    'bank_bca' => 'Transfer Bank BCA',
    'bank_seabank' => 'Transfer ke SeaBank',
    'bank_bni' => 'Transfer ke BNI',
    'bank_bri' => 'Transfer ke BRI',
    'cs_alfamart' => 'Alfamart',
    'cs_indomaret' => 'Indomaret'
];

$metodeLabel = $metodeLabels[$metode] ?? 'Metode tidak dikenal';

// Generate kode pembayaran unik
$kodePembayaran = strtoupper(bin2hex(random_bytes(5)));

switch ($metode) {
    case 'qris_shopeepay':
        $isi_qr = "soon ";
        break;
    case 'qris_dana':
        $isi_qr = "https://link.dana.id/minta?full_url=https://qr.dana.id/v1/281012012022050100222768 ";
        break;
    case 'qris_gopay':
        $isi_qr = "https://gopay.co.id/app/scanqr?deeplink_source=request_money";
        break;
    case 'va_bca':
        $isi_qr = "https://va.bca.co.id/pay?va=500215190369";
        break;
    case 'va_bni':
        $isi_qr = "https://va.bni.co.id/pay?va=$kodePembayaran";
        break;
    case 'va_mandiri':
        $isi_qr = "https://va.mandiri.co.id/pay?va=$kodePembayaran";
        break;
    case 'bank_bca':
        $isi_qr = "https://transfer.bca.co.id/transfer?kode=$kodePembayaran";
        break;
    case 'bank_seabank':
        $isi_qr = "https://seabank.co.id/transfer?kode=$kodePembayaran";
        break;
    case 'bank_bni':
        $isi_qr = "https://bni.co.id/transfer?kode=$kodePembayaran";
        break;
    case 'bank_bri':
        $isi_qr = "https://bri.co.id/transfer?kode=$kodePembayaran";
        break;
    case 'cs_alfamart':
        $isi_qr = "https://pay.alfamart.co.id/?kode=$kodePembayaran";
        break;
    case 'cs_indomaret':
        $isi_qr = "https://pay.indomaret.co.id/?kode=$kodePembayaran";
        break;
    default:
        $isi_qr = "Metode pembayaran tidak dikenali.";
        break;
}

$qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($isi_qr);
?>


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

        .payment-steps {
            text-align: left;
            margin-top: 20px;
        }

        .btn-next {
            background-color: #6c757d;
            border-color: #6c757d;
            cursor: not-allowed;
        }

        .btn-next.active {
            background-color: #28a745;
            border-color: #28a745;
            cursor: pointer;
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
                    <?php if (str_starts_with($metode, 'qris_')): ?>
                        <h5 class="text-success"><i class="bi bi-qr-code-scan"></i> Pembayaran QRIS</h5>
                    <?php else: ?>
                        <h5 class="text-primary"><i class="bi bi-credit-card"></i> Pembayaran <?= $metodeLabel ?></h5>
                    <?php endif; ?>
                </div>

                <div class="text-center">
                    <div class="qr-container mb-3">
                        <img src="<?= $qrCodeUrl ?>" alt="QR Pembayaran" class="img-fluid">
                    </div>
                    <p class="text-muted">Scan QR code di atas untuk melakukan pembayaran</p>
                </div>

                <div class="payment-details mt-4">
                    <h5>Detail Pembayaran</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>No. Kamar</th>
                                <td><?= $room ?></td>
                            </tr>
                            <tr>
                                <th>Tipe Kamar</th>
                                <td><?= $tipe ?></td>
                            </tr>
                            <tr>
                                <th>Check-in</th>
                                <td><?= date('d F Y', strtotime($ci)) ?></td>
                            </tr>
                            <tr>
                                <th>Check-out</th>
                                <td><?= date('d F Y', strtotime($co)) ?></td>
                            </tr>
                            <tr>
                                <th>Total Pembayaran</th>
                                <td class="fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <th>Kode Pembayaran</th>
                                <td class="text-danger fw-bold"><?= $kodePembayaran ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <?php if (!str_starts_with($metode, 'qris_')): ?>
                    <div class="payment-steps">
                        <h5>Langkah Pembayaran:</h5>
                        <ol>
                            <li>Buka aplikasi mobile banking atau e-wallet Anda</li>
                            <li>Pilih metode pembayaran <strong><?= $metodeLabel ?></strong></li>
                            <li>Masukkan kode pembayaran: <strong><?= $kodePembayaran ?></strong></li>
                            <li>Transfer sejumlah <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></li>
                            <li>Simpan bukti pembayaran Anda</li>
                        </ol>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer text-center">
                <div class="d-flex justify-content-between">
                    <a href="home.php" class="btn btn-primary">Kembali ke Beranda</a>
                    <div>
                        <button id="printBtn" class="btn btn-secondary me-2">
                            <i class="bi bi-printer"></i> Cetak QR
                        </button>
                        <a href="struk.php" class="btn btn-success">
                            <i class="bi bi-file-earmark-text"></i> Cetak Struk
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const printBtn = document.getElementById('printBtn');
            const nextBtn = document.getElementById('nextBtn');

            printBtn.addEventListener('click', function () {
                // Trigger print dialog
                window.print();

                // Enable the next button
                nextBtn.classList.remove('disabled', 'btn-next');
                nextBtn.classList.add('btn-success');
            });
        });
    </script>
</body>

</html>