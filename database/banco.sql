-- ============================================================
--  PROJETO ARTIGOS  --  Banco de Dados
--  Disciplina: TIBD - Tecnologia Integrada de Banco de Dados
--  Autor  : Igor C.
--  Data   : 2026-07-03
--  SGBD   : MySQL 8.x / MariaDB 10.5+
-- ============================================================
-- ============================================================
-- 1. CRIACAO DO BANCO E CONFIGURACAO
-- ============================================================
-- DROP DATABASE IF EXISTS revistaSesi;  -- Ja criado no TiDB Cloud
-- Banco 'revistaSesi' ja provisionado no TiDB Cloud
USE revistaSesi;
-- ============================================================
-- 2. TABELAS
-- ============================================================
-- 2.1 USUARIOS
CREATE TABLE usuarios (
    id         INT           NOT NULL AUTO_INCREMENT,
    nome       VARCHAR(120)  NOT NULL,
    email      VARCHAR(180)  NOT NULL,
    senha      VARCHAR(255)  NOT NULL COMMENT 'Hash bcrypt',
    isAdmin    TINYINT(1)    NOT NULL DEFAULT 0 COMMENT '0=usuario, 1=admin',
    createdAt  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_usuarios      PRIMARY KEY (id),
    CONSTRAINT uq_usuarios_email UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  COMMENT='Usuarios do sistema';
-- 2.2 CATEGORIAS
CREATE TABLE categorias (
    id   INT          NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    CONSTRAINT pk_categorias      PRIMARY KEY (id),
    CONSTRAINT uq_categorias_nome UNIQUE (nome)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  COMMENT='Categorias dos artigos';
-- 2.3 ARTIGOS
CREATE TABLE artigos (
    id           INT          NOT NULL AUTO_INCREMENT,
    titulo       VARCHAR(180) NOT NULL,
    resumo       TEXT         NOT NULL,
    conteudo     TEXT         NOT NULL,
    imagemCapa   VARCHAR(255)     NULL DEFAULT NULL,
    autor_id     INT          NOT NULL,
    categoria_id INT          NOT NULL,
    createdAt    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updatedAt    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
                                       ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT pk_artigos           PRIMARY KEY (id),
    CONSTRAINT fk_artigos_usuario   FOREIGN KEY (autor_id)
        REFERENCES usuarios(id)   ON DELETE CASCADE  ON UPDATE CASCADE,
    CONSTRAINT fk_artigos_categoria FOREIGN KEY (categoria_id)
        REFERENCES categorias(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  COMMENT='Artigos publicados';
-- 2.4 COMENTARIOS
CREATE TABLE comentarios (
    id         INT      NOT NULL AUTO_INCREMENT,
    conteudo   TEXT     NOT NULL,
    usuario_id INT      NOT NULL,
    artigo_id  INT      NOT NULL,
    createdAt  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_comentarios   PRIMARY KEY (id),
    CONSTRAINT fk_coment_user   FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_coment_artigo FOREIGN KEY (artigo_id)
        REFERENCES artigos(id)  ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  COMMENT='Comentarios dos usuarios nos artigos';
-- 2.5 CURTIDAS
CREATE TABLE curtidas (
    id         INT      NOT NULL AUTO_INCREMENT,
    usuario_id INT      NOT NULL,
    artigo_id  INT      NOT NULL,
    createdAt  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_curtidas           PRIMARY KEY (id),
    CONSTRAINT uq_curtidas_user_art  UNIQUE      (usuario_id, artigo_id),
    CONSTRAINT fk_curtidas_user      FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_curtidas_artigo    FOREIGN KEY (artigo_id)
        REFERENCES artigos(id)  ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  COMMENT='Curtidas dos usuarios nos artigos (1 por usuario/artigo)';
-- ============================================================
-- 3. INDICES DE DESEMPENHO
-- ============================================================
CREATE INDEX idx_artigos_autor      ON artigos    (autor_id);
CREATE INDEX idx_artigos_categoria  ON artigos    (categoria_id);
CREATE INDEX idx_artigos_created    ON artigos    (createdAt DESC);
CREATE INDEX idx_comentarios_artigo ON comentarios(artigo_id);
CREATE INDEX idx_curtidas_artigo    ON curtidas   (artigo_id);
-- ============================================================
-- 4. VIEWS
-- ============================================================
-- 4.1 Lista completa de artigos com autor e categoria
CREATE OR REPLACE VIEW vw_artigos AS
SELECT
    a.id,
    a.titulo,
    a.resumo,
    a.imagemCapa,
    a.createdAt,
    a.updatedAt,
    u.id   AS autor_id,
    u.nome AS autor_nome,
    c.id   AS categoria_id,
    c.nome AS categoria_nome,
    (SELECT COUNT(*) FROM curtidas    cu WHERE cu.artigo_id = a.id) AS total_curtidas,
    (SELECT COUNT(*) FROM comentarios co WHERE co.artigo_id = a.id) AS total_comentarios
FROM artigos a
JOIN usuarios   u ON u.id = a.autor_id
JOIN categorias c ON c.id = a.categoria_id;
-- 4.2 Ranking de artigos mais curtidos
CREATE OR REPLACE VIEW vw_ranking_artigos AS
SELECT
    a.id,
    a.titulo,
    u.nome AS autor,
    c.nome AS categoria,
    COUNT(cu.id) AS total_curtidas
FROM artigos a
JOIN usuarios   u  ON u.id  = a.autor_id
JOIN categorias c  ON c.id  = a.categoria_id
LEFT JOIN curtidas cu ON cu.artigo_id = a.id
GROUP BY a.id, a.titulo, u.nome, c.nome
ORDER BY total_curtidas DESC;
-- 4.3 Contagem de artigos por categoria
CREATE OR REPLACE VIEW vw_artigos_por_categoria AS
SELECT
    c.nome      AS categoria,
    COUNT(a.id) AS total_artigos
FROM categorias c
LEFT JOIN artigos a ON a.categoria_id = c.id
GROUP BY c.id, c.nome
ORDER BY total_artigos DESC;
-- 4.4 Atividade dos usuarios
CREATE OR REPLACE VIEW vw_atividade_usuarios AS
SELECT
    u.id,
    u.nome,
    u.email,
    COUNT(DISTINCT a.id)  AS artigos_publicados,
    COUNT(DISTINCT co.id) AS comentarios_feitos,
    COUNT(DISTINCT cu.id) AS curtidas_dadas,
    u.createdAt
FROM usuarios u
LEFT JOIN artigos     a  ON a.autor_id    = u.id
LEFT JOIN comentarios co ON co.usuario_id = u.id
LEFT JOIN curtidas    cu ON cu.usuario_id = u.id
GROUP BY u.id, u.nome, u.email, u.createdAt
ORDER BY artigos_publicados DESC;
-- ============================================================
-- 5. STORED PROCEDURES
-- ============================================================
DELIMITER $$
-- 5.1 Cadastrar novo usuario
CREATE PROCEDURE sp_cadastrar_usuario(
    IN p_nome    VARCHAR(120),
    IN p_email   VARCHAR(180),
    IN p_senha   VARCHAR(255),
    IN p_isAdmin TINYINT(1)
)
BEGIN
    IF EXISTS (SELECT 1 FROM usuarios WHERE email = p_email) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'E-mail ja cadastrado.';
    END IF;
    INSERT INTO usuarios (nome, email, senha, isAdmin, createdAt)
    VALUES (p_nome, p_email, p_senha, p_isAdmin, NOW());
    SELECT LAST_INSERT_ID() AS novo_id;
END$$
-- 5.2 Publicar artigo
CREATE PROCEDURE sp_publicar_artigo(
    IN p_titulo       VARCHAR(180),
    IN p_resumo       VARCHAR(255),
    IN p_conteudo     TEXT,
    IN p_imagem_capa  VARCHAR(255),
    IN p_autor_id     INT,
    IN p_categoria_id INT
)
BEGIN
    IF NOT EXISTS (SELECT 1 FROM usuarios   WHERE id = p_autor_id)     THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Autor nao encontrado.';
    END IF;
    IF NOT EXISTS (SELECT 1 FROM categorias WHERE id = p_categoria_id) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Categoria nao encontrada.';
    END IF;
    INSERT INTO artigos (titulo, resumo, conteudo, imagemCapa, autor_id, categoria_id, createdAt, updatedAt)
    VALUES (p_titulo, p_resumo, p_conteudo, p_imagem_capa, p_autor_id, p_categoria_id, NOW(), NOW());
    SELECT LAST_INSERT_ID() AS artigo_id;
END$$
-- 5.3 Toggle curtida
CREATE PROCEDURE sp_toggle_curtida(
    IN  p_usuario_id INT,
    IN  p_artigo_id  INT,
    OUT p_acao       VARCHAR(20)
)
BEGIN
    IF EXISTS (SELECT 1 FROM curtidas WHERE usuario_id = p_usuario_id AND artigo_id = p_artigo_id) THEN
        DELETE FROM curtidas WHERE usuario_id = p_usuario_id AND artigo_id = p_artigo_id;
        SET p_acao = 'descurtido';
    ELSE
        INSERT INTO curtidas (usuario_id, artigo_id, createdAt) VALUES (p_usuario_id, p_artigo_id, NOW());
        SET p_acao = 'curtido';
    END IF;
END$$
-- 5.4 Buscar artigos por termo
CREATE PROCEDURE sp_buscar_artigos(IN p_termo VARCHAR(200))
BEGIN
    SELECT
        a.id,
        a.titulo,
        a.resumo,
        u.nome AS autor,
        c.nome AS categoria,
        a.createdAt,
        COUNT(cu.id) AS curtidas
    FROM artigos a
    JOIN usuarios   u  ON u.id = a.autor_id
    JOIN categorias c  ON c.id = a.categoria_id
    LEFT JOIN curtidas cu ON cu.artigo_id = a.id
    WHERE a.titulo   LIKE CONCAT('%', p_termo, '%')
       OR a.resumo   LIKE CONCAT('%', p_termo, '%')
       OR a.conteudo LIKE CONCAT('%', p_termo, '%')
    GROUP BY a.id, a.titulo, a.resumo, u.nome, c.nome, a.createdAt
    ORDER BY a.createdAt DESC;
END$$
-- 5.5 Dashboard administrativo
CREATE PROCEDURE sp_dashboard()
BEGIN
    SELECT
        (SELECT COUNT(*) FROM usuarios)                   AS total_usuarios,
        (SELECT COUNT(*) FROM artigos)                    AS total_artigos,
        (SELECT COUNT(*) FROM categorias)                 AS total_categorias,
        (SELECT COUNT(*) FROM comentarios)                AS total_comentarios,
        (SELECT COUNT(*) FROM curtidas)                   AS total_curtidas,
        (SELECT COUNT(*) FROM usuarios WHERE isAdmin = 0) AS usuarios_comuns,
        (SELECT COUNT(*) FROM usuarios WHERE isAdmin = 1) AS administradores;
END$$
DELIMITER ;
-- ============================================================
-- 6. TRIGGERS
-- ============================================================
DELIMITER $$
-- 6.1 Atualiza updatedAt do artigo ao receber comentario
CREATE TRIGGER trg_comentario_after_insert
AFTER INSERT ON comentarios FOR EACH ROW
BEGIN
    UPDATE artigos SET updatedAt = NOW() WHERE id = NEW.artigo_id;
END$$
-- 6.2 Impede comentario vazio
CREATE TRIGGER trg_comentario_before_insert
BEFORE INSERT ON comentarios FOR EACH ROW
BEGIN
    IF TRIM(NEW.conteudo) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Comentario nao pode ser vazio.';
    END IF;
END$$
-- 6.3 Valida artigo antes de inserir
CREATE TRIGGER trg_artigo_before_insert
BEFORE INSERT ON artigos FOR EACH ROW
BEGIN
    IF TRIM(NEW.titulo) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Titulo do artigo nao pode ser vazio.';
    END IF;
    IF TRIM(NEW.conteudo) = '' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Conteudo do artigo nao pode ser vazio.';
    END IF;
END$$
DELIMITER ;
-- ============================================================
-- 7. DADOS INICIAIS (SEED)
-- ============================================================
-- 7.1 Categorias
INSERT INTO categorias (nome) VALUES
    ('Tecnologia'),
    ('Educacao'),
    ('Ciencia'),
    ('Esportes'),
    ('Saude'),
    ('Cultura'),
    ('Economia');
-- 7.2 Usuarios  (senha = 123456 - hash bcrypt)
INSERT INTO usuarios (nome, email, senha, isAdmin, createdAt) VALUES
    ('Administrador',  'admin@site.com',   '$2y$10$7yvSI4PupkOnRTE8.c4f3OB0eXJdYkDkrjEcVuJ39f9M8uA4Vx2XG', 1, NOW()),
    ('Joao Silva',     'joao@email.com',   '$2y$10$7yvSI4PupkOnRTE8.c4f3OB0eXJdYkDkrjEcVuJ39f9M8uA4Vx2XG', 0, NOW()),
    ('Maria Oliveira', 'maria@email.com',  '$2y$10$7yvSI4PupkOnRTE8.c4f3OB0eXJdYkDkrjEcVuJ39f9M8uA4Vx2XG', 0, NOW()),
    ('Carlos Santos',  'carlos@email.com', '$2y$10$7yvSI4PupkOnRTE8.c4f3OB0eXJdYkDkrjEcVuJ39f9M8uA4Vx2XG', 0, NOW());
-- 7.3 Artigos de exemplo
INSERT INTO artigos (titulo, resumo, conteudo, autor_id, categoria_id, createdAt, updatedAt) VALUES
    ('Introducao ao PHP 8.2',
     'Novidades e melhorias do PHP na versao 8.2.',
     'O PHP 8.2 trouxe diversas melhorias de desempenho, tipos de retorno, enums e muito mais...',
     1, 1, NOW(), NOW()),
    ('Doctrine ORM: Guia Pratico',
     'Aprenda a usar o Doctrine ORM com PHP.',
     'O Doctrine e um dos ORMs mais poderosos do ecossistema PHP...',
     2, 1, NOW(), NOW()),
    ('Boas Praticas em Banco de Dados',
     'Dicas essenciais para projetar bancos relacionais.',
     'Normalizacao, indexacao, constraints e boas praticas de nomenclatura sao fundamentais...',
     1, 2, NOW(), NOW()),
    ('Inteligencia Artificial na Educacao',
     'Como a IA esta transformando o ensino.',
     'Ferramentas de IA estao sendo utilizadas para personalizar o aprendizado...',
     3, 2, NOW(), NOW());
-- 7.4 Comentarios de exemplo
INSERT INTO comentarios (conteudo, usuario_id, artigo_id, createdAt) VALUES
    ('Otimo artigo! Muito bem explicado.',         2, 1, NOW()),
    ('Parabens pelo conteudo, foi muito util.',    3, 1, NOW()),
    ('Precisava muito desse guia sobre Doctrine!', 4, 2, NOW()),
    ('Gostei das dicas sobre indices.',            2, 3, NOW());
-- 7.5 Curtidas de exemplo
INSERT INTO curtidas (usuario_id, artigo_id, createdAt) VALUES
    (2, 1, NOW()),
    (3, 1, NOW()),
    (4, 1, NOW()),
    (3, 2, NOW()),
    (4, 2, NOW()),
    (2, 3, NOW());
-- ============================================================
-- 8. CONSULTAS PARA VERIFICACAO (executar manualmente)
-- ============================================================
-- 8.1  Todos os artigos com autor e categoria
-- SELECT * FROM vw_artigos;
-- 8.2  Ranking de artigos mais curtidos
-- SELECT * FROM vw_ranking_artigos;
-- 8.3  Artigos por categoria
-- SELECT * FROM vw_artigos_por_categoria;
-- 8.4  Atividade dos usuarios
-- SELECT * FROM vw_atividade_usuarios;
-- 8.5  Dashboard administrativo
-- CALL sp_dashboard();
-- 8.6  Buscar artigos por termo
-- CALL sp_buscar_artigos('PHP');
-- 8.7  Toggle curtida e ver resultado
-- CALL sp_toggle_curtida(2, 1, @acao);
-- SELECT @acao;

