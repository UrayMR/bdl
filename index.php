<?php
// Memulai sesi
session_start();

// Mengatur request URI
$request = $_SERVER['REQUEST_URI'];

// Hilangkan parameter query dari URI
$request = strtok($request, '?');

// Base path aplikasi
$basePath = '/bdl';

// Pastikan URI dimulai dengan base path, kemudian hapus base path-nya
if (strpos($request, $basePath) === 0) {
    $request = substr($request, strlen($basePath));
}

// Inklusi koneksi database
include_once __DIR__ . '/config/connection.php';

// Fungsi autoload untuk memuat file controller secara otomatis
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/controllers/' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

// Cek rute tabel terlebih dahulu
include_once __DIR__ . '/routes/tables.php';
if (handleTableRoutes($request, $conn)) {
    exit; // Jika rute tabel ditangani, hentikan eksekusi
}

// Daftar rute lainnya
$routes = [
    '/' => 'HomeController@index',
    '/home' => 'HomeController@index',
    '/filters' => 'FiltersController@index',
];

// Fungsi untuk memanggil controller dan metodenya
function callController($controllerAction, $conn, $params = [])
{
    list($controller, $action) = explode('@', $controllerAction);

    // Periksa apakah controller dan metode ada
    if (class_exists($controller) && method_exists($controller, $action)) {
        // Instansiasi controller dengan koneksi database sebagai dependensi
        $controllerInstance = new $controller($conn);

        // Panggil metode dengan parameter jika ada
        call_user_func_array([$controllerInstance, $action], $params);
    } else {
        // Jika controller atau metode tidak ditemukan
        http_response_code(500);
        echo "Controller or method not found.";
        exit;
    }
}

// Cek rute umum
if (array_key_exists($request, $routes)) {
    callController($routes[$request], $conn);
} else {
    // Tampilkan halaman 404 jika rute tidak ditemukan
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}
