<?php
session_start();
$redirect = isset($_SESSION['last_page']) ? $_SESSION['last_page'] : 'home.php';
session_unset();
session_destroy();
header("Location: $redirect");
exit;
?>
