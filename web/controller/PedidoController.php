<?php

include_once __DIR__ .'/../controller/Controller.php';

class PedidoController extends Controller
{
    private $sinConfirmar = array();
    private $confirmados = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function cargarArchivos()
    {
        parent::cargarArchivos();
        require_once __DIR__ . '/../model/Pedido.php';
        require_once __DIR__ . '/../model/Producto.php';
        require_once __DIR__ . '/../model/Cliente.php';
        require_once __DIR__ . '/../model/PedidoHasProducto.php';
    }

    public function run($action = 'defaultCase', $id = null)
    {
        parent::run($action, $id);
    }

    public function twigView($page, $data=["a"=>"a"])
    {
        parent::twigView($page, $data);
    }

    public function defaultCase(){
        $pedido = new Pedido($this->conexion);
        $pedidos = $pedido->getAll();

        $producto = new Producto($this->conexion);
        $productos = $producto->getAll();

        $pedidoProducto = new PedidoHasProducto($this->conexion);
        $pedidoProductos = $pedidoProducto->getAll();

        $cliente = new Cliente($this->conexion);
        $clientes = $cliente->getAll();

        $this->formatData($pedidos,$productos,$clientes,$pedidoProductos);

        $alldata = array();
        $alldata['sinConfirmar'] = $this->sinConfirmar;
        $alldata['confirmados'] = $this->confirmados;
//        array_push($this->sinConfirmar, $alldata);
//        array_push($this->confirmados, $alldata);

        $this->twigView('pedidoAdminView.php.twig', ["pedidos"=>$alldata]);
    }

    public function formatData($pedidos,$productos,$clientes,$pedidoProductos)
    {
        foreach ($pedidos as $x => $pedido){

            foreach ($clientes as $y => $cliente){
                if($pedido['cliente_idcliente'] == $cliente['idcliente']){
                    $pedidos[$x]['cliente'] = $cliente;
                }
            }

            $array = array();
            foreach ($pedidoProductos as $i => $productoPedido){
                if($pedido['idpedido'] == $productoPedido['pedido_idpedido']){
                    $prod = array_search($productoPedido['producto_idproducto'],$productos);
                    array_push($array, $prod);

                    $pedidos[$x]['productos']['cantidad'] = $productoPedido['cantidad'];
                }
            }
            $pedidos[$x]['productos'] = $array;

            if($pedido['estado'] == 0){
                array_push($this->sinConfirmar, $pedidos[$x]);
            }else{
                array_push($this->confirmados, $pedidos[$x]);
            }
        }
    }

    public function mostrarCarrito()
    {

    }
}