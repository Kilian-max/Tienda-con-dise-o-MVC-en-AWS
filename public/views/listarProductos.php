<?php
echo '
<div class="hero mt-auto">
    <div class="hero-body" style="padding-top: 1rem; padding-bottom: 1rem;">
        <div class="container">
            <div class="columns is-multiline is-centered">';

                foreach ($data as $producto) {
                    echo '
                <div class="column is-3-tablet is-2-desktop">
                    <a href="index.php?controller=ProductoController&action=masProductos&id=' . $producto->Id . '" class="is-block" style="text-decoration: none; color: inherit;">
                        <div class="card has-text-centered shadow" style="border-radius: 10px; transition: transform 0.3s; display: flex; flex-direction: column; height: 310px; padding: 0.75rem;">
                            <!-- Imagen -->
                            <div class="mb-2" style="height: 100px; display: flex; align-items: center; justify-content: center;">';
            
                                if (isset($producto->Imagen) && !empty($producto->Imagen)) {
                                    echo '
                                <figure class="image is-100x100">
                                    <img src="./assets/' . $producto->Imagen . '" alt="' . $producto->Nombre . '" style="border-radius: 10px; max-height: 100px; width: auto;">
                                </figure>';
                                } else {
                                    echo '
                                <p class="has-text-grey-light">Sin imagen</p>';
                                }
                                    echo '
                            </div>

                            <!-- Título -->
                            <h5 class="title is-5 mb-1" style="height: 2.5rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                <span class="has-text-dark has-text-weight-bold">
                                    ' . $producto->Nombre . '
                                </span>
                            </h5>

                            <!-- Descripción -->
                            <div class="mb-3" style="height: 6rem; overflow: hidden;">
                                <p class="has-text-grey" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                    ' . $producto->Descripcion_min . '
                                </p>
                            </div>

                            <!-- Precio -->
                            <div class="mt-auto mb-2">
                                <span class="tag is-dark is-medium" style="border-radius: 20px;">' . $producto->Precio . '€</span>
                            </div>
                        </div>
                    </a>
                </div>';
}

echo '
            </div>
        </div>
    </div>
</div>';
?>