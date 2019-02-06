<?php

session_start();
/*Variable de confirmacion para saber que se esta actuando como administrador*/
if (isset($_GET['t'])){
    $_SESSION['admin']=true;
}

/*No tengo ni idea de para que era esto*/
if (isset ($_SESSION['admin'])&&!isset($_GET['c'])){
   $admin = $_SESSION['admin'];
    header("Location: index.php?controller=pedido&action=adminPedidosView&c=true");
}
/*Obtiene el controllador de la URL, si no encuentra ninguno, se cogera el que este por defecto*/
if(isset($_GET['controller'])){
    $controller = establecerControlador($_GET['controller']);
}
else
    $controller = establecerControlador();
cargarControlador($controller);

/**
 * Hace que el controlador recogido de la URL sea requerido, podiendo usar todas sus funciones
 * @param null $controller el controlador que hay que cargar
 * @return AdminController|CategoriaController|PedidoController|ProductoController
 */
function establecerControlador($controller=null){
    switch ($controller){
        case 'producto':
            $file = 'controller/ProductoController.php';
            requireFile($file);
            $controllerObj = new ProductoController();
            break;
        case 'categoria':
            $file = 'controller/CategoriaController.php';
            requireFile($file);
            $controllerObj = new CategoriaController();
            break;
        case 'admin':
            $file = 'controller/AdminController.php';
            requireFile($file);
            $controllerObj = new AdminController();
        break;
        case 'pedido':
            $file = 'controller/PedidoController.php';
            requireFile($file);
            $controllerObj = new PedidoController();
            break;
        default:
            $file = 'controller/ProductoController.php';
            requireFile($file);
            $controllerObj = new ProductoController();
            break;
    }
    return $controllerObj;
}

/**
 * Requiere el archivo como tal, que se le pasa como parametro
 * @param $file String El nombre del archivo a cargar
 */
function requireFile($file) {
    require_once $file;
}

/**
 * Carga la accion pasada por la url en el controlador que se le pasa como parametro, y la ejecuta
 * @param $controller AdminController|CategoriaController|PedidoController|ProductoController
 */
function cargarControlador ($controller){
    if(isset($_GET['action'])){
        if(isset($_GET['id']))
            $controller->run($_GET['action'], $_GET['id']);
        else
            $controller->run($_GET['action']);
    }
    else
        $controller->run();
}
