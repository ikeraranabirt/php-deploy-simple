<?php

namespace App\Controllers;

class CSVController
{
    private string $csvPath;

    public function __construct(string $csvPath)
    {
        $this->csvPath = $csvPath;
    }

    // GET /api/messages
    public function getText(): void
    {
        if (!file_exists($this->csvPath)) {
            echo json_encode([]);
            return;
        }

        $handle = fopen($this->csvPath, 'r');
        if (!$handle) {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo abrir el CSV']);
            return;
        }

        // Leer encabezado y descartar
        $header = fgetcsv($handle);

        $rows = [];
        while (($data = fgetcsv($handle)) !== false) {
            $rows[] = [
                'id'   => (int)$data[0],
                'text' => $data[1],
                'date' => $data[2]
            ];
        }

        fclose($handle);

        echo json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }



    // POST /api/messages
    public function storeText(): void
    {
        // Leer JSON del body
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        if (!isset($data['text']) || trim($data['text']) === '') {
            http_response_code(400);
            echo json_encode(['error' => 'Campo "text" requerido']);
            return;
        }

        $text = trim($data['text']);

        // Crear directorio si no existe
        $dir = dirname($this->csvPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $isNew = !file_exists($this->csvPath);

        $handle = fopen($this->csvPath, 'a+');

        if ($isNew) {
            fputcsv($handle, ['id', 'text', 'date']);
            $id = 1;
        } else {
            $id = 1;
            $last = null;
            while (($line = fgetcsv($handle)) !== false) {
                $last = $line;
            }
            if ($last && isset($last[0])) {
                $id = (int)$last[0] + 1;
            }
        }

        $date = date('Y-m-d H:i:s');
        fputcsv($handle, [$id, $text, $date]);

        fclose($handle);

        echo json_encode([
            'id'   => $id,
            'text' => $text,
            'date' => $date
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
