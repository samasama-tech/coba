<?php
require_once 'auth.php'; // Gunakan require_once untuk menghindari duplikasi

class AdminController {
    public function index() {
        requireAdmin(); // Panggil fungsi dari auth.php
        
        // Konten admin Anda di sini
        echo "Halaman Admin";
    }
}

// Inisialisasi hanya jika file diakses langsung
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    $admin = new AdminController();
    $admin->index();
}
?>