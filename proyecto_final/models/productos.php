<?php
 include('./db/database.php');
 class ProductosDAO {

    private $dbh;

    public function __construct (){
        $this->dbh=Database::open_connection();
    }

    public function login($gmail, $contraseña) {
        // 1️⃣ Consulta SQL para obtener el usuario por email
        $stmt=$this->dbh->prepare("SELECT * FROM Login WHERE Gmail = :Gmail");
        
        // 3️⃣ Asignamos el valor al parámetro `:email`
        $stmt->bindParam(":Gmail", $gmail);
        
        // 4️⃣ Ejecutamos la consulta
        $stmt->execute();
        
        // 5️⃣ Obtenemos el usuario como un array asociativo
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // 6️⃣ Comparación directa de la contraseña
        if ($user && $contraseña == $user["Contrasenia"]) {
            return $user; // Devuelve los datos del usuario si la contraseña es correcta
        }
    
        return false; // Si no coincide, devuelve `false`
    }

    public function listarProductosUsuario (){
        try{

        $stmt=$this->dbh->prepare("SELECT Id, Nombre, Imagen, Precio, Descripcion_min FROM Productos");
    
        $stmt->setFetchMode(PDO::FETCH_OBJ);
    
        $stmt->execute();
        
        return $stmt->fetchAll();

    }catch(PDOException $e){
        echo $e->getMessage();
        
    }
}
    public function listarProductosAdmin (){
        try{

        $stmt=$this->dbh->prepare("SELECT Id, Nombre, Imagen, Precio, Categoria, Cantidad, Descripcion_min, Descripcion_max FROM Productos");
    
        $stmt->setFetchMode(PDO::FETCH_OBJ);
    
        $stmt->execute();
        
        return $stmt->fetchAll();

    }catch(PDOException $e){
        echo $e->getMessage();
        
    }

 }

 public function productoMasInfo($id) {
    try {
        $stmt=$this->dbh->prepare("SELECT Id, Nombre, Imagen, Precio, Descripcion_max, Categoria FROM Productos WHERE Id = :Id");
        $stmt->bindParam(':Id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 }

 public function filtrarProductos($value) {
    try {
        $stmt=$this->dbh->prepare("SELECT Id, Nombre, Imagen, Precio, Descripcion_min FROM Productos WHERE Categoria = :Categoria");
        $stmt->bindParam(':Categoria', $value);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
 }

 public function addProduct($nombre, $imagen, $cantidad, $precio, $categoria, $descripcion_min, $descripcion_max){
    try{

        $stmt=$this->dbh->prepare("INSERT into Productos (Nombre, Imagen, Cantidad, Precio, Categoria, Descripcion_min, Descripcion_max) values (:Nombre, :Imagen, :Cantidad, :Precio, :Categoria, :Descripcion_min, :Descripcion_max)");      
        
        $stmt->bindParam(':Nombre', $nombre);
        $stmt->bindParam(':Imagen', $imagen);
        $stmt->bindParam(':Cantidad', $cantidad);
        $stmt->bindParam(':Precio', $precio);
        $stmt->bindParam(':Categoria', $categoria);
        $stmt->bindParam(':Descripcion_min', $descripcion_min);
        $stmt->bindParam(':Descripcion_max', $descripcion_max);

            return $stmt->execute();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
 }

 public function eliminarProducto($id) {
    try {
        // Preparar la consulta SQL para eliminar un producto con el ID dado
        $stmt = $this->dbh->prepare("DELETE FROM Productos WHERE Id = :Id");
        
        // Vincular el parámetro ':id' al valor del $id
        $stmt->bindParam(':Id', $id, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        return $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;  // Si ocurre un error, devolvemos false
    }
}
}

?>