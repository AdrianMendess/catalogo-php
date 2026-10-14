<?php

namespace App\Validador;

class ProductValidator
{
    private array $erros = [];

    public function validar(array $dados): bool
{
    $this->erros = [];

    $nome = trim($dados['nome'] ?? '');
        if (empty($nome)) {
            $this->erros['nome'] = 'O nome do produto é obrigatório.';
        } elseif (mb_strlen($nome) < 3) {
            $this->erros['nome'] = 'O nome deve ter pelo menos 3 caracteres.';
        }

        // 2. Validação da Descrição
        $descricao = trim($dados['descricao'] ?? '');
        if (empty($descricao)) {
            $this->erros['descricao'] = 'A descrição é obrigatória.';
        }

        // 3. Validação do Preço
        $preco = $dados['preco'] ?? null;
        if ($preco === '' || $preco === null) {
            $this->erros['preco'] = 'O preço é obrigatório.';
        } elseif (!is_numeric($preco) || (float)$preco <= 0) {
            $this->erros['preco'] = 'O preço deve ser um valor numérico maior que zero.';
        }

        // 4. Validação da Quantidade
        $quantidade = $dados['quantidade'] ?? null;
        if ($quantidade === '' || $quantidade === null) {
            $this->erros['quantidade'] = 'A quantidade é obrigatória.';
        } elseif (!filter_var($quantidade, FILTER_VALIDATE_INT) && $quantidade !== '0') {
            $this->erros['quantidade'] = 'A quantidade deve ser um número inteiro.';
        } elseif ((int)$quantidade < 0) {
            $this->erros['quantidade'] = 'A quantidade não pode ser negativa.';
        }

        return empty($this->erros);
    }

    public function getErros(): array
    {
        return $this->erros;
    }
}
