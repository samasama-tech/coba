<?php
session_start();
session_unset();     // Menghapus semua variabel sesi
session_destroy();   // Menghancurkan sesi

// Arahkan ke halaman login atau home
header("Location: home.php");
exit();
?>