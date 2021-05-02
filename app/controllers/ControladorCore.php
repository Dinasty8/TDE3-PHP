<?php
namespace App\Controllers;
use App\Models\Produtos;

class ControladorCore {

    private $dadosView = array();
    private $limiteOciosidade = 3600; // segundos
    public $produtos =[];

    public function __construct() {
        $this->verificarOciosidade();
        $p1 = new Produtos (
            'Sumidouro de palheta',
            'Sumidouro de palheta Marca X 1889 EXCLUSIVO! Só tem esse, compre logo que vai acabar!',
            'guitar.jpg','vi2.png','5099,94','5099,94','500','1'
        );
        $p2 = new Produtos (
            'Smartphone top dos top!',
            'Smartphone top dos top!',
            'smartphone.jpg','smartphone.jpg','10.300,00','8999,99','300','1'
        );
        
        $this->produtos = [$p1,$p2];
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

    protected function getProduto($id) {
        return $this->produtos[$id-1];
    }
    protected function getQtd() {
        echo "oiiiii";
    }

    protected function addItemCarrinho($id){ 
        $idProduto = $id - 1;

        if($idProduto >= 0) {
            $produto =$this->produtos[$idProduto];
    
            if (isset($produto)){
                if (isset($_SESSION['cart'][$idProduto])){
                    $_SESSION['cart'][$idProduto]['quantidade']++;
                    header("Location:".'carrinho');
                } else {
                    $_SESSION['cart'][$idProduto] = array(
                        "quantidade"=>1,
                        'nome'=>$produto->getNome(),
                        'descricao'=>$produto->getDescricao(),
                        'preco'=>$produto->getPreco(),
                        'imagem'=>$produto->getImagem()
                    );
                    header("Location:".'carrinho');
                }
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