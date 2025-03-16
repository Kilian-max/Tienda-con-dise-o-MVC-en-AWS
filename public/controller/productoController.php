<?php
session_start();  #Iniciamos la sesión para gestionar autenticación y carrito

include './views/view.php';
include './models/productos.php';

class ProductoController {

    #Método para mostrar la página de login
    public function login() {
        View::show('login', null);
    }

    #Método para mostrar la página del carrito de compras
    public function carrito() {
        View::show('carrito', null);
    }

    # Método para comprobar si el usuario se puede loguear
    public function processLogin() {
        if (isset($_POST['continuar'])) {  #Comprobamos si se envió el formulario
            $errores = [];  #Array para almacenar errores

            # Validación de campos
            if (empty($_POST['Gmail'])) {
                $errores['Gmail'] = "El email no puede estar vacío.";
            }
            if (empty($_POST['Contrasenia'])) {
                $errores['Contrasenia'] = "La contraseña no puede estar vacía.";
            }

            #Si no hay errores, intentamos iniciar sesión
            if (empty($errores)) {
                $loginDAO = new ProductosDAO();
                $user = $loginDAO->login($_POST['Gmail'], $_POST['Contrasenia']);  #Verificamos credenciales

                if ($user) {  
                    $_SESSION['user'] = $user;  #Guardamos el usuario en sesión
                    header('Location: ./index.php');
                    exit();
                } else {
                    $errores['general'] = "Correo o contraseña incorrectos."; #Si falla la autentificación saldrá este mensaje
                }
            }

            #Mostraremos la página con los errores si los tiene
            View::show("login", $errores);
        }
    }

    # Metodo para cerrar sesión
    public function deslogearte() {

        session_destroy();  // Destruye la sesión

        header('Location: ./index.php');

    }

    #Mostrar productos para el administador
    public function editarProductos() {
        $prodDAO = new ProductosDAO();
        $array_productos = $prodDAO->listarProductosAdmin();
        View::show('editarProductos', $array_productos);
    }

    #Mostrar productos para usuarios
    public function listarProductos() {
        $prodDAO = new ProductosDAO();
        $array_productos = $prodDAO->listarProductosUsuario();
        View::show('listarProductos', $array_productos);
    }

    #Mostrar detalles de un producto
    public function masProductos() {
        if (isset($_REQUEST['id'])) {  #Obtiene el valor de la id de la url
            $id = $_REQUEST['id'];
            $prodDAO = new ProductosDAO();
            $producto = $prodDAO->productoMasInfo($id);
            View::show('masProductos', $producto);
        }
    }

    # Filtrar productos por categoría
    public function filtrarProductos() {
        if (isset($_REQUEST['value'])) {  #Obtiene el valor del value de la url
            $value = $_REQUEST['value'];
            $prodDAO = new ProductosDAO();
            $array_productos = $prodDAO->filtrarProductos($value);
            View::show('listarProductos', $array_productos);
        }
    }

    #Metodo que agregar un nuevo producto al inventario
    public function addProduct() {
        $errores = [];

        if (isset($_POST['insertar'])) {  #Comprobamos si se envió el formulario
            #Si pasamos un campo vacio en el formulario saldrá el error indicado
            if (empty($_POST['nombre'])) $errores['nombre'] = "El nombre no puede estar vacío.";
            if (empty($_POST['imagen'])) $errores['imagen'] = "La imagen no puede estar vacía.";
            if (empty($_POST['cantidad'])) $errores['cantidad'] = "La cantidad no puede estar vacía.";
            if (empty($_POST['precio'])) $errores['precio'] = "El precio no puede estar vacío.";
            if (empty($_POST['categoria'])) $errores['categoria'] = "La categoría no puede estar vacía.";
            if (empty($_POST['descripcion_min'])) $errores['descripcion_min'] = "Descripción corta vacía.";
            if (empty($_POST['descripcion_max'])) $errores['descripcion_max'] = "Descripción completa vacía.";

            if (empty($errores)) {
                $pDAO = new ProductosDAO();
                if ($pDAO->addProduct($_POST['nombre'], $_POST['imagen'], $_POST['cantidad'], $_POST['precio'], $_POST['categoria'], $_POST['descripcion_min'], $_POST['descripcion_max'])) {
                    $this->editarProductos();
                } else {
                    $errores['general'] = "Problemas al insertar.";
                    View::show("addProduct", $errores);
                }
            } else {
                View::show("addProduct", $errores);
            }
        } else {
            View::show("addProduct", null);
        }
    }

    #Metodo que eliminar un producto del inventario por el id
    public function eliminarProducto() {
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $pDAO = new ProductosDAO();
            if ($pDAO->eliminarProducto($id)) {
                $this->editarProductos();
            } else {
                echo "Error al eliminar el producto";
            }
        }
    }

    #Metedo para añadir un producto al carrito
    public function añadirCarrito() {
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
            $prodDAO = new ProductosDAO();
            $producto = $prodDAO->productoMasInfo($id);

            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }
            $_SESSION['carrito'][] = $producto;  #Mete el producto a la session del carrito
            $this->masProductos();
        }
    }

    #Metodo para eliminar un producto del carrito
    public function eliminarProductoCarrito() {
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];

            foreach ($_SESSION['carrito'] as $indice => $producto) { #Por cada producto del carrito comprueba que sea igual al id
                if ($producto->Id == $id) { # Y si es igual
                    unset($_SESSION['carrito'][$indice]);  #Elimina el producto
                    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                    break;
                }
            }
        }
        $this->carrito();
    }

    #Finalizar compra
    public function finalizarCompra() {
        if (isset($_SESSION['user'])) {  #Si el usuario está logueado
            if (isset($_SESSION['carrito'])) {
                unset($_SESSION['carrito']);  #Vaciamos el carrito
            }
            View::show("finalizarCompra", null);
        } else {
            $this->login(); #Sino le mandamos a loguearse

        }
    }
}
?>
