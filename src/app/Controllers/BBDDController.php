<?php

declare(strict_types=1);

namespace App\Controllers;

use PDO;

class MessageController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->ensureTableExists();
    }

    private function ensureTableExists(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS messages (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                text TEXT NOT NULL,
                created_at DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $this->pdo->exec($sql);
    }

    public function getMessages(): void
    {
        $stmt = $this->pdo->query("
            SELECT id, text, created_at
            FROM messages
            ORDER BY id ASC
        ");

        $rows = $stmt->fetchAll();

        echo json_encode(
            array_map(function (array $row): array {
                return [
                    'id'   => (int)$row['id'],
                    'text' => $row['text'],
                    'date' => $row['created_at'],
                ];
            }, $rows),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }

    public function storeMessage(): void
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        if (!isset($data['text']) || trim($data['text']) === '') {
            http_response_code(400);
            echo json_encode(['error' => 'Campo "text" requerido']);
            return;
        }

        $text = trim($data['text']);
        $now  = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("
            INSERT INTO messages (text, created_at)
            VALUES (:text, :created_at)
        ");

        $stmt->execute([
            ':text'       => $text,
            ':created_at' => $now,
        ]);

        $id = (int)$this->pdo->lastInsertId();

        echo json_encode(
            [
                'id'   => $id,
                'text' => $text,
                'date' => $now,
            ],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }
}
