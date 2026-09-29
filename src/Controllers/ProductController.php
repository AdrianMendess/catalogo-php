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

    public function index(){
        $produtos = $this->repository->findAll();
        require __DIR__ . "/../Views/products/index.php";
    }
    public function store(){
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);
        $preco = filter_input(INPUT_POST, "preco", FILTER_SANITIZE_NUMBER_FLOAT);
        $quantidade = filter_input(INPUT_POST, "quantidade", FILTER_SANITIZE_NUMBER_INT);

        
        if(!empty($nome) && !empty($descricao) && !empty($preco) && !empty($quantidade)){
            $produto = new Product(
                    nome: $nome,
                    descricao:$descricao,
                    preco: $preco,
                    quantidade: $quantidade
            );
            $this->repository->save($produto);
            header("Location: index.php?action=index&sucesso=add");
            exit();
        }
        
    }
    public function edit(){
        $id = filter_input(INPUT_GET, 'id');
        $produto = $this->repository->findById($id);

        require __DIR__ . '/../Views/products/edit.php';
    }
    public function update(){
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);
        $preco = filter_input(INPUT_POST, "preco", FILTER_SANITIZE_NUMBER_FLOAT);
        $quantidade = filter_input(INPUT_POST, "quantidade", FILTER_SANITIZE_NUMBER_INT);
        echo $id;
        $produto = new Product(
            id: $id,
            nome: $nome,
            descricao: $descricao,
            preco: $preco,
            quantidade: $quantidade,
        );
        echo $produto->getId();
        var_dump($produto);
        $this->repository->update($produto);

        header("Location: index.php?action=index");
        exit();
    }
    public function delete(){
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        if(!$id){
            header("Location: index.php?action=index");
            exit();
        }
        $this->repository->deleteById($id);
        header("Location: index.php?action=index");
        exit();

    }
    public function search(){
        $termo = filter_input(INPUT_GET, "termo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $produtos = $this->repository->findByName($termo);
        require __DIR__ . "/../Views/products/index.php";
    }
}
