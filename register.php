<?php
require 'koneksi.php';
session_start();

$nama     = $_POST['username'] ?? '';
$email    = $_POST['email'] ?? '';
$no_hp    = $_POST['no_hp'] ?? '';
$password = $_POST['password'] ?? '';
$cpassword = $_POST['cpassword'] ?? '';

// Hash/enkripsi password
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);
// Validasi password dan konfirmasi password
if ($password !== $cpassword) {
    die("Password dan Konfirmasi Password tidak cocok.");
}

// Set role secara otomatis
$role = 'customer';

// Siapkan query insert
$stmt = $conn->prepare("INSERT INTO cust (username, email, no_hp, password, role) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameter
$stmt->bind_param("sssss", $nama, $email, $no_hp, $password, $role);

// Eksekusi query
if ($stmt->execute()) {
    $_SESSION['username'] = $nama;
    header("Location: index.php");
    exit;
} else {
    if ($conn->errno === 1062) {
        echo "Email sudah terdaftar.";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>
