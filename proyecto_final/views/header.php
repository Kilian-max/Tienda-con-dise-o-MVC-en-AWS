<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kilian GG</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="has-background-light is-flex is-flex-direction-column" style="min-height: 100vh;">

    <!-- Header fijo -->
    <header class="navbar is-dark is-fixed-top" style="z-index: 1000;">
        <div class="navbar-brand">
            <a class="navbar-item" href="./index.php">
                <img src="assets/logo.png" alt="Logo" class="image" style="max-height: 60px;">
            </a>
        </div>

        <div class="navbar-menu">
            <div class="navbar-start is-flex is-justify-content-center is-align-items-center" style="flex-grow: 1;">
                <a class="navbar-item" href="index.php?controller=ProductoController&action=filtrarProductos&value=Shooters">Shooters</a>
                <a class="navbar-item" href="index.php?controller=ProductoController&action=filtrarProductos&value=Futbol">Fútbol</a>
                <a class="navbar-item" href="index.php?controller=ProductoController&action=filtrarProductos&value=Consolas">Consolas</a>
                <a class="navbar-item" href="index.php?controller=ProductoController&action=filtrarProductos&value=Aventura">Aventura</a>
                <a class="navbar-item" href="index.php?controller=ProductoController&action=filtrarProductos&value=Novedades">Novedades</a>
            </div>
        </div>

        <div class="navbar-end">
            <a class="navbar-item" href="#">🔍</a>
            <?php if(!isset($_SESSION['user'])): ?>
                <a class="navbar-item" href="index.php?controller=ProductoController&action=login">
                    <span class="icon">👤</span> 
                </a>
            <?php elseif(isset($_SESSION['user']['Funcion']) && $_SESSION['user']['Funcion'] == 'Administrador'): ?>
                <!-- Mostrar botón de Mi Panel si el usuario es Administrador -->
                <a class="navbar-item" href="index.php?controller=ProductoController&action=editarProductos"> 
                    <span>Mi Panel</span>
                </a>
                <!-- Mostrar botón de Mi Cuenta para todos los usuarios logueados -->
                <a class="navbar-item" href="index.php?controller=ProductoController&action=deslogearte">
                    <span>Cerrar sesión</span>
                </a>
            <?php else: ?>
                <!-- Mostrar botón de Mi Cuenta para usuarios normales -->
                <a class="navbar-item" href="index.php?controller=ProductoController&action=deslogearte">
                    <span>Cerrar sesión</span>
                </a>
            <?php endif; ?>
            <a class="navbar-item" href="index.php?controller=ProductoController&action=carrito">🛒</a>
        </div>
    </header>

    <!-- Contenido principal con margen superior -->
    <main style="margin-top: 80px;">
        <!-- Aquí va el contenido de tu página -->
    </main>
