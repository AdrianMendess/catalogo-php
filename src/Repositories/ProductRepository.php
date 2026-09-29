<?php

namespace App\Repositories;

use App\Database\Connection;
use App\Models\Product;
use PDO;

class ProductRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Connection::get();
    }

    public function findAll()
    {
        $stmt = $this->db->query("SELECT * FROM produtos");
        return $stmt->fetchAll();
    }
    public function save(Product $produto)
    {
        echo $produto->getDescricao();
        echo $produto->getNome();
        echo $produto->getPreco();
        echo $produto->getQuantidade();        
        $sql = "INSERT INTO produtos (nome, descricao, preco, quantidade) VALUES (:nome, :descricao, :preco, :quantidade)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":nome" => $produto->getNome(),
            ":descricao" => $produto->getDescricao(),
            ":preco" => $produto->getPreco(),
            ":quantidade" => $produto->getQuantidade(),
        ]);
    }
    public function findById(int $id){
        $sql =  "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":id" => $id,
        ]);
        // var_dump($stmt->fetchAll());
        return $stmt->fetchAll();
    }
    public function update(Product $product){
        $sql =  "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, quantidade = :quantidade WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":nome" => $product->getNome(),
            ":descricao" => $product->getDescricao(),
            ":preco" => $product->getPreco(),
            ":quantidade" => $product->getQuantidade(),
            ":id" => $product->getId(),
        ]);
    }
    public function deleteById(int $id){
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":id" => $id
        ]);
    }
    public function findByName(string $termo){

        $termo =  trim($termo) . '*';
          $sql = "SELECT * FROM produtos 
                WHERE MATCH(nome, descricao) AGAINST(:termo IN BOOLEAN MODE) 
                ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ":termo" => $termo 
        ]);
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
