<?php
require_once '../koneksi.php';
$currentPage = 'dtcust';

// CRUD LOGIC

if (isset($_POST['edit'])) {
  $id = $_POST['id_cust'];
  $username = $_POST['username'];
  $no_hp = $_POST['no_hp'];
  $email = $_POST['email'];

  $stmt = $conn->prepare("UPDATE cust SET username=?, no_hp=?, email=? WHERE id_cust=? AND role='customer'");
  $stmt->bind_param("sssi", $username, $no_hp, $email, $id);
  $stmt->execute();
  $stmt->close();
}

if (isset($_POST['ubah_password'])) {
  $id = $_POST['id_cust'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("UPDATE cust SET password=? WHERE id_cust=? AND role='customer'");
  $stmt->bind_param("si", $password, $id);
  $stmt->execute();
  $stmt->close();
}

if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $stmt = $conn->prepare("DELETE FROM cust WHERE id_cust=? AND role='customer'");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
}

$result = $conn->query("SELECT * FROM cust WHERE role='customer'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Data Customers - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .offcanvas-custom { width: 50%; max-width: 250px; }
        .nav-link.active { font-weight: bold; color: #0d6efd !important; }
        .container { margin-left: auto; }
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
                    <a class="nav-link dropdown-toggle <?php if ($currentPage == 'kamar' || $currentPage == 'tambah') echo 'active'; ?>" data-bs-toggle="dropdown" href="#"><i class="fas fa-bed"></i> Kamar</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="tambah.php">Tambah Kamar</a></li>
                        <li><a class="dropdown-item" href="kamar.php">Daftar Kamar</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php if ($currentPage == 'dtadmin' || $currentPage == 'dtcust') echo 'active'; ?>" data-bs-toggle="dropdown" href="#"><i class="fas fa-user-tie"></i> Data Account</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="dtadmin.php">Data Admin</a></li>
                        <li><a class="dropdown-item active" href="dtcust.php">Data Customers</a></li>
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
        <button class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar"><span class="navbar-toggler-icon"></span></button>
        <a class="navbar-brand ms-2" href="#">Nexus Hotel</a>
    </div>
</nav>

<div class="offcanvas offcanvas-start text-bg-dark d-lg-none offcanvas-custom" id="mobileSidebar">
    <div class="offcanvas-header"><h5 class="offcanvas-title">Nexus Hotel</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button></div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between" data-bs-toggle="collapse" href="#menuKamar"><div><i class="fas fa-bed"></i> Kamar</div><i class="fas fa-chevron-down"></i></a>
                <div class="collapse" id="menuKamar">
                    <ul class="nav flex-column ms-3"><li><a class="nav-link" href="tambah.php">Tambah Kamar</a></li><li><a class="nav-link" href="kamar.php">Daftar Kamar</a></li></ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between" data-bs-toggle="collapse" href="#menuAccount"><div><i class="fas fa-user-tie"></i> Data Account</div><i class="fas fa-chevron-down"></i></a>
                <div class="collapse" id="menuAccount">
                    <ul class="nav flex-column ms-3"><li><a class="nav-link" href="dtadmin.php">Data Admin</a></li><li><a class="nav-link active" href="dtcust.php">Data Customers</a></li></ul>
                </div>
            </li>
            <li class="nav-item mt-3"><a class="nav-link text-danger" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
        </ul>
    </div>
</div>

<main class="py-4">
    <div class="container">
        <h1 class="mb-4">Data Customers</h1>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr><th>ID</th><th>Username</th><th>No HP</th><th>Email</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php while ($cust = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $cust['id_cust'] ?></td>
                        <td><?= htmlspecialchars($cust['username']) ?></td>
                        <td><?= htmlspecialchars($cust['no_hp']) ?></td>
                        <td><?= htmlspecialchars($cust['email']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"
                              data-id="<?= $cust['id_cust'] ?>" data-username="<?= htmlspecialchars($cust['username']) ?>"
                              data-no_hp="<?= htmlspecialchars($cust['no_hp']) ?>" data-email="<?= htmlspecialchars($cust['email']) ?>">Edit</button>

                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalPassword"
                              data-id="<?= $cust['id_cust'] ?>">Ubah Password</button>

                            <a href="?hapus=<?= $cust['id_cust'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Edit Customer</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <input type="hidden" name="id_cust" id="editId">
        <div class="mb-3"><label>Username</label><input type="text" name="username" id="editUsername" class="form-control" required></div>
        <div class="mb-3"><label>No HP</label><input type="text" name="no_hp" id="editNoHp" class="form-control"></div>
        <div class="mb-3"><label>Email</label><input type="email" name="email" id="editEmail" class="form-control" required></div>
      </div>
      <div class="modal-footer"><button type="submit" name="edit" class="btn btn-success">Simpan</button></div>
    </form>
  </div>
</div>

<!-- Modal Password -->
<div class="modal fade" id="modalPassword" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Ubah Password</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <input type="hidden" name="id_cust" id="passwordId">
        <div class="mb-3"><label>Password Baru</label><input type="password" name="password" class="form-control" required></div>
      </div>
      <div class="modal-footer"><button type="submit" name="ubah_password" class="btn btn-warning">Ubah Password</button></div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  var modalEdit = document.getElementById('modalEdit');
  modalEdit.addEventListener('show.bs.modal', event => {
    let button = event.relatedTarget;
    document.getElementById('editId').value = button.getAttribute('data-id');
    document.getElementById('editUsername').value = button.getAttribute('data-username');
    document.getElementById('editNoHp').value = button.getAttribute('data-no_hp');
    document.getElementById('editEmail').value = button.getAttribute('data-email');
  });

  var modalPassword = document.getElementById('modalPassword');
  modalPassword.addEventListener('show.bs.modal', event => {
    let button = event.relatedTarget;
    document.getElementById('passwordId').value = button.getAttribute('data-id');
  });
});
</script>

</body>
</html>
