<?php

class TablesController {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    /**
     * Menampilkan halaman tabel berdasarkan nama tabel.
     * @param string $tableName Nama tabel yang diminta.
     */
    public function index($tableName) {
        $allowedTables = ['users', 'divisi', 'jurusan', 'fakultas', 'panitia'];
        $perPage = 10; // Jumlah data per halaman

        if (in_array($tableName, $allowedTables)) {
            // Menghitung total data
            $totalData = $this->getTableDataCount($tableName);

            // Menghitung total halaman
            $totalPages = ceil($totalData / $perPage);

            // Ambil nomor halaman dari query string, default halaman 1
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $currentPage = max($currentPage, 1);
            $currentPage = min($currentPage, $totalPages);

            // Hitung offset untuk query
            $offset = ($currentPage - 1) * $perPage;

            // Ambil data tabel sesuai dengan offset dan per halaman
            $data = $this->getTableDataWithLimit($tableName, $offset, $perPage);

            // Tentukan path ke view berdasarkan nama tabel
            $viewPath = __DIR__ . '/../views/tables/' . $tableName . '.php';
            
            if (file_exists($viewPath)) {
                // Kirim data dan pagination info ke view
                include $viewPath;
            } else {
                echo "View untuk tabel '$tableName' tidak ditemukan.";
            }
        } else {
            echo "Tabel '$tableName' tidak valid.";
        }
    }

// Ambil jumlah total data dalam tabel
    public function getTableDataCount($tableName) {
        // Query untuk menghitung jumlah data dalam tabel
        $query = "SELECT COUNT(*) AS total FROM $tableName";
        
        // Persiapkan dan eksekusi query
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Ambil hasilnya menggunakan fetch()
        $result = $stmt->get_result();  // Menggunakan get_result() dengan mysqli
        $row = $result->fetch_assoc();  // Mengambil baris hasil dengan fetch_assoc()

        return $row['total'];  // Mengembalikan total baris
    }

    public function getTableDataWithLimit($tableName, $offset, $limit) {
        // Query untuk mengambil data dengan batasan
        $query = "SELECT * FROM $tableName LIMIT ?, ?";
        
        // Persiapkan statement
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $offset, $limit);  // Binding parameter untuk limit dan offset

        // Eksekusi query
        $stmt->execute();

        // Ambil hasilnya dan kembalikan dalam bentuk array asosiatif
        $result = $stmt->get_result();  // Menggunakan get_result()
        return $result->fetch_all(MYSQLI_ASSOC);  // Mengambil semua hasil dalam bentuk array asosiatif
    }

}
