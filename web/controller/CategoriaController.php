<?php

include_once __DIR__ .'/../controller/Controller.php';

class CategoriaController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cargarArchivos()
    {
        parent::cargarArchivos();
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

    public function annadirCategoria(){

        $categoria = new Categoria($this->conexion);
        $categoria->setNombre($_POST['nombre']);
        $categoria->save();
        header("Location: index.php?controller=producto");/*Falta hacer en
    producto controller el metodo para cargar la pagina de catalogo de administrador y
    poner aqui el action correspondiente, por motivos de desarrollo, se queda asi*/

    }

    public function updateCategoria(){
        $categoria = new Categoria($this->conexion);
        $categoria->setNombre($_POST['nombre']);
        $categoria->setId($_POST['id']);
        $categoria->update();
        header("Location: index.php?controller=producto");/*Falta hacer en
    producto controller el metodo para cargar la pagina de catalogo de administrador y
    poner aqui el action correspondiente, por motivos de desarrollo, se queda asi*/
    }

    public function deleteCategoria(){
        $categoria = new Categoria($this->conexion);
        $categoria->setId($_POST['id']);
        $categoria->delete();
        header("Location: index.php?controller=producto");/*Falta hacer en
    producto controller el metodo para cargar la pagina de catalogo de administrador y
    poner aqui el action correspondiente, por motivos de desarrollo, se queda asi*/
    }

}