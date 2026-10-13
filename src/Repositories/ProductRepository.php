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
            ':nome'      => $product->getNome(),
            ':descricao' => $product->getDescricao(),
            ':preco'     => $product->getPreco(),
            ':quantidade'=> $product->getQuantidade()
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

    // Retorna a lista de produtos filtrados com Full-Text Search
    public function findPaginated(string $search = '', int $limit = 5, int $offset = 0): array
    {
        if (empty($search)) {
            $sql = "SELECT * FROM produtos ORDER BY id DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);
        } else {
            // Nota: Se o índice no MySQL for só em 'nome', mantenha MATCH(nome). 
            // Se foi criado para (nome, descricao), deve usar MATCH(nome, descricao).
            $sql = "SELECT * FROM produtos 
                    WHERE MATCH(nome) AGAINST(:search IN BOOLEAN MODE) 
                    ORDER BY id DESC 
                    LIMIT :limit OFFSET :offset";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', $search . '*', PDO::PARAM_STR);
        }
        
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
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

    // Retorna o total de registros encontrados
    public function count(string $search = ''): int
    {
        if (empty($search)) {
            $sql = "SELECT COUNT(*) FROM produtos";
            $stmt = $this->db->prepare($sql);
        } else {
            $sql = "SELECT COUNT(*) FROM produtos WHERE MATCH(nome) AGAINST(:search IN BOOLEAN MODE)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', $search . '*', PDO::PARAM_STR);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}