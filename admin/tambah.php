<?php
include '../koneksi.php';

// Proses tambah kamar
if (isset($_POST['tambah'])) {
    $nokmr = $_POST['nokmr'];
    $tipe = $_POST['tipe'];
    $fasilitas = $_POST['fasilitas'];
    $status = $_POST['status'];
    $harga = $_POST['harga'];
    
    $sql = "INSERT INTO kmr (nokmr, tipe, fasilitas, status, harga) VALUES ('$nokmr', '$tipe', '$fasilitas', '$status', '$harga')";
    
    if ($conn->query($sql)) {
        $success = "Kamar berhasil ditambahkan!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Proses hapus kamar
if (isset($_GET['hapus'])) {
    $nokmr = $_GET['hapus'];
    $sql = "DELETE FROM kmr WHERE nokmr='$nokmr'";
    
    if ($conn->query($sql)) {
        $success = "Kamar berhasil dihapus!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Ambil data kamar
$sql = "SELECT * FROM kmr";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Kamar Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 20px;
    }
    .card {
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    .table th {
      background-color: #f1f1f1;
    }
    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header-container">
      <h2>Manajemen Kamar Hotel</h2>
      <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
    
    <!-- Notifikasi -->
    <?php if (isset($success)): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    
    <!-- Card Tambah Kamar -->
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Tambah Kamar Baru</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="">
          <div class="row g-3">
            <div class="col-md-2">
              <label for="nokmr" class="form-label">No Kamar</label>
              <input type="text" class="form-control" id="nokmr" name="nokmr" required>
            </div>
            
            <div class="col-md-3">
              <label for="tipe" class="form-label">Tipe Kamar</label>
              <select class="form-select" id="tipe" name="tipe" required>
                <option value="Standard">Standard</option>
                <option value="Deluxe">Deluxe</option>
                <option value="Suite">Suite</option>
                <option value="Executive">Executive</option>
              </select>
            </div>
            
            <div class="col-md-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status" required>
                <option value="Kosong">Kosong</option>
                <option value="Terisi">Terisi</option>
                <option value="Maintenance">Maintenance</option>
              </select>
            </div>
            
            <div class="col-md-2">
              <label for="harga" class="form-label">Harga</label>
              <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            
            <div class="col-md-2 d-flex align-items-end">
              <button type="submit" name="tambah" class="btn btn-primary w-100">Tambah</button>
            </div>
          </div>
          
          <div class="row mt-3">
            <div class="col-md-12">
              <label for="fasilitas" class="form-label">Fasilitas</label>
              <textarea class="form-control" id="fasilitas" name="fasilitas" rows="2" required></textarea>
            </div>
          </div>
        </form>
      </div>
    </div>
    
    <!-- Daftar Kamar -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Kamar</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>No Kamar</th>
                <th>Tipe</th>
                <th>Fasilitas</th>
                <th>Status</th>
                <th>Harga</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?php echo $row['nokmr']; ?></td>
                    <td><?php echo $row['tipe']; ?></td>
                    <td><?php echo $row['fasilitas']; ?></td>
                    <td>
                      <span class="badge 
                        <?php 
                          if ($row['status'] == 'Kosong') echo 'bg-success';
                          elseif ($row['status'] == 'Terisi') echo 'bg-danger';
                          else echo 'bg-warning text-dark';
                        ?>">
                        <?php echo $row['status']; ?>
                      </span>
                    </td>
                    <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td>
                      <a href="?hapus=<?php echo $row['nokmr']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kamar ini?')">
                        Hapus
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center">Tidak ada data kamar</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Auto close alert setelah 5 detik
    window.setTimeout(function() {
      document.querySelectorAll(".alert").forEach(function(alert) {
        alert.style.transition = "opacity 0.5s";
        alert.style.opacity = "0";
        setTimeout(function() {
          alert.remove();
        }, 500);
      });
    }, 5000);
  </script>
</body>

</html>