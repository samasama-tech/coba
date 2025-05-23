<?php
session_start();
require 'koneksi.php';
// Pastikan user sudah login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("Location: login.php");
  exit;
}

$message = '';
$userId = null;
$emailSession = $_SESSION["email"];

// Ambil data user berdasarkan email session
$stmt = $conn->prepare("SELECT id_cust FROM cust WHERE email = ?");
$stmt->bind_param("s", $emailSession);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  $userId = $user['id_cust'];
} else {
  echo "User tidak ditemukan.";
  exit;
}
$stmt->close();

// Handle form submit (update data)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $newUsername = trim($_POST['username'] ?? '');
  $newEmail = trim($_POST['email'] ?? '');
  $newPassword = trim($_POST['password'] ?? '');
  $newPasswordConfirm = trim($_POST['password_confirm'] ?? '');

  // Validasi input
  if ($newUsername === '' || $newEmail === '') {
    $message = 'Username dan Email wajib diisi.';
  } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
    $message = 'Email tidak valid.';
  } elseif ($newPassword !== $newPasswordConfirm) {
    $message = 'Password dan konfirmasi password tidak cocok.';
  } else {
    // Cek apakah email baru sudah digunakan user lain
    $stmt = $conn->prepare("SELECT id_cust FROM cust WHERE email = ? AND id_cust != ?");
    $stmt->bind_param("si", $newEmail, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $message = "Email sudah digunakan oleh pengguna lain.";
    } else {
      if ($newPassword !== '') {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE cust SET username = ?, email = ?, password = ? WHERE id_cust = ?");
        $stmt->bind_param("sssi", $newUsername, $newEmail, $hashedPassword, $userId);
      } else {
        $stmt = $conn->prepare("UPDATE cust SET username = ?, email = ? WHERE id_cust = ?");
        $stmt->bind_param("ssi", $newUsername, $newEmail, $userId);
      }

      if ($stmt->execute()) {
        $_SESSION['email'] = $newEmail;
        $_SESSION['username'] = $newUsername;
        header("Location: profile.php?success=1");
        exit;
      } else {
        $message = 'Terjadi kesalahan saat update profil.';
      }
      $stmt->close();
    }
  }
}

// Ambil ulang data user untuk ditampilkan di form
$stmt = $conn->prepare("SELECT username, email FROM cust WHERE id_cust = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Profil</title>
  <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
  <?php include 'navbar.php' ?>

  <div class="container py-4" style="max-width: 480px;">
    <h2 class="mb-4">Edit Profil</h2>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success">Profil berhasil diperbarui.</div>
    <?php elseif ($message): ?>
      <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="profile.php" novalidate>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required
          value="<?= htmlspecialchars($userData['username']) ?>" />
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required
          value="<?= htmlspecialchars($userData['email']) ?>" />
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin ganti)</label>
        <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" />
      </div>

      <div class="mb-3">
        <label for="password_confirm" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm"
          autocomplete="new-password" />
      </div>

      <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>