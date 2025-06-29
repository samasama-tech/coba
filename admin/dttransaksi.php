<?php
require_once '../koneksi.php';
$currentPage = 'dttransaksi';

// Ambil jumlah transaksi
$resultJumlah = $conn->query("SELECT COUNT(*) AS total_transaksi FROM transaksi");
$dataJumlah = $resultJumlah->fetch_assoc();
$jumlahTransaksi = $dataJumlah['total_transaksi'] ?? 0;

// Ambil data transaksi + username customer
$resultTransaksi = $conn->query("
    SELECT t.id_trans, c.username AS nama_cust, t.nokmr, t.harga, t.tipe, t.total, t.check_in, t.check_out
    FROM transaksi t
    JOIN cust c ON t.id_cust = c.id_cust
    ORDER BY t.id_trans DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .card-header {
      background-color: #0d6efd;
      color: white;
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container my-5">
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="fas fa-receipt"></i> Data Transaksi</h4>
      <span class="badge bg-primary">Total: <?= $jumlahTransaksi ?> transaksi</span>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-light">
            <tr>
              <th>ID Transaksi</th>
              <th>Username</th>
              <th>No. Kamar</th>
              <th>Harga</th>
              <th>Tipe</th>
              <th>Total</th>
              <th>Check-In</th>
              <th>Check-Out</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $resultTransaksi->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id_trans'] ?></td>
                <td><?= htmlspecialchars($row['nama_cust']) ?></td>
                <td><?= $row['nokmr'] ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= $row['tipe'] ?></td>
                <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                <td><?= date('d-m-Y', strtotime($row['check_in'])) ?></td>
                <td><?= date('d-m-Y', strtotime($row['check_out'])) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
