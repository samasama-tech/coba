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
        // if (password_verify($password, $user['password'])) { -> untuk hash
        if ($password === $user['password']) {
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $user["email"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["id_cust"] = $user["id_cust"];  // <-- tambahan penting ini

            if ($user['role'] === 'admin') {
                $_SESSION["is_admin"] = true;
                header("Location: admin/dashboard.php");
            } else {
                $_SESSION["is_admin"] = false;
                if (isset($_SESSION['last_page'])) {
                    header("Location: " . $_SESSION['last_page']);
                } else {
                    header("Location: home.php");
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
