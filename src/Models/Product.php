<?php 

namespace App\Models;

class Product{

    public function __construct(
        private ?int $id = null,
        private $nome = '',
        private $descricao = "",
        private $preco = 0.0,
        private $quantidade = 0,

    )
    {} 
// Getters
    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getDescricao(): string { return $this->descricao; }
    public function getPreco(): float { return $this->preco; }
    public function getQuantidade(): int { return $this->quantidade; }

// setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setNome(string $nome): void { $this->nome = $nome; }
    public function setDescricao(string $descricao): void { $this->descricao = $descricao; }
    public function setPreco(float $preco): void { $this->preco = $preco; }
    public function setQuantidade(int $quantidade): void { $this->quantidade = $quantidade; }
    // formata para a tabela
     public function getPrecoFormatado()
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

}