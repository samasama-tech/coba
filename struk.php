<?php
session_start();
require('koneksi.php');
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Check if payment data exists in session
if (!isset($_SESSION['payment_data'])) {
  header('Location: index.php');
  exit();
}

// Get payment data from session
$paymentData = $_SESSION['payment_data'];
$nomorPemesanan = strtoupper(bin2hex(random_bytes(5)));
date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Struk Pembayaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel='shortcut icon' href="img/favicon.ico" type="image/x-icon">
  <style>
    .receipt-card {
      max-width: 600px;
      margin: 0 auto;
      border: 1px solid #ddd;
    }

    .receipt-header {
      background-color: #003580;
      color: white;
      padding: 15px;
      text-align: center;
    }

    .receipt-body {
      padding: 20px;
    }

    .receipt-divider {
      border-top: 2px dashed #ccc;
      margin: 15px 0;
    }

    .receipt-table {
      width: 100%;
      margin-bottom: 20px;
    }

    .receipt-table th {
      text-align: left;
      width: 40%;
      padding: 5px 0;
    }

    .receipt-table td {
      padding: 5px 0;
    }

    .total-payment {
      font-size: 1.2rem;
      font-weight: bold;
      text-align: right;
      margin-top: 20px;
    }

    .btn-print {
      background-color: #28a745;
      color: white;
    }

    .btn-review {
      background-color: #ffc107;
      color: black;
    }

    @media print {
      .no-print {
        display: none !important;
      }
    }

    body {
      background-color: white;
      color: black;
    }

    .receipt-card {
      border: none;
      box-shadow: none;
    }
    }
  </style>
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="container my-5">
    <div id="receiptContent">
      <div class="card receipt-card shadow">
        <div class="card-header receipt-header">
          <h4 class="mb-0">Nexus Hotels</h4>
          <p class="mb-0">Nomor Pemesanan: <?= $nomorPemesanan ?></p>
        </div>

        <div class="card-body receipt-body">
          <div class="receipt-divider"></div>

          <h5>RINCIAN ANDA</h5>
          <table class="receipt-table">
            <tr>
              <th>Nama</th>
              <td><?= htmlspecialchars($username) ?></td>
            </tr>
            <tr>
              <th>Alamat email</th>
              <td><?= htmlspecialchars($email) ?></td>
            </tr>
            <tr>
              <th>Tanggal</th>
              <td><?= date('d M Y H:i') ?></td>
            </tr>
          </table>

          <div class="receipt-divider"></div>

          <h5>RINCIAN PEMESANAN</h5>
          <table class="receipt-table">
            <tr>
              <th>Nama Hotel</th>
              <td>Nexus Hotels</td>
            </tr>
            <tr>
              <th>Alamat Hotel</th>
              <td>Jalan Gatot Subroto<br>Jakarta, Indonesia<br>10270</td>
            </tr>
            <tr>
              <th>Nomor pemesanan</th>
              <td><?= $nomorPemesanan ?></td>
            </tr>
            <tr>
              <th>No. Kamar</th>
              <td><?= htmlspecialchars($paymentData['room']) ?></td>
            </tr>
            <tr>
              <th>Tipe Kamar</th>
              <td><?= htmlspecialchars($paymentData['tipe']) ?></td>
            </tr>
            <tr>
              <th>Check-in</th>
              <td><?= date('l, d F Y', strtotime($paymentData['ci'])) ?></td>
            </tr>
            <tr>
              <th>Check-out</th>
              <td><?= date('l, d F Y', strtotime($paymentData['co'])) ?></td>
            </tr>
          </table>

          <div class="receipt-divider"></div>

          <div class="total-payment">
            Total pembayaran pada <?= date('d M Y') ?><br>
            Rp <?= number_format($paymentData['total'], 0, ',', '.') ?>
          </div>

          <div class="text-center mt-4">
            <p>Terima kasih telah memilih Nexus Hotels!</p>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-center no-print" style="margin-top: 30px;">
      <button id="printPdfBtn" class="btn btn-print me-2">
        <i class="bi bi-file-earmark-pdf"></i> Download
      </button>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('printPdfBtn').addEventListener('click', function () {
        const element = document.getElementById('receiptContent');
        const opt = {
          filename: 'Struk_NexusHotels_<?= $nomorPemesanan ?>.pdf',
          margin: 10,
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: {
            scale: 2,
            scrollX: 0,
            scrollY: 0,
            ignoreElements: function (element) {
              return element.classList.contains('no-print');
            }
          },
          jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait'
          }
        };

        html2pdf().set(opt).from(element).save().then(() => {
          window.location.href = 'index.php';
        });
      });
    });
  </script>

</body>

</html>