<?php
session_start();

require 'koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Cek apakah user dengan email ini ada
    $stmt = $conn->prepare("SELECT * FROM cust WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika ada user dengan email tsb
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Cek apakah password cocok
        if (password_verify($password, $user['password'])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $user["email"];
            $_SESSION["name"] = $user["name"];
            header("Location: menu.php");
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
