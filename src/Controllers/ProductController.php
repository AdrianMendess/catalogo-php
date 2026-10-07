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

    public function destroy(): void {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: index.php?error=id_invalido');
            exit;
        }

        $sucesso = $this->repository->delete($id);

        if ($sucesso) {
            header('Location: index.php?success=produto_deletado');
        } else {
            header('Location: index.php?error=falha_ao_deletar');
        }
}

public function edit(): void{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


    if (!$id){
        header('location: index.php');
        exit;
    }

    $produto = $this->repository->findById($id);
 
    if(!$produto){
        header('Location: index.php?error=produto_nao_encontrado');
        exit;
    }

    // incluindo a view para dar acesso a variavel produto.
    require __DIR__ . '/../Views/products/edit.php';
}

}