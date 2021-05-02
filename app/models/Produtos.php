<?php
namespace App\Models;

class Produtos {
    private string $nome;
    private string $descricao;
    private string $imagem;
    private string $imagem2;
    private string $precoant;
    private string $preco;
    private string $desconto;
    private string $quantidade;

    public function __construct($nome,$descricao,$imagem,$imagem2,$precoant,$preco,$desconto,$quantidade) {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->imagem = $imagem;
        $this->imagem2 = $imagem2;
        $this->precoant = $precoant;
        $this->preco = $preco;
        $this->desconto = $desconto;
        $this->quantidade = $quantidade;

    }

    public function getNome()
    {
        return $this->nome;
    }

   
    public function getDescricao()
    {
        return $this->descricao;
    }
    
    public function getImagem()
    {
        return $this->imagem;
    }
    
    public function getImagem2()
    {
        return $this->imagem2;
    }
    
    public function getPrecoant()
    {
        return $this->precoant;
    }
    
    public function getPreco()
    {
        return $this->preco;
    }
    
    public function getDesconto()
    {
        return $this->desconto;
    }
    
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }
}