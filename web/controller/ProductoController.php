<?php

include_once __DIR__ .'/../controller/Controller.php';

class ProductoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cargarArchivos()
    {
        parent::cargarArchivos();
        require_once __DIR__ . '/../model/Producto.php';
        require_once __DIR__ . '/../model/Categoria.php';
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
        $categoria = new Categoria($this->conexion);
        $categorias = $categoria->getAll();
        $producto = new Producto($this->conexion);
        $productos = $producto->getAll();
        $categorias = $this->formatData($categorias, $productos);
        /*Recoger la cantidad de productos que hay en el carrito almacenados en cookies*/
        $total = 0;
        if(isset($_COOKIE['cart']))
        {
            $cart = unserialize($_COOKIE['cart'], ["allowed_classes" => false]);
            foreach ($cart as $cuantity){
                $total += $cuantity['cantidad'];
            }
        }
        $this->twigView('catalogoView.php.twig', ["categorias"=>$categorias, "cartCuantity" => $total]);

    }

    public function formatData($categorias, $productos)
    {
        /*
        $tmp = null;
        $array = array();
        foreach ($productos as $producto) {
            if($tmp != $producto['categoria_idcategoria'] && $tmp != null){
                array_push($categorias[$tmp], $array);
                echo '<br/><br/><br/><br/>';
                var_dump($array);
                $array = array();
            }
            $tmp = $producto['categoria_idcategoria'];
            for($x = 0; $x<count($categorias); $x++)
            {
                if ($categorias[$x]['idcategoria'] == $producto['categoria_idcategoria']) {
                    array_push($array, $producto);
                    $x = count($categorias);
                }
            }
        }
        */
        foreach ($categorias as $x => $categoria){
            $array = array();
            foreach ($productos as $y => $producto){
                if($categoria['idcategoria'] == $producto['categoria_idcategoria']){
                    array_push($array, $producto);
                    unset($productos[$y]);
                }
            }
            $categorias[$x]['productos'] = $array;
        }
        return $categorias;
    }

    public function addCart(){
        if(!isset($_COOKIE['cart']))
        {
            $cart = ['0' => ['id' => $_POST['id'], 'cantidad' => $_POST['cantidad']]];
        }
        else
        {
            $cart = unserialize($_COOKIE['cart'], ["allowed_classes" => false]);
            $key = max(array_keys($cart)) + 1;
            $cart[$key] = ['id' => $_POST['id'], 'cantidad' => $_POST['cantidad']];
        }
        setcookie('cart', serialize($cart), time()+604800);
        die;
    }
}