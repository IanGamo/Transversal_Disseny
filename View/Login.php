<?php
session_start();
require_once('../Controller/UserController.php');

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctrl = new UserController();

    if (isset($_POST['Login'])) {
        $result = $ctrl->login();
        if ($result === true) {
            header('Location: Home.php');
            exit;
        }
        $error = $result;
    }

    if (isset($_POST['Logout'])) {
        $ctrl->logout();
    }
}

$loggedIn = !empty($_SESSION['logged']);
$userName = htmlspecialchars($_SESSION['usuario_name'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Race&Meet</title>
    <link rel="stylesheet" href="../src/css/Login.css">
    <style>
        /* ── Cookie banner ── */
        #cookie-banner {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: #1a1a1a;
            border-top: 2px solid #ff3131;
            color: #ccc;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            z-index: 1000;
        }
        #cookie-banner p { margin: 0; font-size: 0.9rem; flex: 1; min-width: 200px; }
        #cookie-banner .cookie-btns { display: flex; gap: 10px; flex-wrap: wrap; }
        #cookie-banner button {
            padding: 9px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.88rem;
        }
        #btn-accept { background: #ff3131; color: #fff; }
        #btn-reject { background: #333; color: #ccc; }
        #btn-accept:hover { background: #cc0000; }
        #btn-reject:hover { background: #444; }

        /* Botón "ver aviso cookies" cuando rechazó */
        #btn-show-cookies {
            display: none;
            margin: 16px auto 0 auto;
            background: #333;
            color: #ccc;
            border: 1px solid #ff3131;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
        }
        #btn-show-cookies:hover { background: #444; }
    </style>
</head>
<body>

<!-- ── AVISO COOKIES ── -->
<div id="cookie-banner">
    <p> Usamos cookies para mejorar tu experiencia. ¿Aceptas el uso de cookies?</p>
    <div class="cookie-btns">
        <button id="btn-accept">Aceptar</button>
        <button id="btn-reject">Rechazar</button>
    </div>
</div>

<div class="login-container">

    <?php if ($loggedIn): ?>

        <h2>Bienvenido, <?= $userName ?> </h2>
        <p style="text-align:center; color:#555; margin-bottom:20px;">
            Ya tienes una sesión iniciada.
        </p>
        <a href="Home.php" style="display:block; text-align:center; margin-bottom:12px;
           color:#ff3131; font-weight:bold; text-decoration:none;">
            Ir al inicio →
        </a>
        <form method="POST" action="">
            <button type="submit" name="Logout">Cerrar sesión</button>
        </form>

    <?php else: ?>

        <h2>Login</h2>

        <?php if ($error): ?>
            <div style="color:#ff3131; margin-bottom:15px;
                        font-size:0.9rem; font-weight:bold;">
                 <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Formulario: oculto hasta que se acepten cookies -->
        <div id="login-form-wrapper">
            <form method="POST" action="">
                <div class="input-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" required
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="Login">Iniciar Sesión</button>
                <a href="Registro_user.php" style="display:block; text-align:center;
                   margin-top:14px; color:#ff3131; font-weight:bold; text-decoration:none;">
                    ¿No tienes cuenta? Regístrate aquí →
                </a>
            </form>
        </div>

        <!-- Botón para ver cookies de nuevo si las rechazó -->
        <button id="btn-show-cookies"> Ver aviso de cookies</button>

    <?php endif; ?>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function () {

    var cookiesAceptadas = localStorage.getItem('cookiesAceptadas');

    function mostrarLogin() {
        $('#login-form-wrapper').show();
        $('#btn-show-cookies').hide();
    }

    function ocultarLogin() {
        $('#login-form-wrapper').hide();
        $('#btn-show-cookies').show();
    }

    // Si ya aceptó → ocultar banner y mostrar login directamente
    if (cookiesAceptadas === 'true') {
        $('#cookie-banner').hide();
        mostrarLogin();

    // Si rechazó → ocultar banner pero bloquear login
    } else if (cookiesAceptadas === 'false') {
        $('#cookie-banner').hide();
        ocultarLogin();

    // Si no ha decidido → ocultar login hasta que decida
    } else {
        ocultarLogin();
    }

    // Aceptar cookies
    $('#btn-accept').on('click', function () {
        localStorage.setItem('cookiesAceptadas', 'true');
        $('#cookie-banner').slideUp(300);
        mostrarLogin();
    });

    // Rechazar cookies
    $('#btn-reject').on('click', function () {
        localStorage.setItem('cookiesAceptadas', 'false');
        $('#cookie-banner').slideUp(300);
        ocultarLogin();
    });

    // Botón para volver a ver el aviso
    $('#btn-show-cookies').on('click', function () {
        $('#cookie-banner').slideDown(300);
    });

});
</script>

</body>
</html>