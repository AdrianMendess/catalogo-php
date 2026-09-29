<?php 
namespace App\Models;

class Product{
   public function __construct(
    private ?int $id = null,
    private string $nome = "",
    private string $descricao = "",
    private int $quantidade = 0,
    private float $preco = 0.0,
   ){}
   
   public function getId(){
    return $this->id;
   }
   public function getNome(){
    return $this->nome;
   }
   public function getDescricao(){
    return $this->descricao;
   }
   public function getQuantidade(){
    return $this->quantidade;
   }
   public function getPreco(){
    return $this->preco;
   }

    public function getPrecoFormatado(): string
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

}
   
?>