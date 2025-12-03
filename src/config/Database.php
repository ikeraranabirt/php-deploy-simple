<?php

declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $dbname;
    private string $user;
    private string $pass;

    public function __construct(
        string $host = 'localhost',
        string $dbname = 'messages_db',
        string $user = 'root',
        string $pass = ''
    ) {
        $this->host   = $host;
        $this->dbname = $dbname;
        $this->user   = $user;
        $this->pass   = $pass;
    }

    public function getConnection(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

        try {
            $pdo = new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            return $pdo;

        } catch (PDOException $e) {
            die(json_encode([
                'error' => 'Error de conexión a la base de datos',
                'details' => $e->getMessage()
            ]));
        }
    }
}
