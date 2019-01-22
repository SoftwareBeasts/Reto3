<?php

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
        /*case 'categoria':
            $file = 'controller/CategoriaController.php';
            requireFile($file);
            $controllerObj = new EventoController();
            break;
        */
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
        if(isset($_GET['id'])){
            if(isset($_GET['from']))
                $controller->run($_GET['action'], $_GET['id'], $_GET['from']);
            else
                $controller->run($_GET['action'], $_GET['id']);
        }
        else
            $controller->run($_GET['action']);
    }
    else
        $controller->run();
}
