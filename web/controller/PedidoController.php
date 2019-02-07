<?php

include_once __DIR__ .'/../controller/Controller.php';

class PedidoController extends Controller
{
    private $sinConfirmar = array();
    private $confirmados = array();

    /**
     * PedidoController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Carga los archivos necesarios para este controlador
     */
    public function cargarArchivos()
    {
        parent::cargarArchivos();
        require_once __DIR__ . '/../model/Pedido.php';
        require_once __DIR__ . '/../model/Producto.php';
        require_once __DIR__ . '/../model/Cliente.php';
        require_once __DIR__ . '/../model/PedidoHasProducto.php';
    }

    /**
     * Llama a la funcion que ejecuta la funcion que se le haya pasado como string
     * @param string $action la funcion a ejecutar
     * @param null $id
     */
    public function run($action = 'defaultCase', $id = null)
    {
        parent::run($action, $id);
    }

    /**
     * Llama a la funcion que llama a twig, para renderizar la pagina que se le pasa como string
     * @param string $page la pagina a cargar
     * @param array $data un array con los datos que necesita esa pagina
     */
    public function twigView($page, $data=["a"=>"a"])
    {
        parent::twigView($page, $data);
    }

    /**
     * Envio de email
     * @param destinatario $userEmail el email del destinatariao
     * @param $type int el tipo de email
     * @param $datosEmail array los datos del email
     */
    public function enviarEmail($userEmail, $type, $datosEmail){
        parent::enviarEmail($userEmail, $type, $datosEmail);
    }

    /**
     * Muestra la pantalla de los pedidos que se han realizado
     */
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

    /**
     * Establece los datos de una manera concreta para la vista
     * @param $pedidos
     * @param $productos
     * @param $clientes
     * @param $pedidoProductos
     */
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

    /**
     * Para recoger el carrito guardado en cookies
     * @return array con los datos del carrrito
     */
    public function getCart()
    {
        return unserialize($_COOKIE['cart'], ["allowed_classes" => false]);
    }

    /**
     * Guarda el carrito en cookies
     * @param $cart array de carrito
     */
    public function setCart($cart)
    {
        setcookie('cart', serialize($cart), time()+604800);
    }

