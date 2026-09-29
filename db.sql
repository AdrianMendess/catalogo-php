-- Active: 1786990941103@@127.0.0.1@3306@catalogo_db
CREATE DATABASE catalogo_db
    DEFAULT CHARACTER SET = 'utf8mb4';

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE produtos (
    id INT NOT NULL AUTO_INCREMENT UNIQUE,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    quantidade INT DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB COLLATE=utf8mb4_unicode_ci;

truncate produtos;

select * from produtos;

ALTER TABLE produtos ADD FULLTEXT idx_busca (nome, descricao);



select * from usuarios;

truncate usuarios;