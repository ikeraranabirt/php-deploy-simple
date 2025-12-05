<?php

declare(strict_types=1);

// Siempre devolvemos JSON
header('Content-Type: application/json; charset=utf-8');

// Cargamos el controlador
require __DIR__ . '/../app/Controllers/CSVController.php';

use App\Controllers\CSVController;

// Ruta del CSV donde guardaremos los mensajes
$csvPath = __DIR__ . '/../data/messages.csv';

// Instanciamos el controlador
$controller = new CSVController($csvPath);

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

// 1) Si en la URL aparece "index.php", cortamos desde ahí hacia delante
$indexPos = strpos($uri, 'index.php');
if ($indexPos !== false) {
    // Nos quedamos con lo que viene DESPUÉS de "index.php"
    $uri = substr($uri, $indexPos + strlen('index.php'));
}

// 2) Normalizamos para que siempre empiece por una sola barra
$uri = '/' . trim($uri, '/');

// Enrutado muy sencillo: solo una ruta /api/messages
if ($uri === '/api/messages') {
    if ($method === 'GET') {
        $controller->getText();
    } elseif ($method === 'POST') {
        $controller->storeText();
    } else {
        http_response_code(405);
        echo json_encode([
            'error' => 'Método no permitido. Usa GET o POST.'
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(404);
    echo json_encode([
        'error' => 'Ruta no encontrada'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
