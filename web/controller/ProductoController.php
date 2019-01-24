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

    /*----------------------------------*/
    /*ADMIN CATALOGO*/



    public function adminCatalogoView(){
        if(parent::verifyAdmin()){
            $categoria = new Categoria($this->conexion);
            $categorias = $categoria->getAll();
            $producto = new Producto($this->conexion);
            $productos = $producto->getAll();
            $categorias = $this->formatData($categorias, $productos);
            $this->twigView('catalogoAdminView.php.twig', ["categorias"=>$categorias]);
        }else{
            header("Location: index.php?controller=producto");
        }
    }

    public function annadirProducto(){
        if (parent::verifyAdmin()){
            $imagen = $this->tratarImagen();
            $producto = new Producto($this->conexion);
            $producto->setAll($_POST['nombre'],$_POST['descripcion'],$_POST['precio'],$imagen,$_POST['pedidoMin'],$_POST['categoria']);
            $producto->save();
        }else{
            header("Location: index.php?controller=producto");
        }
    }

    public function deleteProducto(){
        if(parent::verifyAdmin()){
            $producto = new Producto($this->conexion);
            $producto->setId($_POST['id']);
            $producto->delete();
        }else{
            header("Location: index.php?controller=producto");
        }
    }

    public function updateProducto()
    {
        if (parent::verifyAdmin()) {
            $producto = new Producto($this->conexion);
            if (!is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                $imagen = $_POST['imagenn'];
            } else {
                $imagen = $this->aImagen();
            }
            $producto->setAll($_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $imagen, $_POST['pedidoMin'], $_POST['categoria']);
            $producto->setId($_POST['id']);
            $producto->update();

        } else {
            header("Location: index.php?controller=producto");
        }
    }

    public function tratarImagen(){
        if(!is_uploaded_file($_FILES['imagen']['tmp_name'])){
            $_POST['imagen'] = "./view/media/productImg/default_product.jpg";
        }
        else{
            $imagen = $this->aImagen();
            return $imagen;
        }
    }
    public function aImagen(){
            $file = pathinfo($_FILES['imagen']['name']);
            $extension = $file['extension'];
            //Se le establece el nombre de usuario a la imagen
            $newname = $_POST['nombre'].".".$extension;
            $target = './view/media/productImg/'.$newname;
            //La imagen se guarda en el directorio especificado
            move_uploaded_file( $_FILES['imagen']['tmp_name'], $target);
            $imagen = './view/media/productImg/'.$newname;
            return $imagen;
    }
    /*ADMIN CATALOGO*/
    /*----------------------------------*/
}