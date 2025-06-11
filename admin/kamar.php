<?php
include '../koneksi.php';
$currentPage = 'kamar';

// Ambil data dari tabel kmr
$sql = "SELECT * FROM kmr";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daftar Kamar - Admin</title>
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


      /* Desktop content center fix */
      @media (min-width: 992px) {
        .main-content .container {
          max-width: 1200px;
        }
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
                echo 'active'; ?>" href="kamar.php">Daftar
                  Kamar</a></li>
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
                echo 'active'; ?>" href="dtcust.php">Data
                  Customers</a></li>
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

  <div class="container my-5">
    <div class="card shadow-lg">
      <div class="card-header">
        <h3 class="mb-0"><i class="fas fa-bed"></i> Daftar Kamar</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="table-light">
              <tr>
                <th>No Kamar</th>
                <th>Type</th>
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
                    <td><?= htmlspecialchars($row['nokmr']) ?></td>
                    <td><?= htmlspecialchars($row['tipe']) ?></td>
                    <td><?= htmlspecialchars($row['fasilitas']) ?></td>
                    <td>
                      <?php
                      $badge = 'secondary';
                      if ($row['status'] == 'Kosong')
                        $badge = 'success';
                      elseif ($row['status'] == 'Terisi')
                        $badge = 'danger';
                      elseif ($row['status'] == 'Maintenance')
                        $badge = 'warning';
                      ?>
                      <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($row['status']) ?></span>
                    </td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?> / malam</td>
                    <td>
                      <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editModal<?= $row['nokmr'] ?>">
                        <i class="fas fa-edit"></i> Edit
                      </button>
                      <a href="hapus.php?nokmr=<?= htmlspecialchars($row['nokmr']) ?>"
                        onclick="return confirm('Yakin ingin menghapus kamar ini?')" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Hapus
                      </a>

                      <!-- Modal Edit -->
                      <div class="modal fade" id="editModal<?= $row['nokmr'] ?>" tabindex="-1"
                        aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Ubah Kamar <?= htmlspecialchars($row['nokmr']) ?></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <form action="update.php" method="POST">
                                <input type="hidden" name="nokmr" value="<?= htmlspecialchars($row['nokmr']) ?>">
                                <div class="mb-3">
                                  <label for="tipe" class="form-label">Type:</label>
                                  <select class="form-select" name="tipe" required>  
                                    <option value="Deluxe" <?= $row['tipe'] == 'Deluxe' ? 'selected' : '' ?>>Deluxe Room</option>
                                    <option value="Suite" <?= $row['tipe'] == 'Suite' ? 'selected' : '' ?>>Suite Room</option>
                                    <option value="Standard" <?= $row['tipe'] == 'Standard' ? 'selected' : '' ?>>Executive Room</option>
                                  </select>
                                </div>

                                <div class="mb-3">
                                  <label for="fasilitas" class="form-label">Fasilitas:</label>
                                  <input type="text" class="form-control" name="fasilitas"
                                    value="<?= htmlspecialchars($row['fasilitas']) ?>" required>
                                </div>

                                <div class="mb-3">
                                  <label for="harga" class="form-label">Harga:</label>
                                  <input type="number" class="form-control" name="harga"
                                    value="<?= htmlspecialchars($row['harga']) ?>" required>
                                </div>

                                <div class="mb-3">
                                  <label for="status" class="form-label">Status:</label>
                                  <select class="form-select" name="status" required>
                                    <option value="Kosong" <?= $row['status'] == 'Kosong' ? 'selected' : '' ?>>Kosong</option>
                                    <option value="Terisi" <?= $row['status'] == 'Terisi' ? 'selected' : '' ?>>Terisi</option>
                                    <option value="Maintenance" <?= $row['status'] == 'Maintenance' ? 'selected' : '' ?>>
                                      Maintenance</option>
                                  </select>
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                    </td>

                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>