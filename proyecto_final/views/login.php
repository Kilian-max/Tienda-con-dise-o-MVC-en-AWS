<?php
echo '
<div class="hero mt-auto">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-half">';

                                if (!isset($_SESSION['user'])) {
                                    echo '
                        <!-- Caja de inicio de sesión (solo si no está logueado) -->
                        <div class="box login-box">
                            <h2 class="title is-3 has-text-centered">Iniciar sesión</h2>

                            <form class="form" action="index.php?controller=ProductoController&action=processLogin" method="post">
                                <div class="field">
                                    <label class="label" for="Gmail">Correo electrónico:</label>
                                    <div class="control">
                                        <input class="input is-medium" type="text" name="Gmail" placeholder="Correo electrónico*">
                                    </div>';

                                if (isset($data) && isset($data['Gmail'])) {
                                    echo "<div class='notification is-danger'>" . $data['Gmail'] . "</div>";
                                }

                                echo '
                                </div>

                                <div class="field">
                                    <label class="label" for="Contraseña">Contraseña:</label>
                                    <div class="control">
                                        <input class="input is-medium" type="password" name="Contrasenia" placeholder="Contraseña*">
                                    </div>';

                                if (isset($data) && isset($data['Contrasenia'])) {
                                    echo "<div class='notification is-danger'>" . $data['Contrasenia'] . "</div>";
                                }

                                echo '
                                </div>';

                                if (isset($data) && isset($data['general'])) {
                                    echo "<div class='notification is-danger'>" . $data['general'] . "</div>";
                                }
                            }

                                echo '
                                <div class="field">
                                    <div class="control has-text-centered">
                                        <button type="submit" name="continuar" class="button is-primary is-medium">Continuar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
?>