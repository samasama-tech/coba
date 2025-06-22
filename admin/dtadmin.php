<?php
session_start();
require_once '../koneksi.php';
$currentPage = 'dtadmin';

// === CRUD ===
// Tambah
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

  $stmt2 = $conn->prepare("INSERT INTO admin (id_admin, username, email, password, no_hp) VALUES (?, ?, ?, ?, ?)");
  $stmt2->bind_param("issss", $id_cust, $username, $email, $password, $no_hp);
  $stmt2->execute();
  $stmt2->close();
}

// Edit
if (isset($_POST['edit'])) {
  $id = $_POST['id_admin'];
  $username = $_POST['username'];
  $no_hp = $_POST['no_hp'];
  $email = $_POST['email'];

  $stmt = $conn->prepare("UPDATE cust SET username=?, no_hp=?, email=? WHERE id_cust=? AND role='admin'");
  $stmt->bind_param("sssi", $username, $no_hp, $email, $id);
  $stmt->execute();
  $stmt->close();

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

  $stmt2 = $conn->prepare("UPDATE admin SET password=? WHERE id_admin=?");
  $stmt2->bind_param("si", $password, $id);
  $stmt2->execute();
  $stmt2->close();
}

// Hapus
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];

  $stmt2 = $conn->prepare("DELETE FROM admin WHERE id_admin=?");
  $stmt2->bind_param("i", $id);
  $stmt2->execute();
  $stmt2->close();

  $stmt = $conn->prepare("DELETE FROM cust WHERE id_cust=? AND role='admin'");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
}

$result = $conn->query("SELECT * FROM cust WHERE role='admin'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Data Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    .table-container {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .nav-link.active {
      font-weight: bold;
      color: #0d6efd !important;
    }

    .card-header {
      background-color: #0d6efd;
      color: white;
      border-radius: 10px 10px 0 0;
    }

    td,
    th {
      font-size: 0.85rem;
      white-space: nowrap;
    }

    .btn-sm {
      padding: 0.25rem 0.4rem;
      font-size: 0.75rem;
    }

    .modal-dialog {
      max-width: 95%;
      margin: 1.75rem auto;
    }
  </style>
</head>

<body>

  <?php include 'navbar.php'; ?>

  <div class="container my-5">
    <div class="card shadow-lg">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0"><i class="fas fa-user-shield"></i> Data Admin</h3>
        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
          <i class="fas fa-plus"></i> Tambah Admin
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="table-light">
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
                      <i class="fas fa-edit" data-bs-toggle="tooltip" title="Edit Admin"></i>
                    </button>

                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalPassword"
                      data-id="<?= $admin['id_cust'] ?>">
                      <i class="fas fa-key" data-bs-toggle="tooltip" title="Ubah Password"></i>
                    </button>

                    <a href="?hapus=<?= $admin['id_cust'] ?>" class="btn btn-danger btn-sm"
                      onclick="return confirm('Yakin mau hapus admin ini?')">
                      <i class="fas fa-trash" data-bs-toggle="tooltip" title="Hapus Admin"></i>
                    </a>
                  </td>

                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
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

  <!-- <footer class="mt-4 text-center text-muted">
    <p>&copy; 2025 ?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin' ? - Admin Nexus
      Hotel</p>
  </footer> -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Inisialisasi semua tooltip
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl)
      });

      // Modal Edit
      var modalEdit = document.getElementById('modalEdit');
      modalEdit.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('editId').value = button.getAttribute('data-id');
        document.getElementById('editUsername').value = button.getAttribute('data-username');
        document.getElementById('editNoHp').value = button.getAttribute('data-no_hp');
        document.getElementById('editEmail').value = button.getAttribute('data-email');
      });

      // Modal Ubah Password
      var modalPassword = document.getElementById('modalPassword');
      modalPassword.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('passwordId').value = button.getAttribute('data-id');
      });
    });

  </script>

</body>

</html>