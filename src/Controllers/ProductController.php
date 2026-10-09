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
    $search = filter_input(INPUT_GET, 'search', FILTER_UNSAFE_RAW) ?? '';
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
    
    $limit = 5; // Quantidade de produtos por página
    $offset = ($page - 1) * $limit;

    $produtos = $this->repository->findPaginated($search, $limit, $offset);
    $totalProdutos = $this->repository->count($search);
    $totalPaginas = ceil($totalProdutos / $limit);

    require __DIR__ . '/../Views/products/index.php';
}

   public function store(): void
{
    $nome       = filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW);
    $descricao  = filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW);
    $preco      = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);
    $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);

    if (!$nome || $preco === false || $quantidade === false) {
        header('Location: index.php?error=dados_invalidos');
        exit;
    }

    // Instancia o objeto Product
    $produto = new Product(null, $nome, $descricao, $preco, $quantidade);

    if ($this->repository->create($produto)) {
        header('Location: index.php?success=produto_criado');
    } else {
        header('Location: index.php?error=falha_ao_criar');
    }
    exit;
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

public function update(): void
{
    $id         = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nome       = filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW);
    $descricao  = filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW);
    $preco      = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);
    $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);

    if (!$id || !$nome || $preco === false || $quantidade === false) {
        header('Location: index.php?error=dados_invalidos');
        exit;
    }

    // Instancia o objeto Product preenchendo o ID
    $produto = new Product($id, $nome, $descricao, $preco, $quantidade);

    if ($this->repository->update($produto)) {
        header('Location: index.php?success=produto_atualizado');
    } else {
        header('Location: index.php?error=falha_ao_atualizar');
    }
    exit;
}

}
