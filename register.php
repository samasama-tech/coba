<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require 'koneksi.php';
session_start();

// Ambil data dari form
$nama      = $_POST['username'] ?? '';
$email     = $_POST['email'] ?? '';
$no_hp     = $_POST['no_hp'] ?? '';
$password  = $_POST['password'] ?? '';
$cpassword = $_POST['cpassword'] ?? '';
$role      = 'customer';

// 1. Cek password cocok
if ($password !== $cpassword) {
    echo "<script>alert('Password dan konfirmasi tidak cocok.'); window.location.href='register.php';</script>";
    exit;
}

// 2. Cek apakah email sudah ada di database
$cek = $conn->prepare("SELECT 1 FROM cust WHERE email = ?");
$cek->bind_param("s", $email);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    // 3. Email sudah ada, jangan insert, tampilkan alert saja
    echo "<script>alert('Email sudah terdaftar.'); window.location.href='index.php';</script>";
    $cek->close();
    $conn->close();
    exit;
}
$cek->close(); // Tutup SELECT

// 4. Kalau email belum ada, lanjut insert
$stmt = $conn->prepare("INSERT INTO cust (username, email, password, no_hp, role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nama, $email, $password, $no_hp, $role);
$stmt->execute();
$stmt->close();
$conn->close();

// 5. Berhasil, redirect
$_SESSION['username'] = $nama;
echo "<script>alert('Registrasi berhasil!'); window.location.href='index.php';</script>";
exit;
