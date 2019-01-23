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
        $cliente = new Cliente();
        $clientes = $cliente->getAll();

        $sinConfirmar = $this->formatData($pedidos,$productos,$clientes);
        $confirmados = $this->formatData();

        $this->twigView('pedidos.php.twig', ["sinConfirmar"=>$sinConfirmar, "confirmados"=>$confirmados]);
    }

    public function formatData($pedidos,$productos,$clientes)
    {
        $sinConfirmar = array();
        foreach ($pedidos as $x => $pedido){
            $array = array();
            foreach ($productos as $y => $producto){
                if($pedidos['idcliente'] == $producto['categoria_idcategoria']){
                    array_push($array, $producto);
                    unset($productos[$y]);
                }
            }
            $categorias[$x]['productos'] = $array;
        }
        return $sinConfirmar;
    }
}