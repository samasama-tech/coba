<?php
require 'koneksi.php';

// Ambil data dari form
$email            = $_POST['email'] ?? '';
$password_baru    = $_POST['password_baru'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validasi: konfirmasi password
if ($password_baru !== $confirm_password) {
    echo "<script>alert('Konfirmasi password tidak cocok.'); window.history.back();</script>";
    exit;
}

// Cek apakah email terdaftar
$cek = $conn->prepare("SELECT id_cust FROM cust WHERE email = ?");
$cek->bind_param("s", $email);
$cek->execute();
$cek->store_result();

if ($cek->num_rows === 0) {
    echo "<script>alert('Email tidak ditemukan.'); window.history.back();</script>";
    $cek->close();
    $conn->close();
    exit;
}
$cek->close();

// Update password langsung (tanpa hashing)
$update = $conn->prepare("UPDATE cust SET password = ? WHERE email = ?");
$update->bind_param("ss", $password_baru, $email);

if ($update->execute()) {
    echo "<script>alert('Password berhasil direset!'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Gagal mereset password.'); window.history.back();</script>";
}
$update->close();
$conn->close();
