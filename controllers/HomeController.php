<?php
// Termasuk koneksi ke database dan pagination helper
include_once __DIR__ . '/../config/connection.php';

class HomeController {
    public function index() {
        global $conn;

        // Mengirimkan data ke view
        require __DIR__ . '/../views/dashboard/home.php';
    }
}
