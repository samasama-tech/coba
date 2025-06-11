<?php
include '../koneksi.php';

if (isset($_POST['nokmr'])) {
    $nokmr = $_POST['nokmr'];
    $tipe = $_POST['tipe'];
    $fasilitas = $_POST['fasilitas'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    $sql = "UPDATE kmr SET tipe=?, fasilitas=?, harga=?, status=? WHERE nokmr=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $tipe, $fasilitas, $harga, $status, $nokmr);

    if ($stmt->execute()) {
        header("Location: kamar.php?update=berhasil");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: kamar.php");
}
?>
