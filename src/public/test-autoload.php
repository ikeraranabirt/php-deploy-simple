<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

echo "<pre>";
echo "__DIR__: " . __DIR__ . "\n";
echo "Database.php existe? ";
var_dump(file_exists(__DIR__ . '/../config/Database.php'));

echo "class_exists(App\\Config\\Database::class)? ";
var_dump(class_exists(\App\Config\Database::class, true));

if (class_exists(\App\Config\Database::class, true)) {
    $db = new \App\Config\Database();
    $pdo = $db->getConnection();
    echo "Conexión OK\n";
}
echo "</pre>";
