<?php

include_once __DIR__ .'/../controller/Controller.php';

class PedidoController extends Controller
{
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
        $productoPedido = new Producto();
        $productosdePedidos = $productoPedido->getAll();
        $productos = $producto->getAll();
        $cliente = new Cliente();
        $clientes = $cliente->getAll();

        $sinConfirmar = $this->separarPedidos($pedidos,$productos,$clientes,$productosdePedidos);
        $confirmados = $this->formatData();

        $this->twigView('pedidos.php.twig', ["sinConfirmar"=>$sinConfirmar, "confirmados"=>$confirmados]);
    }

    public function separarPedidos($pedidos,$productos,$clientes,$productosdePedidos)
    {
        $pedidosSeparados = array();

        foreach ($pedidos as $x => $pedido){

            foreach ($clientes as $y => $cliente){
                if($pedido['cliente_idcliente'] == $cliente['idcliente']){
                    $pedidos[$x]['clientes'] = $cliente;
                }
            }

            $pedidos[$x]['productos'] = array();
            foreach ($productosdePedidos as $i => $producto){
                if($pedido['idpedido'] == $producto['pedido_idpedido']){
                    array_push($pedidos[$x]['productos'], $producto);
//                    end() coge el último elemento de el array o FALSE si es NULL
                    $pedidos[$x]['productos'];
                }
            }

//            if($pedido['estado'] == 0){
//                array_push($sinConfirmar, $pedido);
//            }else{
//                array_push($confirmados, $pedido);
//            }
        }
        return $pedidosSeparados;
    }

    public function mostrarCarrito()
    {

    }
}