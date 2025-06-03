<?php
session_start();

function requireAdmin() {
    if (!isset($_SESSION['loggedin']) || !$_SESSION['is_admin']) {
        header("Location: ../customer/login.php");
        exit;
    }
}
function redirectIfAdminLoggedIn() {
    if (isset($_SESSION['loggedin']) && $_SESSION['is_admin']) {
        header("Location: dashboard.php");
        exit;
    }
}
?>