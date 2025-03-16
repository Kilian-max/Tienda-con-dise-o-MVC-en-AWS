<?php
$producto = $data;

echo '
<section class="hero mt-auto">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-vcentered is-centered">
                <div class="column is-5">
                    <figure class="image image is-4by3">
                        <img src="assets/'. $producto->Imagen .'" alt="'. $producto->Nombre .'" class="producto-imagen">
                    </figure>
                </div>

                <div class="column is-5">
                    <div class="box" style="padding: 1.64rem;">
                        <h1 class="title is-3 has-text-dark mb-4">' . $producto->Nombre . '</h1>

                        <p class="is-size-4 has-text-weight-bold has-text-primary mb-4">' . $producto->Precio . '€</p>

                        <p class="has-text-grey mb-4">Categoría: <span class="has-text-dark">' . $producto->Categoria . '</span></p>

                        <div class="content">
                            <h2 class="subtitle is-5 has-text-weight-semibold mb-3">Descripción</h2>
                            <p class="has-text-justified">' . $producto->Descripcion_max . '</p>
                        </div>

                        <a href="index.php?controller=ProductoController&action=añadirCarrito&id=' . $producto->Id . '" class="button is-primary is-fullwidth is-medium mt-4">Añadir al carrito</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>';
?>