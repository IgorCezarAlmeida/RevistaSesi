<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Config\Config;

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    Config::dbHost(),
    Config::dbPort(),
    Config::dbName()
);

$requiredTables = ['usuarios', 'categorias', 'artigos', 'comentarios', 'curtidas'];

try {
    $pdo = new PDO($dsn, Config::dbUser(), Config::dbPass(), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ]);

    $stmt = $pdo->prepare(
        'SELECT table_name FROM information_schema.tables WHERE table_schema = :schema AND table_name = :table LIMIT 1'
    );

    $missing = [];
    foreach ($requiredTables as $table) {
        $stmt->execute(['schema' => Config::dbName(), 'table' => $table]);
        if (!$stmt->fetch()) {
            $missing[] = $table;
        }
    }

    echo 'Conexao OK com TiDB.' . PHP_EOL;
    if ($missing === []) {
        echo 'Todas as tabelas principais existem.' . PHP_EOL;
        exit(0);
    }

    echo 'Tabelas ausentes: ' . implode(', ', $missing) . PHP_EOL;
    exit(2);
} catch (Throwable $e) {
    echo 'Falha ao conectar/verificar TiDB: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}


