<?php
require 'koneksi.php';
session_start();


$nama = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';
$password = $_POST['password'] ?? '';
$cpassword = $_POST['cpassword'] ?? '';

// Validasi password dan konfirmasi password
if ($password !== $cpassword) {
    die("Password dan Confirm Password tidak cocok.");
}

// Hash/enkripsi password
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare statement untuk insert data
$stmt = $conn->prepare("INSERT INTO cust (username, email, no_hp, password) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssss", $nama, $email, $no_hp, $password);

// Eksekusi query
if ($stmt->execute()) {
    // Simpan username ke session
    $_SESSION['username'] = $nama;

    // Redirect ke home.php (agar session langsung berlaku di halaman utama)
    header("Location: home.php");
    exit;
} else {
    // Cek error duplicate email
    if ($conn->errno === 1062) {
        echo "Email sudah terdaftar.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
