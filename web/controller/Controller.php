<?php
/**
 * Created by PhpStorm.
 * User: unaipuelles
 * Date: 21/01/2019
 * Time: 11:54
 */

abstract class controller
{
    public $connection, $conexion, $twig;

    public function __construct()
    {
        $this->cargarArchivos();

        $this->connection = new Connection();
        $this->conexion = $this->connection->conexion();
        $loader = new Twig_Loader_Filesystem('./view/templates');
        $this->twig = new Twig_Environment($loader, ["debug"=>true]);
        $this->twig->addExtension(new Twig_Extension_Debug());
    }

    public function cargarArchivos()
    {
        require_once __DIR__ . '/../core/Connection.php';
        require_once __DIR__ . '/../vendor/autoload.php';
    }

    public function run($action='defaultCase', $id=null)
    {
        $this->$action($id);
    }

    public function twigView($page, $data=["a"=>"a"])
    {
        echo $this->twig->render($page, $data);
    }

    public function verifyAdmin(){

        if (isset($_SESSION['admin'])){
            return true;
        }else{
            return false;
        }

    }
}