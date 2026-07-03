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

$statements = [
    "CREATE TABLE IF NOT EXISTS usuarios (
        id INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(120) NOT NULL,
        email VARCHAR(180) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        isAdmin TINYINT(1) NOT NULL DEFAULT 0,
        createdAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY uq_usuarios_email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS categorias (
        id INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY uq_categorias_nome (nome)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS artigos (
        id INT NOT NULL AUTO_INCREMENT,
        titulo VARCHAR(180) NOT NULL,
        resumo VARCHAR(255) NOT NULL,
        conteudo TEXT NOT NULL,
        imagemCapa VARCHAR(255) DEFAULT NULL,
        autor_id INT NOT NULL,
        categoria_id INT NOT NULL,
        createdAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updatedAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_artigos_autor (autor_id),
        KEY idx_artigos_categoria (categoria_id),
        CONSTRAINT fk_artigos_usuario FOREIGN KEY (autor_id) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT fk_artigos_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS comentarios (
        id INT NOT NULL AUTO_INCREMENT,
        conteudo TEXT NOT NULL,
        usuario_id INT NOT NULL,
        artigo_id INT NOT NULL,
        createdAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY idx_comentarios_artigo (artigo_id),
        CONSTRAINT fk_coment_user FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT fk_coment_artigo FOREIGN KEY (artigo_id) REFERENCES artigos(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS curtidas (
        id INT NOT NULL AUTO_INCREMENT,
        usuario_id INT NOT NULL,
        artigo_id INT NOT NULL,
        createdAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY uq_curtidas_user_art (usuario_id, artigo_id),
        KEY idx_curtidas_artigo (artigo_id),
        CONSTRAINT fk_curtidas_user FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT fk_curtidas_artigo FOREIGN KEY (artigo_id) REFERENCES artigos(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "INSERT INTO categorias (nome) VALUES
        ('Tecnologia'),('Educacao'),('Ciencia'),('Esportes')
        ON DUPLICATE KEY UPDATE nome = VALUES(nome)",

    "INSERT INTO usuarios (nome, email, senha, isAdmin, createdAt)
        VALUES ('Administrador', 'admin@site.com', '$2y$10$7yvSI4PupkOnRTE8.c4f3OB0eXJdYkDkrjEcVuJ39f9M8uA4Vx2XG', 1, NOW())
        ON DUPLICATE KEY UPDATE nome = VALUES(nome), isAdmin = VALUES(isAdmin)"
];

try {
    $pdo = new PDO($dsn, Config::dbUser(), Config::dbPass(), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ]);

    foreach ($statements as $sql) {
        $pdo->exec($sql);
    }

    echo 'Schema core criado/validado com sucesso em TiDB.' . PHP_EOL;
    exit(0);
} catch (Throwable $e) {
    echo 'Falha ao criar schema core em TiDB: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}


