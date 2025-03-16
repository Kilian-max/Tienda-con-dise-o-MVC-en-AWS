<?php
echo '
<div class="is-flex-grow-1">
    <div class="container mt-4">
        <h5 class="title is-4">Introduce los datos del producto:</h5>

        <form action="index.php?controller=ProductoController&action=addProduct" method="post">
            <div class="field">
                <label class="label" for="nombre">Nombre:</label>
                <div class="control">
                    <input class="input" type="text" name="nombre" maxlength="50" value="">
                </div>';

if (isset($data) && isset($data['nombre'])) {
    echo "<div class='notification is-danger'>" . $data['nombre'] . "</div>";
}

echo '
            </div>

            <div class="field">
                <label class="label" for="imagen">Imagen:</label>
                <div class="control">
                    <input class="input" type="text" name="imagen">
                </div>';

if (isset($data) && isset($data['imagen'])) {
    echo "<div class='notification is-danger'>" . $data['imagen'] . "</div>";
}

echo '
            </div>

            <div class="field">
                <label class="label" for="cantidad">Cantidad:</label>
                <div class="control">
                    <input class="input" type="number" name="cantidad">
                </div>';

if (isset($data) && isset($data['cantidad'])) {
    echo "<div class='notification is-danger'>" . $data['cantidad'] . "</div>";
}

echo '
            </div>

            <div class="field">
                <label class="label" for="precio">Precio:</label>
                <div class="control">
                    <input class="input" type="number" name="precio" step="any">
                </div>';

if (isset($data) && isset($data['precio'])) {
    echo "<div class='notification is-danger'>" . $data['precio'] . "</div>";
}

echo '
            </div>

            <div class="field">
                <label class="label" for="categoria">Categoría:</label>
                <div class="control">
                    <input class="input" type="text" name="categoria">
                </div>';

if (isset($data) && isset($data['categoria'])) {
    echo "<div class='notification is-danger'>" . $data['categoria'] . "</div>";
}

echo '
            </div>

            <div class="field">
                <label class="label" for="descripcion_min">Descripción Corta:</label>
                <div class="control">
                    <input class="input" type="text" name="descripcion_min">
                </div>';

if (isset($data) && isset($data['descripcion_min'])) {
    echo "<div class='notification is-danger'>" . $data['descripcion_min'] . "</div>";
}

echo '
            </div>

            <div class="field">
                <label class="label" for="descripcion_max">Descripción Completa:</label>
                <div class="control">
                    <input class="input" type="text" name="descripcion_max">
                </div>';

if (isset($data) && isset($data['descripcion_max'])) {
    echo "<div class='notification is-danger'>" . $data['descripcion_max'] . "</div>";
}

echo '
            </div>

            <div class="columns is-centered mt-4" style="margin-bottom: 40px;">
                <div class="column is-3">
                    <div class="has-text-centered">
                        <input class="button navbar is-dark is-fullwidth" type="submit" name="insertar" value="Añadir">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>';
?>