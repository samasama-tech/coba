<?php
include '../koneksi.php';
$currentPage = 'tambah';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nokmr = $_POST['nokmr'];
    $tipe = $_POST['tipe'];
    $fasilitas = $_POST['fasilitas'];
    $status = $_POST['status'];
    $harga = $_POST['harga'];

    $stmt = $conn->prepare("INSERT INTO kmr (nokmr, tipe, fasilitas, status, harga) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $nokmr, $tipe, $fasilitas, $status, $harga);

    if ($stmt->execute()) {
        header("Location: kamar.php");
        exit();
    } else {
        $error = "Gagal menambahkan kamar: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tambah Kamar - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    .nav-link.active { font-weight: bold; color: #0d6efd !important; }
    .card-header { background-color: #0d6efd; color: white; border-radius: 10px 10px 0 0; }
    .offcanvas-custom { width: 50%; max-width: 250px; }
  </style>
</head>

<body>

<!-- Navbar Desktop -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-none d-lg-flex">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Nexus Hotel</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link <?php if ($currentPage == 'dashboard') echo 'active'; ?>" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php if ($currentPage == 'kamar' || $currentPage == 'tambah') echo 'active'; ?>" data-bs-toggle="dropdown" href="#"><i class="fas fa-bed"></i> &nbsp;Kamar</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?php if ($currentPage == 'tambah') echo 'active'; ?>" href="tambah.php">Tambah Kamar</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?php if ($currentPage == 'kamar') echo 'active'; ?>" href="kamar.php">Daftar Kamar</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php if ($currentPage == 'dtadmin' || $currentPage == 'dtcust') echo 'active'; ?>" data-bs-toggle="dropdown" href="#"><i class="fas fa-user-tie"></i>&nbsp; Data Account</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?php if ($currentPage == 'dtadmin') echo 'active'; ?>" href="dtadmin.php">Data Admin</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item <?php if ($currentPage == 'dtcust') echo 'active'; ?>" href="dtcust.php">Data Customers</a></li>
          </ul>
        </li>
      </ul>
      <a href="../logout.php" class="btn btn-outline-light btn-sm"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
    </div>
  </div>
</nav>

<!-- Navbar Mobile -->
<nav class="navbar navbar-dark bg-dark d-lg-none">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar"><span class="navbar-toggler-icon"></span></button>
    <a class="navbar-brand ms-2" href="#">Nexus Hotel</a>
  </div>
</nav>

<!-- Offcanvas Sidebar Mobile -->
<div class="offcanvas offcanvas-start text-bg-dark d-lg-none offcanvas-custom" id="mobileSidebar">
  <div class="offcanvas-header"><h5 class="offcanvas-title">Nexus Hotel</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button></div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
      <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuKamar"><div><i class="fas fa-bed"></i>&nbsp;Kamar</div><i class="fas fa-chevron-down"></i></a>
        <div class="collapse" id="menuKamar">
          <ul class="nav flex-column ms-3">
            <li><a class="nav-link active" href="tambah.php">Tambah Kamar</a></li>
            <li><a class="nav-link" href="kamar.php">Daftar Kamar</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuAccount"><div><i class="fas fa-user-tie"></i>&nbsp; Data Account</div><i class="fas fa-chevron-down ms-2"></i></a>
        <div class="collapse" id="menuAccount">
          <ul class="nav flex-column ms-3">
            <li><a class="nav-link" href="dtadmin.php">Data Admin</a></li>
            <li><a class="nav-link" href="dtcust.php">Data Customers</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item mt-3"><a class="nav-link text-danger" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
    </ul>
  </div>
</div>

<main class="container my-5">
  <div class="card shadow-lg">
    <div class="card-header"><h3><i class="fas fa-plus"></i> Tambah Kamar Baru</h3></div>
    <div class="card-body">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label>No Kamar</label>
          <input type="text" name="nokmr" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Tipe Kamar</label>
          <select name="tipe" class="form-select" required>
            <option value="">-- Pilih Tipe --</option>
            <option value="Deluxe">Deluxe Room</option>
            <option value="Suite">Suite Room</option>
            <option value="Standard">Executive Room</option>
          </select>
        </div>

        <div class="mb-3">
          <label>Fasilitas</label>
          <textarea name="fasilitas" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label>Status</label>
          <select name="status" class="form-select" required>
            <option value="Kosong">Kosong</option>
            <option value="Terisi">Terisi</option>
            <option value="Maintenance">Maintenance</option>
          </select>
        </div>

        <div class="mb-3">
          <label>Harga per Malam (Rp)</label>
          <input type="number" name="harga" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
      </form>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
