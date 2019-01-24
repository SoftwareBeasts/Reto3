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
    }

    public function run($action = 'defaultCase', $id = null)
    {
        parent::run($action, $id);
    }

    public function twigView($page, $data)
    {
        parent::twigView($page, $data);
    }

    public function defaultCase(){
        $pedido = new Pedido($this->conexion);
        $pedidos = $pedido->getAll();
        $producto = new Producto();
        $productos = $producto->getAll();
        $pedidoProducto = new Producto();
        $pedidoProductos = $pedidoProducto->getAll();
        $productos = $producto->getAll();
        $cliente = new Cliente();
        $clientes = $cliente->getAll();

        $alldata = $this->formatData($pedidos,$productos,$clientes,$pedidoProductos);

        $this->twigView('pedidos.php.twig', ["sinConfirmar"=>$this->sinConfirmar, "confirmados"=>$this->confirmados]);
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