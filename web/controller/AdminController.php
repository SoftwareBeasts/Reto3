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
        $this->twigView('loginView.php.twig');
    }

    public function login(){
        $user = $_POST['usuario'];
        $pass = $_POST['password'];

        $admin = new Administrador($this->conexion);
        $adminuser = $admin->getByNombre($user);

        if ($pass != $adminuser['pass']){
            $this->twigView('loginAdminView.php.twig',['falloLogin'=>true]);
        }
        else{
            header("Location: index.php?controller=pedido&action=pedidos");
            /*Hay que mirar en el controlller de pedido cuando se accedan a las acciones
            de administrador que
            la sesion esta iniciada correctamente*/
        }


    }

}