    /**
     * Añadir productos al carrito
     */
    public function addCart()
    {
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

    /**
     * Editar el carrito guardado en cookies
     */
    public function editCart()
    {
        $cart = $this->getCart();
        $keys = array_keys($cart);
        for($x = 0; $x<count($cart); $x++)
        {
            if($cart[$keys[$x]]['id'] == $_POST['id'])
            {
                $cart[$keys[$x]]['cantidad'] = $_POST['cuantity'];
                $x = $keys[intval(count($cart))-1];
            }
        }
        $this->setCart($cart);
        die();
    }

    /**
     * Eliminar producto del carrito o eliminar el carrito de cookies
     * @param null $forceDelete true para borrar el carrito de cookies
     */
    public function deleteCart($forceDelete=null)
    {
        $cart = $this->getCart();
        $count = count($cart);
        $last = false;

        if($forceDelete != null && $forceDelete == true)
            $count = 1;

        if ($count == 1) {
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
        if(!$forceDelete)
            die($last);
    }

    /**
     * Mostrar la ventana de realizar pedido
     */
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

    /**
     * Ordenar el array por ids
     * @param $cart array carrito
     * @return array carrito ordenado
     */
    public function arrayOrder($cart)
    {
        usort($cart, function($a, $b) {
            return $a['id'] <=> $b['id'];
        });
        return $cart;
    }

    /**
     * Guardar pedido en base de datos y enviar email al cliente
     */
    public function realizarPedido()
    {

        try
        {
        if($this->verificarBot())
        {

            //Guardar cliente nuevo
            $cliente = new Cliente($this->conexion, null, $_POST['nombre'], $_POST['email'], $_POST['telefono']);
            $cliente->save();
            $idCliente = $cliente->getIdByEmail()['idCliente'];

            //Guardar datos pedido
            $pedido = new Pedido($this->conexion, null, date($_POST['fecha']), "0", 0, $idCliente);
            $pedido->save();
            $pedidoId = $pedido->getIdByClienteId()['idPedido'];
            $precioTotal = 0;
            $cart = $this->getCart();
            $cartHtml = "";
            foreach ($cart as $producto) //Calcular el precio total consultando a base de datos
            {
                $productId = $producto['id'];
                $productCuantity = $producto['cantidad'];
                $product = new Producto($this->conexion);
                $product->setId($productId);
                $datosProduct = $product->getPrecioAndVecesCompradoByID();
                $precioTmp = intval($datosProduct['precio']) * intval($productCuantity);
                $precioTotal += $precioTmp;

                $cartHtml = $cartHtml . $this->generateCartHtml($datosProduct['nombre'], intval($productCuantity), $precioTmp);

                $pedHprod = new PedidoHasProducto($this->conexion, $pedidoId, $productId, $productCuantity);
                $pedHprod->save();

                //Estadísticas
                $vecesComprado = intval($datosProduct['vecesComprado']) + intval($productCuantity);
                $product->setVecesComprado($vecesComprado);
                $product->saveVecesComprado();

            }
            $this->deleteCart(true);
            $pedido->setPrecioTotal($precioTotal);
            $pedido->savePrecioTotal();
            $datosEmail = ["idPedido" => $pedidoId, "fecha" => $pedido->getFecha(), "cartHtml" =>$cartHtml, "precioTotal" => $precioTotal];
            $this->enviarEmail($cliente->getEmail(), 1, $datosEmail);

            $this->twigView("orderConfirmation.php.twig", ["fechaPedido" => $pedido->getFecha()]);
            header( "refresh:7;url=index.php" );

        }
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * Verificar si es un bot con la API reCaptcha v3 de google
     * @return bool true si no es un bot
     */
    private function verificarBot()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {

            // Build POST request:
            $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
            $recaptcha_secret = '6Lc_-Y4UAAAAAEzgk_ec9FUX4I04eGLxW959c8-T';
            $recaptcha_response = $_POST['recaptcha_response'];

            // Make and decode POST request:
            $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
            $recaptcha = json_decode($recaptcha);

            $verified = false;
            if ($recaptcha->score >= 0.5)
                $verified = true;
            return $verified;

        }
    }

    /**
     * Genera el html de los productos que se han pedido para enviarle un correo al cliente
     * @param $producto producto
     * @param $cantidad cantidad
     * @param $precio precio
     * @return string html del producto
     */
    private function generateCartHtml($producto, $cantidad, $precio)
    {
        return "<tr style=\"border-bottom: 1px solid #f2f2f2;\"><td style=\"padding: 4px;\">".$producto."</td><td style=\"padding: 4px;\">".$cantidad."</td><td style=\"padding: 4px;\">".$precio."€</td></tr>";
    }

    /**
     * Confirmar el pedido en la pestana de pedidos sin confirmar
     * @param $id id del pedido
     */
    public function confirmarPedido($id)
    {
        if (parent::verifyAdmin()){
            if(isset($_POST['id'])){
                $id = $_POST['id'];
            }
            $pedido = new Pedido($this->conexion);
            $pedido->setId($id);
            $pedido->setEstado(1);
            $pedido->updateEstado();

            $pedido = new Pedido($this->conexion);
            $pedido->setId($id);
            $pedidoData = $pedido->getByID();
            $cliente =  new Cliente($this->conexion);
            $cliente->setId($pedidoData['cliente_idcliente']);
            $clienteData = $cliente->getByID();

            $this->enviarEmail($clienteData['email'],3, ["idPedido" => $id, "fecha" => $pedidoData['fecha']]);
//        header('Location: /index.php?controller=pedido');
            die();
        }else{
            header("Location: index.php?controller=producto");
        }
    }

    /**
     * Eliminar de base de datos el pedido porque se ha denegado o porque ya ha finalizado
     * @param $idPedido id del pedido
     */
    public function rechazarFinalizarPedido($idPedido)
    {
        if (parent::verifyAdmin()){
            if(isset($_POST['id'])){
                $idPedido = $_POST['id'];
            }
            $a = new PedidoHasProducto($this->conexion);
            $a->setIdPedido($idPedido);
            $articulos = $a->deleteByID();

            $p = new Pedido($this->conexion);
            $p->setId($idPedido);
            $pedido = $p->getByID();

            $c = new Cliente($this->conexion);
            $c->setId($pedido['cliente_idcliente']);
            $cliente = $c->deleteByID();

            $p = new Pedido($this->conexion);
            $p->setId($idPedido);
            $pedido = $p->deleteByID();

//        header('Location: /index.php?controller=pedido');
            die();
        }else{
            header("Location: index.php?controller=producto");
        }
    }

    /**
     * Enviar un email personalizado
     */
    public function customEmail()
    {
        if (parent::verifyAdmin()) {
            if (isset($_POST['email'])) {$email = $_POST['email'];}
            if (isset($_POST['asunto'])) {$asunto = $_POST['asunto'];}
            if (isset($_POST['contenido'])) {$contenido = $_POST['contenido'];}

            $this->enviarEmail($email, 4,["asunto" => $asunto, "mensaje" => $contenido]);
        }else{
            header("Location: index.php?controller=producto");
        }
    }
}