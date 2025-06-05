<?php
include '../koneksi.php';

// Ambil data dari tabel kmr
$sql = "SELECT * FROM kmr";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Kamar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .table-container {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Daftar Kamar</h2>
    <div class="table-container">
      <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali</a>
      <table class="table table-bordered table-hover">
        <thead>
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
                <td><?php echo $row['nokmr']; ?></td>
                <td><?php echo $row['tipe']; ?></td>
                <td><?php echo $row['fasilitas']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?> / malam</td>
                <td>
                  <button class="btn btn-warning" data-bs-toggle="modal"
                    data-bs-target="#editModal<?php echo $row['nokmr']; ?>">
                    Ubah
                  </button>

                  <!-- Modal untuk Edit -->
                  <div class="modal fade" id="editModal<?php echo $row['nokmr']; ?>" tabindex="-1"
                    aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editModalLabel">Ubah Kamar <?php echo $row['nokmr']; ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="update.php" method="POST">
                            <input type="hidden" name="nokmr" value="<?php echo $row['nokmr']; ?>">
                            <div class="mb-3">
                              <label for="harga" class="col-form-label">Harga:</label>
                              <input type="number" class="form-control" name="harga" value="<?php echo $row['harga']; ?>"
                                required>
                            </div>
                            <div class="mb-3">
                              <label for="status" class="col-form-label">Status:</label>
                              <select class="form-select" name="status" required>
                                <option value="Kosong" <?php echo $row['status'] == 'Kosong' ? 'selected' : ''; ?>>Kosong
                                </option>
                                <option value="Terisi" <?php echo $row['status'] == 'Terisi' ? 'selected' : ''; ?>>Terisi
                                </option>
                                <option value="Maintenance" <?php echo $row['status'] == 'Maintenance' ? 'selected' : ''; ?>>
                                  Maintenance</option>
                              </select>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>