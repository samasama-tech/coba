<?php
include '../koneksi.php';
$currentPage = 'tambah';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nokmr = $_POST['nokmr'];
  $tipe = ($_POST['tipe'] === "Other") ? $_POST['tipe_lain'] : $_POST['tipe'];
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
    .nav-link.active {
      font-weight: bold;
      color: #0d6efd !important;
    }

    .card-header {
      background-color: #0d6efd;
      color: white;
      border-radius: 10px 10px 0 0;
    }

    .offcanvas-custom {
      width: 50%;
      max-width: 250px;
    }

    #tipeLainField {
      display: none;
    }
  </style>
</head>
<body>

  <?php include 'navbar.php'; ?>

  <main class="container my-5">
    <div class="card shadow-lg">
      <div class="card-header">
        <h3><i class="fas fa-plus"></i> Tambah Kamar Baru</h3>
      </div>
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
            <select name="tipe" id="tipeKamar" class="form-select" required onchange="toggleTipeLain()">
              <option value="">-- Pilih Tipe --</option>
              <option value="Deluxe">Deluxe Room</option>
              <option value="Suite">Suite Room</option>
              <option value="Executive">Executive Room</option>
              <option value="Other">Lainnya...</option>
            </select>
          </div>

          <div class="mb-3" id="tipeLainField">
            <label>Tipe Kamar Lainnya</label>
            <input type="text" name="tipe_lain" class="form-control" placeholder="Tulis tipe kamar lain...">
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
  <script>
    function toggleTipeLain() {
      const tipeSelect = document.getElementById('tipeKamar');
      const field = document.getElementById('tipeLainField');
      if (tipeSelect.value === 'Other') {
        field.style.display = 'block';
        field.querySelector('input').setAttribute('required', 'required');
      } else {
        field.style.display = 'none';
        field.querySelector('input').removeAttribute('required');
      }
    }
  </script>

</body>
</html>
