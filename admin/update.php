<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nokmr = $_POST['nokmr'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    $sql = "UPDATE kmr SET harga='$harga', status='$status' WHERE nokmr='$nokmr'";

    if ($conn->query($sql) === TRUE) {
        header("Location: kamar.php"); // redirect ke halaman utama
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
