<?php
include('./db/database.php');

class ProductosDAO {

    private $dbh;

    public function __construct() {
        $this->dbh = Database::open_connection(); #Llamamos a la clase Databse con su método para conectarnos a la base de datos
    }

    # Método para iniciar sesión en el sistema.
    public function login($gmail, $contraseña) {
        # Prepara la consulta SQL para obtener el usuario con el correo proporcionado
        $stmt = $this->dbh->prepare("SELECT * FROM Login WHERE Gmail = :Gmail");

        # Le asignamos el valor de la variable $gmail a :Gmail
        $stmt->bindParam(":Gmail", $gmail);

        # Ejecuta la consulta
        $stmt->execute();

        # Obtiene el usuario en formato de array asociativo
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        # Si el usuario existe y la contraseña coincide, lo retorna
        if ($user && $contraseña == $user["Contrasenia"]) {
            return $user;
        }

        return false;
    }

    # Método para obtener la lista de productos visible para los usuarios normales
    public function listarProductosUsuario() {
        try {
            # Consulta para obtener los productos visibles al usuario
            $stmt = $this->dbh->prepare("SELECT Id, Nombre, Imagen, Precio, Descripcion_min FROM Productos");

            # Configura el modo de obtención de resultados como objetos
            $stmt->setFetchMode(PDO::FETCH_OBJ);

            # Ejecuta la consulta
            $stmt->execute();

            # Retorna el listado de productos
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    # Método para obtener la lista de productos con más detalles para el administrador
    public function listarProductosAdmin() {
        try {
            # Consulta para obtener más detalles de los productos
            $stmt = $this->dbh->prepare("SELECT Id, Nombre, Imagen, Precio, Categoria, Cantidad, Descripcion_min, Descripcion_max FROM Productos");

            # Configura el modo de obtención de resultados como objetos
            $stmt->setFetchMode(PDO::FETCH_OBJ);

            # Ejecuta la consulta
            $stmt->execute();

            # Retorna el listado de productos
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    # Método para obtener información detallada de un producto por su id
    public function productoMasInfo($id) {
        try {
            # Consulta para obtener la información de un producto específico por su Id
            $stmt = $this->dbh->prepare("SELECT Id, Nombre, Imagen, Precio, Descripcion_max, Categoria FROM Productos WHERE Id = :Id");

            # Asigna el ID como parámetro en la consulta
            $stmt->bindParam(':Id', $id, PDO::PARAM_INT);

            # Configura el modo de obtención como objeto
            $stmt->setFetchMode(PDO::FETCH_OBJ);

            # Ejecuta la consulta
            $stmt->execute();

            # Retorna la información del producto
            return $stmt->fetch();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    # Método para filtrar productos por categoría
    public function filtrarProductos($value) {
        try {
            # Consulta para obtener productos de una categoría específica
            $stmt = $this->dbh->prepare("SELECT Id, Nombre, Imagen, Precio, Descripcion_min FROM Productos WHERE Categoria = :Categoria");

            # Asigna el valor de la categoría al parámetro
            $stmt->bindParam(':Categoria', $value);

            # Configura el modo de obtención como objeto
            $stmt->setFetchMode(PDO::FETCH_OBJ);

            # Ejecuta la consulta
            $stmt->execute();

            # Retorna los productos filtrados
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    # Método para agregar un nuevo producto a la base de datos
    public function addProduct($nombre, $imagen, $cantidad, $precio, $categoria, $descripcion_min, $descripcion_max) {
        try {
            # Consulta para insertar un nuevo producto en la base de datos
            $stmt = $this->dbh->prepare("INSERT INTO Productos (Nombre, Imagen, Cantidad, Precio, Categoria, Descripcion_min, Descripcion_max) VALUES (:Nombre, :Imagen, :Cantidad, :Precio, :Categoria, :Descripcion_min, :Descripcion_max)");

            # Asigna los valores a los parámetros
            $stmt->bindParam(':Nombre', $nombre);
            $stmt->bindParam(':Imagen', $imagen);
            $stmt->bindParam(':Cantidad', $cantidad);
            $stmt->bindParam(':Precio', $precio);
            $stmt->bindParam(':Categoria', $categoria);
            $stmt->bindParam(':Descripcion_min', $descripcion_min);
            $stmt->bindParam(':Descripcion_max', $descripcion_max);

            # Ejecuta la consulta y retorna `true` si fue exitosa
            return $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    # Método para eliminar un producto de la base de datos por su id
    public function eliminarProducto($id) {
        try {
            # Consulta para eliminar un producto por su Id
            $stmt = $this->dbh->prepare("DELETE FROM Productos WHERE Id = :Id");

            # Asigna el ID al parámetro en la consulta.
            $stmt->bindParam(':Id', $id, PDO::PARAM_INT);

            # Ejecuta la consulta y retorna `true` si fue exitosa
            return $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false; # Retorna `false` si hubo un error
        }
    }
}
?>
