<?php

namespace App\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Validador\ProductValidator;

class ProductController 
{
    private ProductRepository $repository;

    public function __construct() {
        $this->repository = new ProductRepository();
    }

    public function index(): void {
        $search = filter_input(INPUT_GET, 'search', FILTER_UNSAFE_RAW) ?? '';
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
        
        $limit = 5; 
        $offset = ($page - 1) * $limit;

        $produtos = $this->repository->findPaginated($search, $limit, $offset);
        $totalProdutos = $this->repository->count($search);
        $totalPaginas = ceil($totalProdutos / $limit);

        require __DIR__ . '/../Views/products/index.php';
    }

    public function create(): void {
        $dados = [];
        $erros = [];
        require __DIR__ . '/../Views/products/create.php';
    }

    public function store(): void {
        // Pega os dados como texto/brutos para delegar a validação ao ProductValidator
        $dados = [
            'nome'       => filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW),
            'descricao'  => filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW),
            'preco'      => filter_input(INPUT_POST, 'preco', FILTER_UNSAFE_RAW),
            'quantidade' => filter_input(INPUT_POST, 'quantidade', FILTER_UNSAFE_RAW)
        ];

        $validator = new ProductValidator();

        if (!$validator->validar($dados)) {
            $erros = $validator->getErros();
            // Exibe a view de criação enviando os erros e os dados já digitados
            require __DIR__ . '/../Views/products/create.php';
            return; 
        }

        // Dados válidos: Instancia e salva
        $produto = new Product(
            null,
            $dados['nome'],
            $dados['descricao'],
            (float) $dados['preco'],
            (int) $dados['quantidade']
        );

        if ($this->repository->create($produto)) {
            header('Location: index.php?success=produto_criado');
        } else {
            header('Location: index.php?error=falha_ao_criar');
        }
        exit;
    }

    public function edit(): void {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: index.php');
            exit;
        }

        $produto = $this->repository->findById($id);

        if (!$produto) {
            header('Location: index.php?error=produto_nao_encontrado');
            exit;
        }

        // Prepara os dados para preencher o formulário de edição
        $dados = [
            'id'         => $produto->getId(),
            'nome'       => $produto->getNome(),
            'descricao'  => $produto->getDescricao(),
            'preco'      => $produto->getPreco(),
            'quantidade' => $produto->getQuantidade()
        ];

        require __DIR__ . '/../Views/products/edit.php';
    }

    public function update(): void {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: index.php?error=id_invalido');
            exit;
        }

        $dados = [
            'id'         => $id,
            'nome'       => filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW),
            'descricao'  => filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW),
            'preco'      => filter_input(INPUT_POST, 'preco', FILTER_UNSAFE_RAW),
            'quantidade' => filter_input(INPUT_POST, 'quantidade', FILTER_UNSAFE_RAW)
        ];

        $validator = new ProductValidator();

        if (!$validator->validar($dados)) {
            $erros = $validator->getErros();
            // Exibe novamente o formulário de edição mantendo os dados inseridos e os erros
            require __DIR__ . '/../Views/products/edit.php';
            return;
        }

        $produto = new Product(
            $id,
            $dados['nome'],
            $dados['descricao'],
            (float) $dados['preco'],
            (int) $dados['quantidade']
        );

        if ($this->repository->update($produto)) {
            header('Location: index.php?success=produto_atualizado');
        } else {
            header('Location: index.php?error=falha_ao_atualizar');
        }
        exit;
    }

    public function destroy(): void {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: index.php?error=id_invalido');
            exit;
        }

        if ($this->repository->delete($id)) {
            header('Location: index.php?success=produto_deletado');
        } else {
            header('Location: index.php?error=falha_ao_deletar');
        }
        exit;
    }
}