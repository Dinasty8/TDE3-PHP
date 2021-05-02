<?php
namespace App\Controllers;

class ControladorCore {

    private $dadosView = array();
    private $limiteOciosidade = 3600; // segundos
    private $currentProd;


    public $produtos = array(
        ['quantidade' =>"5",'nome'=>'Sumidouro de palheta','imagem' =>"guitar.jpg",'imagem2' =>"vi2.png",'descricao'=>"Sumidouro de palheta Marca X 1889 EXCLUSIVO! Só tem esse, compre logo que vai acabar!","precoant"=>"5099,94","preco"=>"849,99","desconto"=>"500" ],
        ['quantidade' =>"5",'nome'=>'Smartphone top dos top!','imagem' =>"smartphone.jpg",'imagem2' =>"smartphone.jpg",'descricao'=>"Smartphone top dos top!","precoant"=>"10.300,00","preco"=>" 8999,99","desconto"=>"300"]
    );

    public function __construct() {
        $this->verificarOciosidade();
     
    }

    protected function carregarPagina($nomeView) {
        $dadosView = $this->dadosView;
        require_once PATH_VIEW."v_header.php";
        require_once PATH_VIEW."$nomeView.php";
        require_once PATH_VIEW."v_footer.php";
        
    }
    
    /* INÍCIO CONTROLE DE VARIÁVEIS NAS VIEWS */

    protected function addTituloPagina($valor) {
        $this->dadosView['tituloPagina'] = $valor;
    }

    protected function addDadosPagina($nomeVariavel, $valor) {
        $this->dadosView[$nomeVariavel] = $valor;
    }

    protected function addProdutosPagina() {
        $this->dadosView['produtos'] = $this->produtos;
    }

    protected function getProduto() {
        return $this->produtos[$this->currentProd-1];
    }

    
    public function setCurrentProd($current) {
        $this->currentProd = $current;
        return $this;
    }

    public function getCurrentProd() {
        return $this->currentProd || -1;
    }

    protected function addItemCarrinho(){ 

        // $_SESSION['cart'] = $produtos;
        $idProduto = $this->getCurrentProd()-1;
        $produto =$this->produtos[$idProduto];

        echo $this->currentProd;
        echo $idProduto;
    
        if ($this->currentProd && $produto){
            if (isset($_SESSION['cart'][$idProduto])){
                $_SESSION['cart'][$idProduto]['quantidade']++;
                $this->setCurrentProd(-1);
            } else {
                $_SESSION['cart'][$idProduto] = array(
                    "quantidade"=>1,
                    'nome'=>$produto['nome'],
                    'descricao'=>$produto['descricao'],
                    'preco'=>$produto['preco'],
                    'imagem'=>$produto['imagem']
                );
                $this->setCurrentProd(-1);
            }
        }
    }

    /* FINAL CONTROLE DE VARIÁVEIS NAS VIEWS */


    /* INÍCIO CONTROLE DE LOGIN */

    protected function logarUsuario($usuario) {
        session_regenerate_id();
        $_SESSION['usuario-sistema'] = serialize($usuario);
        $_SESSION['ultimo-acesso'] = time();
    }
    
    protected function deslogarUsuario() {
        unset($_SESSION['usuario-sistema']);
        unset($_SESSION['ultimo-acesso']);
        session_destroy();
    }

    protected function estaLogado() {
        return isset($_SESSION['usuario-sistema']) ? true : false;
    }

    private function verificarOciosidade() {
        if ($this->estaLogado()) {
            $tempoOcioso = time() - $_SESSION["ultimo-acesso"];

            if ($tempoOcioso > $this->limiteOciosidade) {
                $this->deslogarUsuario();

            } else {
                $_SESSION["ultimo-acesso"] = time();
            }
        }
    }

    /* FINAL CONTROLE DE LOGIN */
}