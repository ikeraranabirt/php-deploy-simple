<?php

declare(strict_types=1);

// Siempre devolvemos JSON
header('Content-Type: application/json; charset=utf-8');

// Cargamos el controlador
require __DIR__ . '/../app/Controllers/CSVController.php';
require __DIR__ . '/../vendor/autoload.php';

use App\Config\Database;
use App\Controllers\CSVController;
use App\Controllers\BBDDController;

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

// Ejemplo: tu código ya habrá calculado $method y $uri aquí

if ($uri === '/api/v1/messages') {
    // Controlador basado en CSV (v1)
    $csvPath = __DIR__ . '/../data/messages.csv';
    $csvController  = new CSVController($csvPath);
    
    // V1 → CSV
    if ($method === 'GET') {
        $csvController->getText();          // o el nombre que tengas en CSVController
    } elseif ($method === 'POST') {
        $csvController->storeText();
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido (v1)']);
    }

} elseif ($uri === '/api/v2/messages') {
    // Controlador basado en BBDD (v2)
    $db  = new Database();          // localhost, messages_db, root, etc.
    $pdo = $db->getConnection();
    $dbController = new BBDDController($pdo);

    // V2 → Base de datos
    if ($method === 'GET') {
        $dbController->getMessages();       // adapta al nombre real de tu BBDDController
    } elseif ($method === 'POST') {
        $dbController->storeMessage();
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido (v2)']);
    }

} else {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}

