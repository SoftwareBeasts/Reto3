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

    }

    public function adminPedidosView()
    {
        if (parent::verifyAdmin()){
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
            $alldata['Confirmados'] = $this->confirmados;

//        echo json_encode($alldata);
            $this->twigView('pedidoAdminView.php.twig', ["pedidos"=>$alldata]);
        }else{
            header("Location: index.php?controller=pedido&action=adminPedidosView");
        }

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
                    foreach ($productos as $e => $producto){
                        if($productoPedido['producto_idproducto'] == $producto['idproducto']){
                            $producto['cantidad'] = $productoPedido['cantidad'];
                            array_push($array, $producto);
                        }
                    }
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


    public function getCart()
    {
        return unserialize($_COOKIE['cart'], ["allowed_classes" => false]);
    }

    public function setCart($cart)
    {
        setcookie('cart', serialize($cart), time()+604800);
    }

    public function addCart(){
        if(!isset($_COOKIE['cart']))
        {
            $cart = ['0' => ['id' => $_POST['id'], 'cantidad' => $_POST['cantidad']]];
        }
        else
        {
            $cart = $this->getCart();
            $saved = false;
            //Mirar si ya esta guradado ese producto y sumarle la cantidad
            for($x = 0; $x<count($cart); $x++)
            {
                if($cart[$x]['id'] == $_POST['id'])
                {
                    $cart[$x]['cantidad'] += $_POST['cantidad'];
                    $saved = true;
                    $x = count($cart);
                }
            }
            //Si anteriormente se ha actualizado la cantidad no se guarda de nuevo
            if(!$saved)
            {
                end($cart);
                $key = intval(key($cart))+1;
                reset($cart);
                $cart[$key] = ['id' => $_POST['id'], 'cantidad' => $_POST['cantidad']];
            }
        }
        $this->setCart($cart);
        die();
    }

    public function deleteCart()
    {
        $last = false;
        $cart = $this->getCart();
        if (count($cart) == 1) {
            unset($_COOKIE['cart']);
            setcookie('cart', null, -1, '/');
            $last = true;
        } else {
            foreach ($cart as $key => $product) {
                if ($product['id'] == $_POST['id']) {
                    unset($cart[$key]);
                    break;
                }
            }
            $this->setCart($cart);
        }
        die($last);
    }

    public function confirmarPedido($id)
    {
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }
        $pedido = new Pedido($this->conexion);
        $pedido->updateEstado($id, 1);
//        header('Location: /index.php?controller=pedido');
        die();
    }
    public function rechazarPedido($id)
    {
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }
        $p = new Pedido($this->conexion);
        $pedido = $p->deleteByID($id);
//        header('Location: /index.php?controller=pedido');
        die();

    }

    public function mostrarCarrito()
    {
        if(isset($_COOKIE['cart']))
        {
            $cart = unserialize($_COOKIE['cart'], ["allowed_classes" => false]);
            $cart = $this->arrayOrder($cart);

            $productosIds = array();
            $productosCuantity = array();
            $cont = 1;

            foreach ($cart as $producto)
            {
                $productosIds["id$cont"] = $producto['id'];
                array_push($productosCuantity, $producto['cantidad']);
                $cont++;
            }
            $producto = new Producto($this->conexion);
            $productos = $producto->getByIDs($productosIds);
            $this->twigView('cartView.php.twig', ["productos" => $productos, "productosCuantity" => $productosCuantity]);
        }
        else
            $this->twigView('cartView.php.twig');
    }

    public function arrayOrder($cart){
        usort($cart, function($a, $b) {
            return $a['id'] <=> $b['id'];
        });
        return $cart;
    }
}