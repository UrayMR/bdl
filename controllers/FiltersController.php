<?php

class FiltersController
{
  private $db;
  private $itemsPerPage = 10; // Number of items per page - you can adjust this

  public function __construct($conn)
  {
    $this->db = $conn;
  }

  public function index()
  {
    $names = $this->getNames();

    // Get current page from URL parameter
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $currentPage = max(1, $currentPage); // Ensure page is at least 1

    $results = null;
    if (!empty($_GET['nama']) && !empty($_GET['parameter']) && !empty($_GET['kriteria'])) {
      // Get filtered results with pagination
      $results = $this->filter($currentPage);
      $totalItems = $this->getTotalFilteredItems();
    } else {
      // Get regular table with pagination
      $results = $this->getTablePanitia($currentPage);
      $totalItems = $this->getTotalItems();
    }

    // Calculate total pages
    $totalPages = ceil($totalItems / $this->itemsPerPage);

    // Ensure current page doesn't exceed total pages
    $currentPage = min($currentPage, $totalPages);

    $data = [
      'names' => $names,
      'results' => $results,
      'currentPage' => $currentPage,
      'totalPages' => $totalPages,
      'totalItems' => $totalItems
    ];

    require __DIR__ . '/../views/filters/filters.php';
  }

  private function getNames()
  {
    $sql = "SELECT nama, npm FROM users";
    $result = $this->db->query($sql);
    $names = [];

    if ($result) {
      while ($row = $result->fetch_assoc()) {
        $names[$row['npm']] = $row['nama'];
      }

      if ($this->db->error) {
        echo "<p style='color: red;'>Database Error: " . htmlspecialchars($this->db->error) . "</p>";
      }
    } else {
      echo "<p style='color: red;'>Query failed: " . htmlspecialchars($this->db->error) . "</p>";
    }

    return $names;
  }

  private function getTotalFilteredItems()
  {
    $npm = $_GET['nama'] ?? null;
    $parameter = $_GET['parameter'] ?? null;
    $kriteria = $_GET['kriteria'] ?? null;

    if (!$npm || !$parameter || !$kriteria) {
      return 0;
    }

    $columns = [
      'angkatan' => 'u.angkatan',
      'npm' => 'CAST(u.npm AS UNSIGNED)',
      'jurusan' => 'j.namaJurusan',
      'divisi' => 'd.namaDivisi',
      'fakultas' => 'f.namaFakultas'
    ];

    $operators = [
      'above' => '>',
      'below' => '<',
      'equal' => '=',
      'above_equal' => '>=',
      'below_equal' => '<='
    ];

    $column = $columns[$parameter] ?? null;
    $operator = $operators[$kriteria] ?? null;

    if (!$column || !$operator) {
      return 0;
    }

    $sql = "
        SELECT COUNT(*) as total
        FROM users u
        LEFT JOIN jurusan j ON u.idJurusan = j.idJurusan
        LEFT JOIN panitia p ON u.npm = p.npm
        LEFT JOIN divisi d ON p.idDivisi = d.idDivisi
        LEFT JOIN fakultas f ON j.idFakultas = f.idFakultas
        WHERE $column $operator (
            SELECT $column 
            FROM users u
            LEFT JOIN jurusan j ON u.idJurusan = j.idJurusan
            LEFT JOIN panitia p ON u.npm = p.npm
            LEFT JOIN divisi d ON p.idDivisi = d.idDivisi
            LEFT JOIN fakultas f ON j.idFakultas = f.idFakultas
            WHERE u.npm = ?
        )
    ";

    $stmt = $this->db->prepare($sql);
    if (!$stmt) {
      return 0;
    }

    $stmt->bind_param("s", $npm);
    if (!$stmt->execute()) {
      return 0;
    }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)$row['total'];
  }

  private function getTotalItems()
  {
    $sql = "SELECT COUNT(*) as total FROM panitia";
    $result = $this->db->query($sql);
    if ($result) {
      $row = $result->fetch_assoc();
      return (int)$row['total'];
    }
    return 0;
  }

  public function filter($currentPage = 1)
  {
    $npm = $_GET['nama'] ?? null;
    $parameter = $_GET['parameter'] ?? null;
    $kriteria = $_GET['kriteria'] ?? null;

    if (!$npm || !$parameter || !$kriteria) {
      die("Input tidak valid. Pastikan semua field diisi.");
    }

    $columns = [
      'angkatan' => 'u.angkatan',
      'npm' => 'CAST(u.npm AS UNSIGNED)',
      'jurusan' => 'j.namaJurusan',
      'divisi' => 'd.namaDivisi',
      'fakultas' => 'f.namaFakultas'
    ];

    $operators = [
      'above' => '>',
      'below' => '<',
      'equal' => '=',
      'above_equal' => '>=',
      'below_equal' => '<='
    ];

    $column = $columns[$parameter] ?? null;
    $operator = $operators[$kriteria] ?? null;

    if (!$column || !$operator) {
      die("Parameter atau kriteria tidak valid.");
    }

    // Calculate offset for pagination
    $offset = ($currentPage - 1) * $this->itemsPerPage;

    $sql = "
        SELECT 
            u.npm,
            u.nama,
            u.angkatan,
            j.namaJurusan AS jurusan,
            d.namaDivisi AS divisi,
            f.namaFakultas AS fakultas
        FROM users u
        LEFT JOIN jurusan j ON u.idJurusan = j.idJurusan
        LEFT JOIN panitia p ON u.npm = p.npm
        LEFT JOIN divisi d ON p.idDivisi = d.idDivisi
        LEFT JOIN fakultas f ON j.idFakultas = f.idFakultas
        WHERE $column $operator (
            SELECT $column 
            FROM users u
            LEFT JOIN jurusan j ON u.idJurusan = j.idJurusan
            LEFT JOIN panitia p ON u.npm = p.npm
            LEFT JOIN divisi d ON p.idDivisi = d.idDivisi
            LEFT JOIN fakultas f ON j.idFakultas = f.idFakultas
            WHERE u.npm = ?
        )
        LIMIT ? OFFSET ?
    ";

    $stmt = $this->db->prepare($sql);
    if (!$stmt) {
      die("Prepare error: " . $this->db->error);
    }

    $stmt->bind_param("sii", $npm, $this->itemsPerPage, $offset);
    if (!$stmt->execute()) {
      die("Execute error");
    }

    $result = $stmt->get_result();
    $results = [];

    if ($result) {
      while ($row = $result->fetch_assoc()) {
        $results[] = $row;
      }
    }

    return $results;
  }

  private function getTablePanitia($currentPage = 1)
  {
    // Calculate offset for pagination
    $offset = ($currentPage - 1) * $this->itemsPerPage;

    $query = "
        SELECT 
            p.npm,
            u.nama,
            d.namaDivisi AS divisi,
            u.angkatan,
            j.namaJurusan AS jurusan,
            f.namaFakultas AS fakultas
        FROM panitia p
        JOIN users u ON p.npm = u.npm
        JOIN divisi d ON p.idDivisi = d.idDivisi
        JOIN jurusan j ON u.idJurusan = j.idJurusan
        JOIN fakultas f ON j.idFakultas = f.idFakultas
        LIMIT ? OFFSET ?
    ";

    $stmt = $this->db->prepare($query);
    if (!$stmt) {
      die("Prepare error: " . $this->db->error);
    }

    $stmt->bind_param("ii", $this->itemsPerPage, $offset);
    if (!$stmt->execute()) {
      die("Execute error");
    }

    $result = $stmt->get_result();
    $data = [];

    if ($result) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    }

    return $data;
  }
}
