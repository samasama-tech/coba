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

    .offcanvas-custom {
      width: 50%;
      max-width: 250px;
    }
  </style>
</head>

<body>

  <?php include 'navbar.php'
    ?>

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
                <th>Kapasitas</th>
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
                    <td><?= htmlspecialchars($row['kap']) ?> orang</td>
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
                      <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#hapusModal<?= $row['nokmr'] ?>">
                        <i class="fas fa-trash"></i> Hapus
                      </button>

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
                                    <option value="Deluxe Room" <?= $row['tipe'] == 'Deluxe Room' ? 'selected' : '' ?>>Deluxe
                                      Room</option>
                                    <option value="Suite Room" <?= $row['tipe'] == 'Suite Room' ? 'selected' : '' ?>>Suite Room
                                    </option>
                                    <option value="Executive Room" <?= $row['tipe'] == 'Executive Room' ? 'selected' : '' ?>>
                                      Executive Room</option>
                                  </select>
                                </div>

                                <div class="mb-3">
                                  <label for="kapasitas" class="form-label">Kapasitas:</label>
                                  <input type="number" class="form-control" name="kapasitas"
                                    value="<?= htmlspecialchars($row['kap']) ?>" required>
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

                      <!-- Modal Hapus -->
                      <div class="modal fade" id="hapusModal<?= $row['nokmr'] ?>" tabindex="-1"
                        aria-labelledby="hapusModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                              <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              Apakah Anda yakin ingin menghapus kamar
                              <strong><?= htmlspecialchars($row['nokmr']) ?></strong>?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <a href="hapus.php?nokmr=<?= htmlspecialchars($row['nokmr']) ?>"
                                class="btn btn-danger">Hapus</a>
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