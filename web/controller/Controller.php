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

    /**
     * controller constructor.
     */
    public function __construct()
    {
        $this->cargarArchivos();

        $this->connection = new Connection();
        $this->conexion = $this->connection->conexion();
        $loader = new Twig_Loader_Filesystem('./view/templates');
        $this->twig = new Twig_Environment($loader, ["debug"=>true]);
        $this->twig->addExtension(new Twig_Extension_Debug());
    }

    /**
     *  carga los archivos necesarios
     */
    public function cargarArchivos()
    {
        require_once __DIR__ . '/../core/Connection.php';
        require_once __DIR__ . '/../vendor/autoload.php';
    }

    /**
     * Ejecuta la funcion que tenga por nombre el valor pasado en $action
     * @param string $action nombre de la funcion a ejecutar
     * @param null $id un id por si es necesario
     */
    public function run($action='defaultCase', $id=null)
    {
        $this->$action($id);
    }

    /**
     * Llama a la funcion de twig para renderizar la pagina que se le pase en la variable $page
     * con los datos que se le pasen mediante el array $data
     * @param string $page la pagina que twig tiene que renderizar
     * @param array $data los datos que necesita esa pagina
     */
    public function twigView($page, $data=["a"=>"a"])
    {
        echo $this->twig->render($page, $data);
    }

    /**
     * Verifica que se esté conectado como administrador, de lo contrario, redirige
     * a la pagina principal
     * @return bool
     */
    public function verifyAdmin(){

        if (isset($_SESSION['admin'])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Envia un email con los datos que se le pasen a la funcion
     * @param $userEmail destinatario
     * @param $subject tema
     * @param $body cuerpo del email
     */
    public function enviarEmail($userEmail, $subject, $body){
        require_once __DIR__ . '/../config/plantillasemail.php';
        require_once __DIR__."/../config/sendemail.php";
    }
}