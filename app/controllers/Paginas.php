<?php
namespace App\Controllers;

use App\Controllers\ControladorCore;

class Paginas extends ControladorCore {
    

    public function __construct() {
        parent::__construct();
    }


    public function index() {
        $this->addTituloPagina("Página Inicial");
        $this->carregarPagina("v_home");
    }

    public function produto() {
        $idProduto = -1;   
        if(isset($_GET['id'])){
            //vamos adicionar ao carrinho
            $idProduto = $_GET['id'];
        }

        $this->addTituloPagina("Página Produto");
        
        $produto = $this->getProduto($idProduto);
        $this->addDadosPagina('produto', $produto);
        $this->addDadosPagina('idProduto', $idProduto);

        $this->carregarPagina("v_produto");
    }

    public function carrinho() {
        $idProduto = -1;   
        if(isset($_GET['id'])){
            //vamos adicionar ao carrinho
            $idProduto = $_GET['id'];
        }

        $this->addTituloPagina("Página Carrinho");
       
        $this->addItemCarrinho($idProduto);
        $this->carregarPagina("v_carrinho");
    }

    public function produtos() {
        if (!$this->estaLogado()) {
            header("Location:".BASE_URL);

        } else {
            $this->addTituloPagina("Listar Produtos");
            
            $this->addDadosPagina(
                "produtos",
                array("Monitor", "Placa mãe", "Memória RAM","opa")
            );

            $this->carregarPagina("produtos");
        }
    }
    
    public function sobre() {
        echo __FUNCTION__;
    }

    public function erro404() {
        $this->carregarPagina("v_erro404");
    }
}
