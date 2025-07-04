<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require 'koneksi.php';
session_start();

try {
    // Ambil data dari form
    $nama      = $_POST['username'] ?? '';
    $email     = $_POST['email'] ?? '';
    $no_hp     = $_POST['no_hp'] ?? '';
    $password  = $_POST['password'] ?? '';
    $cpassword = $_POST['cpassword'] ?? '';
    $role      = 'customer';

    // 1. Cek password cocok
    if ($password !== $cpassword) {
        echo "<script>alert('Password dan konfirmasi tidak cocok.'); window.location.href='index.php';</script>";
        exit;
    }

    // 2. Cek apakah email sudah ada di database
    $cek = $conn->prepare("SELECT 1 FROM cust WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo "<script>alert('Email sudah terdaftar.'); window.location.href='index.php';</script>";
        $cek->close();
        $conn->close();
        exit;
    }
    $cek->close();

    // 3. Hash password (optional, disarankan)
    // $password = password_hash($password, PASSWORD_DEFAULT);

    // 4. Simpan ke DB
    $stmt = $conn->prepare("INSERT INTO cust (username, email, password, no_hp, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $email, $password, $no_hp, $role);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // 5. Set session
    $_SESSION['username'] = $nama;
    echo "<script>alert('Registrasi berhasil!'); window.location.href='index.php';</script>";
    exit;

} catch (Exception $e) {
    // Jika terjadi error (contoh: duplikat email, dsb.)
    echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "'); window.location.href='index.php';</script>";
    exit;
}
