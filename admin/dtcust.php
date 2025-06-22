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
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Data Customers - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    .offcanvas-custom {
      width: 50%;
      max-width: 250px;
    }

    .nav-link.active {
      font-weight: bold;
      color: #0d6efd !important;
    }

    td, th {
      font-size: 0.85rem;
      white-space: nowrap;
    }

    .btn-sm {
      padding: 0.35rem 0.5rem;
      font-size: 0.75rem;
    }

    .card-header {
      background-color: #0d6efd;
      color: white;
      border-radius: 10px 10px 0 0;
    }

    .table td,
    .table th {
      vertical-align: middle;
    }
  </style>
</head>

<body>

  <?php include 'navbar.php' ?>

  <main class="py-4">
    <div class="container">
      <div class="card shadow-lg">
        <div class="card-header">
          <h3 class="mb-0"><i class="fas fa-users"></i> Data Customers</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered align-middle">
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
                <?php while ($cust = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= $cust['id_cust'] ?></td>
                    <td><?= htmlspecialchars($cust['username']) ?></td>
                    <td><?= htmlspecialchars($cust['no_hp']) ?></td>
                    <td><?= htmlspecialchars($cust['email']) ?></td>
                    <td>
                      <button class="btn btn-warning btn-sm" title="Edit Customer"
                        data-bs-toggle="modal" data-bs-target="#modalEdit"
                        data-id="<?= $cust['id_cust'] ?>"
                        data-username="<?= htmlspecialchars($cust['username']) ?>"
                        data-no_hp="<?= htmlspecialchars($cust['no_hp']) ?>"
                        data-email="<?= htmlspecialchars($cust['email']) ?>">
                        <i class="fas fa-pen-to-square"></i>
                      </button>

                      <button class="btn btn-info btn-sm" title="Ubah Password"
                        data-bs-toggle="modal" data-bs-target="#modalPassword"
                        data-id="<?= $cust['id_cust'] ?>">
                        <i class="fas fa-key"></i>
                      </button>

                      <a href="?hapus=<?= $cust['id_cust'] ?>" class="btn btn-danger btn-sm"
                        title="Hapus Customer"
                        onclick="return confirm('Yakin hapus?')">
                        <i class="fas fa-trash"></i>
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
  </main>

  <!-- Modal Edit -->
  <div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_cust" id="editId">
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

  <!-- Modal Password -->
  <div class="modal fade" id="modalPassword" tabindex="-1">
    <div class="modal-dialog">
      <form method="post" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_cust" id="passwordId">
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
    document.addEventListener('DOMContentLoaded', () => {
      const modalEdit = document.getElementById('modalEdit');
      modalEdit.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        document.getElementById('editId').value = button.getAttribute('data-id');
        document.getElementById('editUsername').value = button.getAttribute('data-username');
        document.getElementById('editNoHp').value = button.getAttribute('data-no_hp');
        document.getElementById('editEmail').value = button.getAttribute('data-email');
      });

      const modalPassword = document.getElementById('modalPassword');
      modalPassword.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        document.getElementById('passwordId').value = button.getAttribute('data-id');
      });

      // Aktifkan tooltip (jika pakai title="")
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
      tooltipTriggerList.forEach(el => {
        new bootstrap.Tooltip(el);
      });
    });
  </script>

</body>
</html>
