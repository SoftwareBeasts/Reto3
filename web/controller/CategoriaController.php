<?php

include_once __DIR__ .'/../controller/Controller.php';

class CategoriaController extends Controller
{
    /**
     * CategoriaController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Carga los archivos requeridos
     */
    public function cargarArchivos()
    {
        parent::cargarArchivos();
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
     * Carga la funcion que renderiza la vista de twig que se le pase como parametro
     * @param string $page
     * @param array $data
     */
    public function twigView($page, $data=["a"=>"a"])
    {
        parent::twigView($page, $data);
    }

    /**
     * Llama al modelo para añadir una categoria a la base de datos
     */
    public function annadirCategoria(){

        $categoria = new Categoria($this->conexion);
        $categoria->setNombre($_POST['nombre']);
        $categoria->save();
        header("Location: index.php?controller=admin&action=catalogo&c=true");/*Falta hacer en
    producto controller el metodo para cargar la pagina de catalogo de administrador y
    poner aqui el action correspondiente, por motivos de desarrollo, se queda asi*/

    }

    /**
     * Actualiza una categoria de la base de datos en funcion de el id que tenga el objeto
     */
    public function updateCategoria(){
        $categoria = new Categoria($this->conexion);
        $categoria->setNombre($_POST['nombre']);
        $categoria->setId($_POST['id']);
        $categoria->update();
        header("Location: index.php?controller=admin&action=catalogo&c=true");/*Falta hacer en
    producto controller el metodo para cargar la pagina de catalogo de administrador y
    poner aqui el action correspondiente, por motivos de desarrollo, se queda asi*/
    }

    /**
     * Elimina una categoria de la base de datos en funcion del id que tenga el objeto
     */
    public function deleteCategoria(){
        $categoria = new Categoria($this->conexion);
        $categoria->setId($_POST['id']);
        $categoria->delete();
        header("Location: index.php?controller=admin&action=catalogo&c=true");/*Falta hacer en
    producto controller el metodo para cargar la pagina de catalogo de administrador y
    poner aqui el action correspondiente, por motivos de desarrollo, se queda asi*/
    }

}