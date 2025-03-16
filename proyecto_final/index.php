<?php
include("controller/productoController.php");

// Punto de entrada a la aplicación. Si no se reciben los parámetros 'action' y 'controller'
// se muestra la página de inicio con el listado de productos.

if (isset($_REQUEST['action']) && isset($_REQUEST['controller'])) {
    $act = $_REQUEST['action'];
    $cont = $_REQUEST['controller'];

    // Instanciación del controlador e invocación del método
    $controller = new $cont();
    $controller->$act();

} 
else {
    // Página de entrada: Listado de productos por defecto
    $controller = new ProductoController();
    $controller->listarProductos();
}


?>
