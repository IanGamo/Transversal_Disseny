<?php
session_start();
require_once '../UserController/UserController.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctrl   = new UserController();
    $result = $ctrl->register();

    if ($result === true) {
        // Registro OK → redirige al login (ya con sesión iniciada)
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
    <title>Registro</title>
    <link rel="stylesheet" href="../src/css/Registro.css">
</head>

<body>
    <div class="register-container">
        <h2>Registro</h2>

        <?php if ($error): ?>
            <div style="color:#ff3131; margin-bottom:15px;
                        font-size:0.9rem; font-weight:bold;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">

            <div class="input-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" required
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password"
                    required minlength="6">
            </div>

            <div class="input-group">
                <label for="avatar">Foto de perfil</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
            </div>

            <button type="submit">Registrarse</button>

            <a href="Login.php" style="display:block; text-align:center;
               margin-top:14px; color:#ff3131; font-weight:bold;
               text-decoration:none;">
                ¿Ya tienes cuenta? Inicia sesión →
            </a>

        </form>
    </div>
</body>

</html>