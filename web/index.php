<?php
if (isset($_POST['createsession'])){
    if(!isset($_SESSION))
    {
        session_start();
    }
    $_SESSION['admin']=true;
}
if (isset ($_SESSION['admin'])){
   $admin = $_SESSION['admin'];
}

if(isset($_GET['controller'])){
    $controller = establecerControlador($_GET['controller']);
}
else
    $controller = establecerControlador();
cargarControlador($controller);


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
        default:
            $file = 'controller/ProductoController.php';
            requireFile($file);
            $controllerObj = new ProductoController();
            break;
    }
    return $controllerObj;
}

function requireFile($file) {
    require_once $file;
}

function cargarControlador ($controller){
    if(isset($_GET['controller'])){
        $controller->run($_GET['action']);
    }
    else
        $controller->run();
}
