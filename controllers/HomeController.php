<?php

class HomeController
{
    private $db;

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    public function index()
    {

        $banyakPanitia = $this->getCount('panitia');
        $banyakDivisi = $this->getCount('divisi');
        $banyakJurusan = $this->getCount('jurusan');
        $banyakFakultas = $this->getCount('fakultas');
        $tablePanitia = $this->getTablePanitia();
        $mostAngkatan = $this->getMost('angkatan', 'users');
        $mostJurusan = $this->getMost('jurusan', 'datapanitia');

        $data = [
            'banyakPanitia' => $banyakPanitia,
            'banyakDivisi' => $banyakDivisi,
            'banyakJurusan' => $banyakJurusan,
            'banyakFakultas' => $banyakFakultas,
            'tablePanitia' => $tablePanitia,
            'mostAngkatan' => $mostAngkatan,
            'mostJurusan' => $mostJurusan,
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

    private function getMost($columnName, $tableName)
    {
        $query = "SELECT $columnName, COUNT(*) as jumlah from $tableName group by $columnName order by jumlah desc LIMIT 1";
        $result = $this->db->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            return $row[$columnName]; // Mengembalikan nilai dari kolom yang paling banyak
        }
        return null;
    }

    private function getTablePanitia()
    {
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
