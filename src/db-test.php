<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/vendor/autoload.php';

use App\Config\Database;

echo "INICIO\n";

$db  = new Database();        // usa localhost, messages_db, root, ''
$pdo = $db->getConnection();

echo "CONEXION OK\n";

$stmt   = $pdo->query('SELECT * FROM messages');
$rows   = $stmt->fetchAll();

var_dump($rows);

echo "FIN\n";
