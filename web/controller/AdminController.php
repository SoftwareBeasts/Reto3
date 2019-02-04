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

    public function __construct()
    {
        parent::__construct();
    }


    public function cargarArchivos()
    {
        parent::cargarArchivos();
        require_once __DIR__ . '/../model/Administrador.php';
        require_once __DIR__ . '/../model/Producto.php';
    }

    public function run($action = 'defaultCase', $id = null)
    {
        parent::run($action, $id);
    }

    public function twigView($page, $data=["a"=>"a"])
    {
        parent::twigView($page, $data);
    }

    public function viewLogin(){
        if(!isset($_SESSION['admin']))
            $this->twigView('loginAdminView.php.twig');
        else
            header("Location: index.php?controller=producto&action=adminCatalogoView");
    }

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
            header("Location: index.php?controller=producto&action=adminCatalogoView&t");

            /*Hay que mirar en el controlller de pedido cuando se accedan a las acciones
            de administrador que
            la sesion esta iniciada correctamente
            de momento lleva al catalogo*/
        }
    }

    public function pedidos(){
        if (parent::verifyAdmin()){
            header("Location: index.php?controller=pedido&action=adminPedidosView&c=true");
        }else{
            $this->toIndex();
        }
    }

    public function catalogo(){
        if (parent::verifyAdmin()){
            header("Location: index.php?controller=producto&action=adminCatalogoView&c=true");
        }else{
            $this->toIndex();
        }
    }

    public function showStats(){
        if(parent::verifyAdmin())
        {
            $this->twigView('statsAdminView.php.twig');
            //$this->getStats();
        }
        else
             $this->toIndex();
    }

    public function getStats()
    {
        if(parent::verifyAdmin())
        {
            $producto = new Producto($this->conexion);
            $stats = $producto->getAllStats();
            $x = array();
            $y= array();
            foreach ($stats as $stat)
            {
                array_push($x, $stat['nombre']);
                array_push($y, $stat['vecesComprado']);
            }
            $stats = ["x" => $x, "y" => $y];
            //echo json_encode($stats);
            die(json_encode($stats));
        }
    }

    public function logout(){
        if (parent::verifyAdmin()){
            session_destroy();
            session_start();
        }else{
            $this->toIndex();
        }
    }

    public function toIndex(){
        header("Location: index.php?controller=producto");
    }

}