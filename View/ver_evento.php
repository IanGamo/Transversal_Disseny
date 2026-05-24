<?php
session_start();
require_once("../Controller/EventController.php");

// Si no está logueado, fuera
if (!isset($_SESSION["logged"])) {
    header("Location: Login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: listar_eventos.php");
    exit;
}

$controller = new EventController();
$evento = $controller->obtenerEvento($_GET["id"]);

if (!$evento) {
    header("Location: listar_eventos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($evento["titulo"]) ?></title>
    <link rel="stylesheet" href="../src/css/ver_evento.css">
</head>
<body>

<div class="contenedor">

    <a href="listar_eventos.php" class="volver">← Volver a eventos</a>

    <div class="card">

        <?php if (!empty($evento["imagen"])): ?>
            <img src="<?= $evento["imagen"] ?>" class="img-evento">
        <?php else: ?>
            <div class="img-placeholder">Sin imagen</div>
        <?php endif; ?>

        <h1><?= htmlspecialchars($evento["titulo"]) ?></h1>

        <p class="fecha"><strong>Fecha:</strong> <?= $evento["fecha"] ?></p>
        <p class="ubicacion"><strong>Ubicación:</strong> <?= htmlspecialchars($evento["ubicacion"]) ?></p>

        <p class="descripcion"><?= nl2br(htmlspecialchars($evento["descripcion"])) ?></p>

        <div class="acciones">
            <a href="editar_evento.php?id=<?= $evento["id"] ?>" class="btn editar">Editar</a>
            <a href="eliminar_evento.php?id=<?= $evento["id"] ?>" class="btn eliminar"
               onclick="return confirm('¿Seguro que quieres eliminar este evento?')">
               Eliminar
            </a>
        </div>

    </div>

</div>

</body>
</html>
