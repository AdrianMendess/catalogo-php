<?php

namespace App\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductController
{
    private ProductRepository $repository;

    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function index(): void
    {
        $produtos = $this->repository->findAll();
        require __DIR__ . '/../Views/products/index.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
            $preco = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);
            $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);

            
            if ($nome && $preco !== false) {
                // Passando apenas os campos de texto e números
                $this->repository->create([
                    'nome' => $nome,
                    'descricao' => $descricao,
                    'preco' => $preco,
                    'quantidade' => $quantidade ?? 0
                ]);

                header('Location: index.php');
                exit;
            }
        }
    }
}