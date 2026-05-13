<?php
session_start();

// Si no hay sesión activa → redirige al login
if (empty($_SESSION['logged'])) {
    header('Location: Login.php');
    exit;
}

$userName  = htmlspecialchars($_SESSION['usuario_name']  ?? '');
$userEmail = htmlspecialchars($_SESSION['usuario_email'] ?? '');
$userRol   = htmlspecialchars($_SESSION['usuario_rol']   ?? '');
$userAvatar = $_SESSION['usuario_avatar'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | Race&Meet</title>
    <link rel="stylesheet" href="../src/css/Profile.css">
</head>
<body>
    <div class="profile-container">

        <?php if ($userAvatar && file_exists($userAvatar)): ?>
            <img src="<?= htmlspecialchars($userAvatar) ?>"
                 alt="Avatar" class="profile-avatar">
        <?php else: ?>
            <div class="profile-avatar-placeholder"></div>
        <?php endif; ?>

        <div class="profile-name"><?= $userName ?></div>
        <div class="profile-rol"><?= $userRol ?></div>

        <div class="profile-info">
            <p> Email: <span><?= $userEmail ?></span></p>
            <p> Rol: <span><?= ucfirst($userRol) ?></span></p>
        </div>

        <div class="profile-actions">
            <a href="Home.php">
                <button class="btn-home">← Volver al inicio</button>
            </a>
            <form method="POST" action="Login.php">
                <button type="submit" name="Logout" class="btn-logout">
                    Cerrar sesión
                </button>
            </form>
        </div>

    </div>
</body>
</html>