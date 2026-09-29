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
    public function getNome()  { return $this->nome; }
    public function getDescricao()  { return $this->descricao; }
    public function getPreco() { return $this->preco; }
    public function getQuantidade() { return $this->quantidade; }

    // formata para a tabela
     public function getPrecoFormatado()
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

}