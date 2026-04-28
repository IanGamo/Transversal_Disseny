<?php
session_start();
require_once '../UserController/UserController.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctrl   = new UserController();
    $result = $ctrl->register(); // register() ya valida codigo_admin internamente

    if ($result === true) {
        // Sesión correcta para admin
        $_SESSION['admin'] = ($_SESSION['usuario_rol'] === 'admin');
        header('Location: Login.php');
        exit;
    }

    $error = $result;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Admin</title>
    <link rel="stylesheet" href="../src/css/Registro.css">
</head>

<body>
    <div class="register-container">
        <h2>Registro Administrador</h2>

        <?php if ($error): ?>
            <div style="color:#ff3131; margin-bottom:15px;
                        font-size:0.9rem; font-weight:bold;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- action="" → se envía al propio archivo, no a UserController.php -->
        <form method="POST" action="">

            <!-- Le dice al UserController que el rol es admin -->
            <input type="hidden" name="rol" value="admin">

            <div class="input-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" required
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            </div>

            <div class="input-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" required
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password"
                    required minlength="6">
            </div>

            <div class="input-group">
                <label for="codigo_admin">Código secreto</label>
                <input type="password" id="codigo_admin" name="codigo_admin" required>
            </div>

            <button type="submit">Registrarse como Admin</button>

            <a href="Login.php" style="display:block; text-align:center;
               margin-top:14px; color:#ff3131; font-weight:bold;
               text-decoration:none;">
                ← Volver al login
            </a>

        </form>
    </div>
</body>

</html>