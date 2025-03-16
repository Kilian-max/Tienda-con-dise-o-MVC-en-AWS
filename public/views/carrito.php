<?php
#Si el carrito está creado, añade el producto al carrito y si no está creado, lo crea 
if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
} else {
    $carrito = [];
}

#Calcular el total de la compra
$total = 0;
foreach ($carrito as $producto) {
    $total += $producto->Precio;
}

echo '
<section class="section">
    <div class="container">
        <h1 class="title has-text-centered">Tu Carrito</h1>';

if (!empty($carrito)) {
    echo '
    <div class="columns is-centered">
        <div class="column is-5">
            <div class="box">';
    foreach ($carrito as $producto) {
        echo '
        <div class="media">
            <div class="media-left">
                <figure class="image is-96x96">
                    <img src="assets/' .$producto->Imagen . '" alt="' . $producto->Nombre . '">
                </figure>
            </div>
            <div class="media-content">
                <div class="content">
                    <p class="title is-4">' . $producto->Nombre . '</p>
                    <p class="subtitle is-5 has-text-primary">' . $producto->Precio . '€</p>
                </div>
            </div>
            <div class="media-right">
                <a href="index.php?controller=ProductoController&action=eliminarProductoCarrito&id=' . $producto->Id . '" class="button is-danger">Eliminar</a>
            </div>
        </div>
        <hr>';
    }
    echo '
            </div>
        </div>
    </div>';

    echo '
    <div class="columns is-centered">
        <div class="column is-5 has-text-centered ">
            <div class="box ">
                <p class="title is-4 ">Total de la compra: <span class="has-text-primary">' .$total . '€</span></p>
            </div>
        </div>
    </div>';
} else {
    echo '
    <div class="columns is-centered">
        <div class="column is-5 has-text-centered">
            <div class="notification is-warning" style="max-width: 500px; margin: 0 auto;">
                Tu carrito está vacío.
            </div>
        </div>
    </div>';
}

echo '
    <div class="columns is-centered mt-4">
        <div class="column is-2 has-text-centered">
            <a href="./index.php" class="button is-dark is-fullwidth">Volver a la tienda</a>
        </div>
        <div class="column is-2 has-text-centered">
            <a href="index.php?controller=ProductoController&action=finalizarCompra" class="button is-success is-fullwidth">Terminar compra</a>
        </div>
    </div>
    </div>
</section>';
?>