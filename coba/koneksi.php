<?php
$host = "localhost";
$user = "root"; // Ganti jika berbeda
$pass = "";     // Ganti jika ada password
$dbname = "hotel";

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
