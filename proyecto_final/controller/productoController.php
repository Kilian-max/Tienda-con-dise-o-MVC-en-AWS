<?php
session_start();
include './views/view.php';
include './models/productos.php';

    class ProductoController{

            public function login() {

            View::show('login', null);
            }
    

        public function carrito() {

        View::show('carrito', null);
        }
        

        public function processLogin() {
            // Inicializamos el array de errores
            if (isset($_POST['continuar'])) {
                // Inicializamos el array de errores
                $errores = array();
            
                // Validamos los campos
                if (empty($_POST['Gmail'])) {
                    $errores['Gmail'] = "El email no puede estar vacío.";
                }
                if (empty($_POST['Contrasenia'])) {
                    $errores['Contrasenia'] = "La contraseña no puede estar vacía.";
                }
            
                // Si no hay errores, intentamos hacer el login
                if (empty($errores)) {
                    // Instanciamos el DAO de productos o usuarios
                    $login = new ProductosDAO();
            
                    // Verificamos las credenciales
                    $user = $login->login($_POST['Gmail'], $_POST['Contrasenia']);
                    if ($user) {
                        
                        // Si las credenciales son correctas, iniciamos la sesión
                        $_SESSION['user'] = $user;
                        
                        header('Location: ./index.php');
                        exit();
                        }
                        exit();
                    } else {
                        // Si las credenciales son incorrectas, agregamos el error
                        $errores['general'] = "Correo o contraseña incorrectos.";
                    }
                }
            
                // Si hay errores, los mostramos en la vista
                View::show("login", $errores);
            }  
            
            public function deslogearte() {

                if (session_destroy()==true){

                    header('Location: ./index.php');
                }else {

                    echo "Error al deslogearte";
                }
            }
        

        public function editarProductos() {
            $prodDAO = new ProductosDAO();
            $array_productos = $prodDAO->listarProductosAdmin();
        
            View::show('editarProductos', $array_productos);
        }

        public function listarProductos() {
            $prodDAO = new ProductosDAO();
            $array_productos = $prodDAO->listarProductosUsuario();
        
            View::show('listarProductos', $array_productos);
        }
        
        public function masProductos() {
            if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
                
            $prodDAO = new ProductosDAO();
            $producto = $prodDAO->productoMasInfo($id);
            View::show('masProductos', $producto);
            }
        }

        public function filtrarProductos() {
            if (isset($_REQUEST['value'])) {
                $value = $_REQUEST['value'];
                $prodDAO = new ProductosDAO();
                $array_productos = $prodDAO->filtrarProductos($value);

                View::show('listarProductos', $array_productos);
            }
        }


        public function addProduct(){

            $errores=array();

            if (isset($_POST['insertar'])){
                if (!isset($_POST['nombre']) || strlen($_POST['nombre'])==0) 
                    $errores['nombre']="El nombre no puede estar vacío.";
                if (!isset($_POST['imagen']) || strlen($_POST['imagen'])==0) 
                    $errores['imagen']="La imagen no puede estar vacía.";    
                if (!isset($_POST['cantidad']) || strlen($_POST['cantidad'])==0) 
                    $errores['cantidad']="La cantidad no puede estar vacía.";
                if (!isset($_POST['precio']) || strlen($_POST['precio'])==0) 
                    $errores['precio']="El precio no puede estar vacío.";
                if (!isset($_POST['categoria']) || strlen($_POST['categoria'])==0) 
                    $errores['categoria']="La categoria completa no puede estar vacía.";
                if (!isset($_POST['descripcion_min']) || strlen($_POST['descripcion_min'])==0) 
                    $errores['descripcion_min']="La Descripcion corta no puede estar vacía.";
                if (!isset($_POST['descripcion_max']) || strlen($_POST['descripcion_max'])==0) 
                    $errores['descripcion_max']="La Descripcion completa no puede estar vacía.";
                
                if (empty($errores)){
                    $pDAO=new ProductosDAO();
                    if ($pDAO->addProduct($_POST['nombre'], $_POST['imagen'], $_POST['cantidad'],$_POST['precio'],$_POST['categoria'], $_POST['descripcion_min'], $_POST['descripcion_max'])==true){

                        $this->editarProductos(); 
                    }
                         
                    else {
                        $errores['general']="Problemas al insertar";
                        View::show("addProduct", $errores);  
                    }     
                }
                else  View::show("addProduct", $errores);               
            }
            // Si no se pulsó el botón insertar, se muestra la vista con el formulario.
            else {
                View::show("addProduct", null);
                }
            }   

            public function eliminarProducto() {
                if (isset($_REQUEST['id'])) {
                    $id = (int)$_REQUEST['id'];
            
                    // Asegúrate de que el ID sea válido
                        $pDAO = new ProductosDAO();
                        if($pDAO->eliminarProducto($id)==true){

                            $this->editarProductos();
                        } else {
                            // Si hubo un error, mostrar un mensaje
                            echo "Error al eliminar el producto";
                        }
                }
            }  
            
            public function añadirCarrito() {
                // Verificamos si el ID del producto está presente en la solicitud
                if (isset($_REQUEST['id'])) {
                    $id = (int)$_REQUEST['id']; // Aseguramos que el ID sea un entero
            
                    // Instanciamos el DAO de productos
                    $prodDAO = new ProductosDAO();
                    
                    // Obtenemos la información del producto usando el ID
                    $producto = $prodDAO->productoMasInfo($id);
            
                    // Verificamos si el carrito ya existe en la sesión
                    if (!isset($_SESSION['carrito'])) {
                        $_SESSION['carrito'] = []; // Si no existe, lo inicializamos como un array vacío
                    }
                    // Añadimos el producto al carrito
                    $_SESSION['carrito'][] = $producto;
                    $this->masProductos();
                }
            }

            public function eliminarProductoCarrito() {
                // Verificamos si el ID del producto está presente
                if (isset($_REQUEST['id'])) {
                    $id = (int)$_REQUEST['id']; // Convertimos el ID a entero
            
                    // Verificamos si el carrito existe en la sesión
                    if (isset($_SESSION['carrito'])) {
                        // Recorremos el carrito para encontrar el producto con el ID correspondiente
                        foreach ($_SESSION['carrito'] as $indice => $producto) {
                            if ($producto->Id === $id) {
                                // Eliminamos el producto del carrito
                                unset($_SESSION['carrito'][$indice]);
                                // Reindexamos el array para evitar "huecos"
                                $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                                break; // Salimos del bucle una vez eliminado el producto
                            }
                        }
                    }
                }
            
                // Redirigimos al usuario de vuelta al carrito
                $this->carrito();
            }

            public function finalizarCompra() {

                if(isset($_SESSION['user'])) {

                    if(isset($_SESSION['carrito'])) {

                        unset($_SESSION['carrito']);
                    }
                    
                    View::show("finalizarCompra", null);
                    
                } else {

                    $this->login();
                    exit;
                }
            }

 }
?>