
CREATE DATABASE IF NOT EXISTS loja_brinquedos
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE loja_brinquedos;

CREATE TABLE IF NOT EXISTS brinquedos (
    id           INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    nome         VARCHAR(100)  NOT NULL,
    categoria    VARCHAR(50)   NOT NULL,
    faixa_etaria VARCHAR(30)   NOT NULL,
    preco        DECIMAL(10,2) NOT NULL,
    quantidade   INT UNSIGNED  NOT NULL DEFAULT 0,
    criado_em    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dados de exemplo (opcional)
INSERT INTO brinquedos (nome, categoria, faixa_etaria, preco, quantidade) VALUES
    ('Carrinho de Controle Remoto', 'Carrinhos',          '6-8 anos',  129.90, 15),
    ('Boneca Articulada',           'Bonecos',            '3-5 anos',   89.50, 22),
    ('Blocos de Montar 500 peças',  'Blocos de Montar',   '6-8 anos',  149.00,  8),
    ('Quebra-cabeça do Mapa-Múndi', 'Educativos',         '9-12 anos',  59.90, 30),
    ('Ursinho de Pelúcia Gigante',  'Pelúcias',           '0-2 anos',   74.90, 12);
