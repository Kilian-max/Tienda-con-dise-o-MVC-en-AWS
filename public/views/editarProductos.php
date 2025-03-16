<?php
echo '<div class="container mt-5">
    <h2 class="title is-3 has-text-centered">Listado de Productos</h2>
    
    <table class="table is-striped is-bordered is-hoverable is-fullwidth">
        <thead>
            <tr>
                <th class="has-text-centered">ID</th>
                <th class="has-text-centered">Nombre</th>
                <th class="has-text-centered">Imagen</th>
                <th class="has-text-centered">Precio</th>
                <th class="has-text-centered">Categoría</th>
                <th class="has-text-centered">Cantidad</th>
                <th class="has-text-centered">Descripción Corta</th>
                <th class="has-text-centered">Descripción Completa</th>
                <th class="has-text-centered">Acciones</th>
            </tr>
        </thead>
        <tbody>';
            
if (empty($data)) {
    echo '<tr>
        <td colspan="9" class="has-text-centered">No hay productos disponibles</td>
    </tr>';
} else {
    foreach ($data as $producto) {
        echo '<tr>
            <td class="has-text-centered" style="vertical-align: middle;">' . $producto->Id . '</td>
            <td class="has-text-centered" style="vertical-align: middle;">' . $producto->Nombre . '</td>
            <td class="has-text-centered" style="vertical-align: middle;">';
                
            if (isset($producto->Imagen) && !empty($producto->Imagen)) {
                echo '<figure class="image is-128x128 mx-auto" style="display: flex; align-items: center; justify-content: center; height: 100%;"><img src="./assets/' . $producto->Imagen . '" alt="' . $producto->Nombre . '"></figure>';
            } else {
                echo 'Sin imagen';
            }
                
        echo '</td>
            <td class="has-text-centered" style="vertical-align: middle;">' . $producto->Precio . '</td>
            <td class="has-text-centered" style="vertical-align: middle;">' . $producto->Categoria . '</td>
            <td class="has-text-centered" style="vertical-align: middle;">' . $producto->Cantidad . '</td>
            <td class="has-text-centered" style="vertical-align: middle;">' . $producto->Descripcion_min . '</td>
            <td class="has-text-centered" style="vertical-align: middle;">' . $producto->Descripcion_max . '</td>
            <td class="has-text-centered" style="vertical-align: middle;">
                <a href="index.php?controller=ProductoController&action=eliminarProducto&id=' . $producto->Id . '" class="button is-danger is-small">Eliminar</a>
            </td>
        </tr>';
    }
}

echo '</tbody>
    </table>
    
    <a href="index.php?controller=ProductoController&action=addProduct" class="button is-dark is-medium mb-5">Agregar Nuevo Producto</a>
</div>';
?>