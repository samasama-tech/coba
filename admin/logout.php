<?php
session_start();

$redirect = '../index.php'; // Default redirect

// Jika sebelumnya di halaman admin, redirect ke login
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    $redirect = '../index.php';
}

session_unset();
session_destroy();
header("Location: $redirect");
exit;
?>