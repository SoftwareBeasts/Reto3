<?php

include_once __DIR__ .'/../controller/Controller.php';

class ProductoController extends Controller
{
    /**
     * ProductoController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Carga los archivos necesarios para el controlador
     */
    public function cargarArchivos()
    {
        parent::cargarArchivos();
        require_once __DIR__ . '/../model/Producto.php';
        require_once __DIR__ . '/../model/Categoria.php';
    }

    /**
     * Ejecuta la funcion que se le pase como parametro
     * @param string $action
     * @param null $id
     */
    public function run($action = 'defaultCase', $id = null)
    {
        parent::run($action, $id);
    }

    /**
     * Llama a la funcion de twig que renderiza la pagina que se le pase como parametto, con los datos que se le envien
     * @param string $page la pagina a mostrar
     * @param array $data los datos qye necesita la pagina
     */
    public function twigView($page, $data=["a"=>"a"])
    {
        parent::twigView($page, $data);
    }

    /**
     * Llama a la funcion que se encarga de enviar un email al usuario
     * @param string $userEmail detinatario
     * @param $type el tipo del email
     * @param $datosEmail array los datos del email
     */
    public function enviarEmail($userEmail, $type, $datosEmail){
        parent::enviarEmail($userEmail, $type, $datosEmail);
    }

    /**
     * Si no se encuentra ninguna accion se ejecutara esta por defecto
     */
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

    /**
     * Ordena los productos por categorias
     * @param $categorias array con las categorias
     * @param $productos array con los productos
     * @return mixed
     */
    public function formatData($categorias, $productos)
    {
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

    /*----------------------------------*/
    /*ADMIN CATALOGO*/


    /**
     * Carga la vista de administrador, si no se esta como administradror, redirige a la pagina principal
     */
    public function adminCatalogoView(){
        if(parent::verifyAdmin()){
            $categoria = new Categoria($this->conexion);
            $categorias = $categoria->getAll();
            $producto = new Producto($this->conexion);
            $productos = $producto->getAll();
            $categorias = $this->formatData($categorias, $productos);
            $this->twigView('catalogoAdminView.php.twig', ["categorias"=>$categorias,"admin"=>$_SESSION['admin']]);
        }else{
            header("Location: index.php?controller=producto");
        }
    }

    /**
     * Añade un producto a la base de datos, con los atributos que tenga el producto
     */
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

    /**
     * Elimina un producto de la base de datos, con el id que tenga el Objeto
     */
    public function deleteProducto(){
        if(parent::verifyAdmin()){
            $producto = new Producto($this->conexion);
            $producto->setId($_POST['id']);
            $producto->delete();
        }else{
            header("Location: index.php?controller=producto");
        }
    }

    /**
     * Actualiza un producto de la base de datos con los parametros que tenga el producto y la id que se le pase
     */
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

    /**
     * Verifica si se ha subido la imagen para insertarla, y si no, pone la default
     * @return string
     */
    public function tratarImagen(){
        if(!is_uploaded_file($_FILES['imagen']['tmp_name'])){
            $_POST['imagen'] = "./view/media/productImg/default_product.jpg";
        }
        else{
            $imagen = $this->aImagen();
            return $imagen;
        }
    }

    /**
     * Guarda la imagen en el directorio de imagenes de productos y le cambia el nombre.
     * @return string
     */
    public function aImagen(){
            $file = pathinfo($_FILES['imagen']['name']);
            $extension = $file['extension'];
            //Se le establece el nombre del producto a la imagen
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