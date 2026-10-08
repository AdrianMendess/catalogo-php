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

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM produtos ORDER BY id DESC");
        $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($dados) {
            return new Product(
                $dados['id'],
                $dados['nome'],
                $dados['descricao'],
                (float) $dados['preco'],
                (int) $dados['quantidade']
            );
        }, $linhas);
    }

    public function findById(int $id): ?Product
    {
        $stmt = $this->db->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        // Instancia o objeto passando apenas os campos que o construtor espera
        return new Product(
            $dados['id'],
            $dados['nome'],
            $dados['descricao'],
            (float) $dados['preco'],
            (int) $dados['quantidade']
        );
    }

    public function create(Product $product): bool
    {
        $sql = "INSERT INTO produtos (nome, descricao, preco, quantidade) 
                VALUES (:nome, :descricao, :preco, :quantidade)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nome'       => $product->getNome(),
            ':descricao'  => $product->getDescricao(),
            ':preco'      => $product->getPreco(),
            ':quantidade' => $product->getQuantidade()
        ]);
    }

    public function delete(int $id): bool
    {

        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }


    public function update(Product $product): bool
    {
        $sql = "UPDATE produtos 
                SET nome = :nome, 
                    descricao = :descricao, 
                    preco = :preco, 
                    quantidade = :quantidade 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id'         => $product->getId(),
            ':nome'       => $product->getNome(),
            ':descricao'  => $product->getDescricao(),
            ':preco'      => $product->getPreco(),
            ':quantidade' => $product->getQuantidade()
        ]);
    }
}
