<?php
function getTableQuery($tableName) {
    $queries = [
        'users' => "SELECT * FROM users",
        'divisi' => "SELECT * name FROM divisi",
        'jurusan' => "SELECT * FROM jurusan",
        'fakultas' => "SELECT * FROM fakultas",
        'panitia' => "SELECT * FROM panitia",
    ];

    return $queries[$tableName] ?? null;
}
function handleTableRoutes($request, $db) {
    // Ambil tabel yang valid
    $allowedTables = ['users', 'divisi', 'jurusan', 'fakultas', 'panitia'];

    // Cek apakah URI cocok dengan pola `/tables/{table}`
    if (preg_match('/^\/tables\/([a-zA-Z0-9_]+)$/', $request, $matches)) {
        $tableName = $matches[1];

        // Validasi tabel
        if (in_array($tableName, $allowedTables)) {
            // Panggil controller TablesController untuk menangani permintaan
            require_once __DIR__ . '/../controllers/TablesController.php';
            $controller = new TablesController($db);

            // Panggil metode index dan kirimkan nama tabel
            $controller->index($tableName);
        } else {
            echo "Tabel '$tableName' tidak valid.";
        }
        exit; // Hentikan eksekusi lebih lanjut karena rute sudah ditangani
    }

    // Jika tidak ada rute yang cocok, kembalikan false
    return false;
}

