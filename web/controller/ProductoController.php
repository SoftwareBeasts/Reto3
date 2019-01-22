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

    public function run($action = null, $id = null)
    {
        parent::run($action, $id);
    }

    public function twigView($page, $data)
    {
        parent::twigView($page, $data);
    }

    public function defaultCase(){
        $categoria = new Categoria($this->conexion);
        $categorias = $categoria->getAll();
        $producto = new Producto($this->conexion);
        $productos = $producto->getAll();
        $categorias = $this->formatData($categorias, $productos);
        $this->twigView('catalogo.php.twig', $categorias);

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
        //echo json_encode($categorias);
        return $categorias;
    }
}