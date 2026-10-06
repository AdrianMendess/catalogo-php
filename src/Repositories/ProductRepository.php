<?php

namespace App\Repositories;

use App\Database\Connection;
use App\Models\Product;
use PDO;

class ProductRepository
{
    private PDO $db;

    public function __construct(){
        $this->db = Connection::get();
    }

    public function findAll(): array{
        $stmt = $this->db->query("SELECT * FROM produtos ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function create(array $data): bool{
        // Query limpa, sem o campo imagem
        $sql = "INSERT INTO produtos (nome, descricao, preco, quantidade) 
                VALUES (:nome, :descricao, :preco, :quantidade)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':nome'       => $data['nome'],
            ':descricao'  => $data['descricao'],
            ':preco'      => $data['preco'],
            ':quantidade' => $data['quantidade']
        ]);
    }
   
    public function delete(int $id): bool{

    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    return $stmt->execute([':id' => $id]);

    }
}