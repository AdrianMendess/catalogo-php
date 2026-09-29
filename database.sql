truncate produtos;

select * from produtos;

ALTER TABLE produtos ADD FULLTEXT idx_busca (nome, descricao);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

select * from usuarios;

truncate usuarios;