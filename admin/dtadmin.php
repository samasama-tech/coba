<?php
require_once '../koneksi.php';
$currentPage = 'dtadmin';

// Tambah Admin
if (isset($_POST['tambah'])) {
  $username = $_POST['username'];
  $no_hp = $_POST['no_hp'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = 'admin';

  $stmt = $conn->prepare("INSERT INTO cust (username, no_hp, email, password, role) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $username, $no_hp, $email, $password, $role);
  $stmt->execute();
  $id_cust = $conn->insert_id;
  $stmt->close();

  // Insert juga ke tabel admin
  $stmt2 = $conn->prepare("INSERT INTO admin (id_admin, username, email, password, no_hp) VALUES (?, ?, ?, ?, ?)");
  $stmt2->bind_param("issss", $id_cust, $username, $email, $password, $no_hp);
  $stmt2->execute();
  $stmt2->close();

}

// Edit Admin
if (isset($_POST['edit'])) {
  $id = $_POST['id_admin'];
  $username = $_POST['username'];
  $no_hp = $_POST['no_hp'];
  $email = $_POST['email'];

  $stmt = $conn->prepare("UPDATE cust SET username=?, no_hp=?, email=? WHERE id_cust=? AND role='admin'");
  $stmt->bind_param("sssi", $username, $no_hp, $email, $id);
  $stmt->execute();
  $stmt->close();

  // Update juga ke tabel admin
  $stmt2 = $conn->prepare("UPDATE admin SET username=?, no_hp=?, email=? WHERE id_admin=?");
  $stmt2->bind_param("sssi", $username, $no_hp, $email, $id);
  $stmt2->execute();
  $stmt2->close();

}

// Ubah Password
if (isset($_POST['ubah_password'])) {
  $id = $_POST['id_admin'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("UPDATE cust SET password=? WHERE id_cust=? AND role='admin'");
  $stmt->bind_param("si", $password, $id);
  $stmt->execute();
  $stmt->close();

  // Update juga password admin
  $stmt2 = $conn->prepare("UPDATE admin SET password=? WHERE id_admin=?");
  $stmt2->bind_param("si", $password, $id);
  $stmt2->execute();
  $stmt2->close();

}

// Hapus Admin
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];

  $stmt = $conn->prepare("DELETE FROM cust WHERE id_cust=? AND role='admin'");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();

  // Hapus juga dari tabel admin
  $stmt2 = $conn->prepare("DELETE FROM admin WHERE id_admin=?");
  $stmt2->bind_param("i", $id);
  $stmt2->execute();
  $stmt2->close();

}

// Ambil data admin (dari cust karena yang utama tabel cust)
$result = $conn->query("SELECT * FROM cust WHERE role='admin'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Data Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    .nav-link.active {
      font-weight: bold;
      color: #0d6efd !important;
    }

    /* Mobile offcanvas spacing fix */
    @media (max-width: 767.98px) {
      .main-content {
        padding: 10px !important;
      }

      .stat-card {
        margin-bottom: 15px;
      }

      td,
      th {
        font-size: medium;
        white-space: nowrap;
      }

      .btn-sm {
        padding: 0.25rem 0.4rem;
        font-size: 0.75rem;
      }
    }

    /* Desktop content center fix */
    @media (min-width: 992px) {
      .main-content .container {
        max-width: 1200px;
      }
    }

    .container {
      margin-left: auto;
    }

    .offcanvas-custom {
      width: 50%;
      max-width: 250px;
    }
  </style>
</head>

<body>
  <!-- Navbar for Desktop -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-none d-lg-flex">
    <div class="container-fluid">
      <a class="navbar-brand" href="dashboard.php">Nexus Hotel</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?php if ($currentPage == 'dashboard')
              echo 'active'; ?>" href="dashboard.php">
              <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php if ($currentPage == 'kamar' || $currentPage == 'tambah')
              echo 'active'; ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
              <i class="fas fa-bed"></i> &nbsp; Kamar
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item <?php if ($currentPage == 'tambah')
                echo 'active'; ?>" href="tambah.php">Tambah Kamar</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item <?php if ($currentPage == 'kamar')
                echo 'active'; ?>" href="kamar.php">Daftar Kamar</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php if ($currentPage == 'dtadmin' || $currentPage == 'dtcust')
              echo 'active'; ?>" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
              <i class="fas fa-user-tie"></i>&nbsp; Data Account
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item <?php if ($currentPage == 'dtadmin')
                echo 'active'; ?>" href="dtadmin.php">Data Admin</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item <?php if ($currentPage == 'dtcust')
                echo 'active'; ?>" href="dtcust.php">Data Customers</a></li>
            </ul>
          </li>

        </ul>
        <a href="../logout.php" class="btn btn-outline-light btn-sm"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
      </div>
    </div>
  </nav>

  <!-- Navbar for Mobile (with Offcanvas) -->
  <nav class="navbar navbar-dark bg-dark d-lg-none">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand ms-2" href="#">Nexus Hotel</a>
    </div>
  </nav>

  <!-- Mobile Offcanvas Sidebar -->
  <div class="offcanvas offcanvas-start text-bg-dark d-lg-none offcanvas-custom" id="mobileSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Nexus Hotel</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i
              class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>

        <!-- Kamar -->
        <li class="nav-item">
          <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            href="#menuKamar" role="button" aria-expanded="false" aria-controls="menuKamar">
            <div><i class="fas fa-bed"></i>&nbsp;Kamar</div>
            <i class="fas fa-chevron-down"></i>
          </a>
          <div class="collapse" id="menuKamar">
            <ul class="nav flex-column ms-3">
              <li><a class="nav-link" href="tambah.php">Tambah Kamar</a></li>
              <li><a class="nav-link" href="kamar.php">Daftar Kamar</a></li>
            </ul>
          </div>
        </li>

        <!-- Data Account -->
        <li class="nav-item">
          <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            href="#menuAccount" role="button" aria-expanded="false" aria-controls="menuAccount">
            <div><i class="fas fa-user-tie"></i>&nbsp; Data Account</div>
            <i class="fas fa-chevron-down ms-2"></i>
          </a>
          <div class="collapse" id="menuAccount">
            <ul class="nav flex-column ms-3">
              <li><a class="nav-link" href="dtadmin.php">Data Admin</a></li>
              <li><a class="nav-link" href="dtcust.php">Data Customers</a></li>
            </ul>
          </div>
        </li>

        <li class="nav-item mt-3"><a class="nav-link text-danger" href="../logout.php"><i
              class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
      </ul>
    </div>
  </div>


  <!-- content -->
  <div class="container py-4">
    <h3>Data Admin</h3>
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Admin</button>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>No HP</th>
          <th>Email</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($admin = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $admin['id_cust'] ?></td>
            <td><?= htmlspecialchars($admin['username']) ?></td>
            <td><?= htmlspecialchars($admin['no_hp']) ?></td>
            <td><?= htmlspecialchars($admin['email']) ?></td>
            <td>
              <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"
                data-id="<?= $admin['id_cust'] ?>" data-username="<?= htmlspecialchars($admin['username']) ?>"
                data-no_hp="<?= htmlspecialchars($admin['no_hp']) ?>"
                data-email="<?= htmlspecialchars($admin['email']) ?>">
                Edit
              </button>

              <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalPassword"
                data-id="<?= $admin['id_cust'] ?>">
                Ubah Password
              </button>

              <a href="?hapus=<?= $admin['id_cust'] ?>" class="btn btn-sm btn-danger"
                onclick="return confirm('Yakin mau hapus admin ini?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal Tambah -->
  <div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control">
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Edit -->
  <div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_admin" id="editId">
          <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" id="editUsername" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" id="editNoHp" class="form-control">
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" id="editEmail" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="edit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Ubah Password -->
  <div class="modal fade" id="modalPassword" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_admin" id="passwordId">
          <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="ubah_password" class="btn btn-warning">Ubah Password</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var modalEdit = document.getElementById('modalEdit');
      modalEdit.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('editId').value = button.getAttribute('data-id');
        document.getElementById('editUsername').value = button.getAttribute('data-username');
        document.getElementById('editNoHp').value = button.getAttribute('data-no_hp');
        document.getElementById('editEmail').value = button.getAttribute('data-email');
      });

      var modalPassword = document.getElementById('modalPassword');
      modalPassword.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('passwordId').value = button.getAttribute('data-id');
      });
    });
  </script>

</body>

</html>