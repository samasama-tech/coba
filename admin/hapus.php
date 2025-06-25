<?php
require '../koneksi.php';

// Cek apakah parameter nokmr ada
if (!isset($_GET['nokmr'])) {
    echo "<script>alert('Parameter kamar tidak ditemukan.'); window.location='kamar.php';</script>";
    exit;
}

$nokmr = $_GET['nokmr'];

// Coba hapus data kamar
try {
    $stmt = $conn->prepare("DELETE FROM kmr WHERE nokmr = ?");
    $stmt->bind_param("s", $nokmr);
    $stmt->execute();

    // Cek apakah ada baris yang terpengaruh
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Kamar berhasil dihapus.'); window.location='kamar.php';</script>";
    } else {
        echo "<script>alert('Kamar tidak ditemukan atau sudah dihapus.'); window.location='kamar.php';</script>";
    }

    $stmt->close();
} catch (mysqli_sql_exception $e) {
    // Tangani error jika gagal karena foreign key constraint
    if ($e->getCode() == 1451) {
        echo "<script>alert('Gagal menghapus: Kamar masih digunakan di transaksi.'); window.location='kamar.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . addslashes($e->getMessage()) . "'); window.location='kamar.php';</script>";
    }
}
?>
