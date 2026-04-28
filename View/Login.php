<?php
session_start();
require_once '../UserController/UserController.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctrl = new UserController();

    if (isset($_POST['Login'])) {
        $result = $ctrl->login();
        if ($result === true) {
            header('Location: Home.html');
            exit;
        }
        $error = $result;
    }

    if (isset($_POST['Logout'])) {
        $ctrl->logout(); // redirige sola a Login.php
    }
}

$loggedIn   = !empty($_SESSION['logged']);
$userName   = htmlspecialchars($_SESSION['usuario_name'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../src/css/Login.css">
</head>

<body>
    <div class="login-container">

        <?php if ($loggedIn): ?>


            <h2>Bienvenido, <?= $userName ?> </h2>
            <p style="text-align:center; color:#555; margin-bottom:20px;">
                Ya tienes una sesión iniciada.
            </p>

            <a href="Home.html" style="display:block; text-align:center; margin-bottom:12px;
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
                   margin-top:14px; color:#ff3131; font-weight:bold;
                   text-decoration:none;">
                    ¿No tienes cuenta? Regístrate aquí →
                </a>

            </form>

        <?php endif; ?>

    </div>
</body>

</html>