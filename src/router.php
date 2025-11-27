<?php

$publicPath = __DIR__ . '/public';

$requested = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

$filePath = realpath($publicPath . $requested);

if ($filePath !== false && strpos($filePath, $publicPath) === 0 && is_file($filePath)) {
    return false;
}

require $publicPath . '/index.php';
