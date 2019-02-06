<?php
/**
 * Created by PhpStorm.
 * User: 2gdaw08
 * Date: 23/01/2019
 * Time: 9:00
 */

include_once __DIR__ .'/../controller/Controller.php';

class AdminController extends Controller
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Carga los archivos necesarios para este Controlador
     */
    public function cargarArchivos()
    {
        parent::cargarArchivos();
        require_once __DIR__ . '/../model/Administrador.php';
        require_once __DIR__ . '/../model/Producto.php';
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
     * Carga la vista de Login si no se está ya logeado
     */
    public function viewLogin(){
        if(!isset($_SESSION['admin']))
            $this->twigView('loginAdminView.php.twig');
        else
            header("Location: index.php?controller=catalogo&action=adminCatalogoView");
    }

    /**
     * Inicia la sesion como administrador
     */
    public function login(){
        $user = $_POST['usuario'];
        $pass = $_POST['password'];

        $admin = new Administrador($this->conexion);
        $admin->setNombre($user);
        $adminuser = $admin->getByNombre();

        if ($pass != $adminuser['pass']){
            $this->twigView('loginAdminView.php.twig',['falloLogin'=>true]);
        }
        else{
            header("Location: index.php?controller=pedido&action=adminPedidosView&t");

            /*Hay que mirar en el controlller de pedido cuando se accedan a las acciones
            de administrador que
            la sesion esta iniciada correctamente
            de momento lleva al catalogo*/
        }
    }

    /**
     * Carga la vista de administrador de pedidos
     */
    public function pedidos(){
        if (parent::verifyAdmin()){
            header("Location: index.php?controller=pedido&action=adminPedidosView&c=true");
        }else{
            $this->toIndex();
        }
    }

    /**
     * Carga la vista de administrador de catalogo
     */
    public function catalogo(){
        if (parent::verifyAdmin()){
            header("Location: index.php?controller=producto&action=adminCatalogoView&c=true");
        }else{
            $this->toIndex();
        }
    }

    /**
     * Carga la vista de las estadisticas
     */
    public function showStats(){
        if(parent::verifyAdmin())
        {
            $this->twigView('statsAdminView.php.twig');
            //$this->getStats();
        }
        else
             $this->toIndex();
    }

    /**
     * Obtiene las estadisticas
     */
    public function getStats()
    {
        if(parent::verifyAdmin())
        {
            $producto = new Producto($this->conexion);
            $stats = $producto->getAllStats();
            $x = array();
            $y= array();
            $cont = 0;
            foreach ($stats as $stat)
            {
                if(intval($stat['vecesComprado']) > 0)
                {
                    array_push($x, $stat['nombre']);
                    array_push($y, intval($stat['vecesComprado']));
                    $cont++;
                }
                if($cont == 10)
                    break;
            }
            $stats = ["x" => $x, "y" => $y];
            die(json_encode($stats));
        }
    }

    /**
     * Sale de la sesion de administrador, destruyendo la sesion
     */
    public function logout(){
        if (parent::verifyAdmin()){
            session_destroy();
            session_start();
            $this->toIndex();
        }else{
            $this->toIndex();
        }
    }

    /**
     * LLeva a la pagina principal
     */
    public function toIndex(){
        header("Location: index.php?controller=producto");
    }

}