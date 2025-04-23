<?php
session_start();

$valid_user = "admin";
$valid_pass = "123456";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === $valid_user && $password === $valid_pass) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Login gagal!'); window.history.back();</script>";
    }
}
?>
