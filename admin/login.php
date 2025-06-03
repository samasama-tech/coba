<?php
session_start();
require '../customer/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM cust WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) { // Ganti dengan password_verify() jika pakai hash
            // Set session berdasarkan role
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $user["email"];
            $_SESSION["username"] = $user["username"];
            
            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                $_SESSION["is_admin"] = true;
                header("Location: dashboard.php");
            } else {
                $_SESSION["is_admin"] = false;
                if (isset($_SESSION['last_page'])) {
                    header("Location: " . $_SESSION['last_page']);
                } else {
                    header("Location: ../customer/home.php");
                }
            }
            exit;
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