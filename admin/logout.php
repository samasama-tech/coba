<?php
session_start();

$redirect = '../index.php'; // Default redirect

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    $redirect = '../index.php';
}

session_unset();
session_destroy();
header("Location: $redirect");
exit;
?>