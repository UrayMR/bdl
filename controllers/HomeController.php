<?php

class HomeController {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }
    
    public function index() {
        
        $banyakPanitia = $this->getCount('panitia');
        $banyakDivisi = $this->getCount('divisi');
        $banyakJurusan = $this->getCount('jurusan');
        $banyakFakultas = $this->getCount('fakultas');
        $tablePanitia = $this->getTablePanitia();

        $data = [
            'banyakPanitia' => $banyakPanitia,
            'banyakDivisi' => $banyakDivisi,
            'banyakJurusan' => $banyakJurusan,
            'banyakFakultas' => $banyakFakultas,
            'tablePanitia' => $tablePanitia,
        ];

        // Mengirimkan data ke view
        require __DIR__ . '/../views/dashboard/home.php';
    }

    private function getCount($tableName)
    {
        $query = "SELECT COUNT(*) as count FROM $tableName";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    private function getTablePanitia() {
        $query = "
            SELECT 
                `p`.`npm` AS `npm`,
                `u`.`nama` AS `nama`,
                `d`.`namaDivisi` AS `divisi`,
                `u`.`angkatan` AS `angkatan`,
                `j`.`namaJurusan` AS `jurusan`
            FROM
                (((`panitia` `p`
                JOIN `users` `u` ON ((`p`.`npm` = `u`.`npm`)))
                JOIN `divisi` `d` ON ((`p`.`idDivisi` = `d`.`idDivisi`)))
                JOIN `jurusan` `j` ON ((`u`.`idJurusan` = `j`.`idJurusan`)))
            LIMIT 5
        ";

        $result = $this->db->query($query);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
