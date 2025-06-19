<?php
session_start();
$redirect = isset($_SESSION['last_page']) ? $_SESSION['last_page'] : 'index.php';
session_unset();
session_destroy();
header("Location: index.php"); // Redirect ke halaman login
header("Location: $redirect");
exit;
?>