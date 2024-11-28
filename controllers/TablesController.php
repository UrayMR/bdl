<?php
class TablesController
{
    private $db;

    // Array untuk menyimpan kolom yang bisa dicari untuk setiap tabel
    private $searchableColumns = [
        'users' => ['npm', 'nama', 'angkatan', 'idJurusan'],
        'divisi' => ['idDivisi', 'namaDivisi'],
        'jurusan' => ['idJurusan', 'namaJurusan'],
        'fakultas' => ['idFakultas', 'namaFakultas'],
        'panitia' => ['idPanitia', 'namaPanitia']
    ];

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    public function index($tableName)
    {
        $allowedTables = ['users', 'divisi', 'jurusan', 'fakultas', 'panitia'];
        $perPage = 10;

        if (in_array($tableName, $allowedTables)) {
            // Ambil search query jika ada
            $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

            // Hitung total data dengan mempertimbangkan filter pencarian
            $totalData = $this->getTableDataCount($tableName, $searchQuery);

            // Hitung total halaman
            $totalPages = ceil($totalData / $perPage);

            // Ambil nomor halaman dari query string
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $currentPage = max($currentPage, 1);
            $currentPage = min($currentPage, max(1, $totalPages));

            // Hitung offset
            $offset = ($currentPage - 1) * $perPage;

            // Ambil data dengan pencarian dan pagination
            $data = $this->getTableDataWithLimit($tableName, $offset, $perPage, $searchQuery);

            // Tampilkan view
            $viewPath = __DIR__ . '/../views/tables/' . $tableName . '.php';

            if (file_exists($viewPath)) {
                include $viewPath;
            } else {
                echo "View untuk tabel '$tableName' tidak ditemukan.";
            }
        } else {
            echo "Tabel '$tableName' tidak valid.";
        }
    }

    public function getTableDataCount($tableName, $searchQuery = '')
    {
        $query = "SELECT COUNT(*) AS total FROM $tableName";

        // Tambahkan kondisi pencarian jika ada
        if (!empty($searchQuery) && isset($this->searchableColumns[$tableName])) {
            $searchConditions = [];
            foreach ($this->searchableColumns[$tableName] as $column) {
                $searchConditions[] = "$column LIKE ?";
            }
            $query .= " WHERE " . implode(" OR ", $searchConditions);

            // Persiapkan statement
            $stmt = $this->db->prepare($query);

            // Buat array parameter untuk binding
            $params = array_fill(0, count($this->searchableColumns[$tableName]), "%$searchQuery%");

            // Bind parameter
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        } else {
            $stmt = $this->db->prepare($query);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total'];
    }

    public function getTableDataWithLimit($tableName, $offset, $limit, $searchQuery = '')
    {
        $query = "SELECT * FROM $tableName";

        // Tambahkan kondisi pencarian jika ada
        if (!empty($searchQuery) && isset($this->searchableColumns[$tableName])) {
            $searchConditions = [];
            foreach ($this->searchableColumns[$tableName] as $column) {
                $searchConditions[] = "$column LIKE ?";
            }
            $query .= " WHERE " . implode(" OR ", $searchConditions);
        }

        // Tambahkan LIMIT dan OFFSET
        $query .= " LIMIT ? OFFSET ?";

        // Persiapkan statement
        $stmt = $this->db->prepare($query);

        if (!empty($searchQuery) && isset($this->searchableColumns[$tableName])) {
            // Buat array parameter untuk search
            $params = array_fill(0, count($this->searchableColumns[$tableName]), "%$searchQuery%");
            // Tambahkan parameter untuk LIMIT dan OFFSET
            $params[] = $limit;
            $params[] = $offset;

            // Buat string types untuk bind_param
            $types = str_repeat('s', count($this->searchableColumns[$tableName])) . 'ii';

            // Bind semua parameter
            $stmt->bind_param($types, ...$params);
        } else {
            // Jika tidak ada pencarian, hanya bind LIMIT dan OFFSET
            $stmt->bind_param("ii", $limit, $offset);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
