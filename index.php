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

// Daftar rute dan controller yang sesuai
$routes = [
    '/' => 'HomeController@index',
    '/home' => 'HomeController@index',
    '/filters' => 'FilterController@index',
];

// Fungsi autoload untuk memuat file controller secara otomatis
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/controllers/' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

// Fungsi untuk memanggil controller dan metodenya
function callController($controllerAction) {
    list($controller, $action) = explode('@', $controllerAction);

    // Periksa apakah controller dan metode ada
    if (class_exists($controller) && method_exists($controller, $action)) {
        $controllerInstance = new $controller;
        $controllerInstance->$action();
    } else {
        // Jika controller atau metode tidak ditemukan
        http_response_code(500);
        echo "Controller or method not found.";
        exit;
    }
}

// Periksa apakah rute ada
if (array_key_exists($request, $routes)) {
    callController($routes[$request]);
} else {
    // Tampilkan halaman 404 jika rute tidak ditemukan
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}
