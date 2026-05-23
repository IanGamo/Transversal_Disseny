<?php
session_start();
require_once("../Controller/EventController.php");

// Si no está logueado, fuera
if (!isset($_SESSION["logged"])) {
    header("Location: Login.php");
    exit;
}

$controller = new EventController();
$eventos = $controller->listarEventos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
    <link rel="stylesheet" href="../src/css/listar_eventos.css">
</head>
<body>

<div class="contenedor">

    <h1>Eventos publicados</h1>
    <p class="subtitulo">Aquí puedes ver todos los eventos creados en la plataforma</p>

    <a href="crear_evento.php" class="btn-crear">+ Crear nuevo evento</a>

    <?php if (empty($eventos)): ?>
        <p class="no-eventos">Todavía no hay eventos creados.</p>
    <?php else: ?>

        <div class="grid-eventos">
            <?php foreach ($eventos as $evento): ?>
                <div class="card">

                    <?php if (!empty($evento["imagen"])): ?>
                        <img src="<?= $evento["imagen"] ?>" class="img-evento">
                    <?php else: ?>
                        <div class="img-placeholder">Sin imagen</div>
                    <?php endif; ?>

                    <h2><?= htmlspecialchars($evento["titulo"]) ?></h2>
                    <p class="fecha"><?= $evento["fecha"] ?></p>
                    <p class="ubicacion"><?= htmlspecialchars($evento["ubicacion"]) ?></p>

                    <div class="acciones">
                        <a href="ver_evento.php?id=<?= $evento["id"] ?>" class="btn ver">Ver</a>
                        <a href="editar_evento.php?id=<?= $evento["id"] ?>" class="btn editar">Editar</a>
                        <a href="eliminar_evento.php?id=<?= $evento["id"] ?>" class="btn eliminar"
                           onclick="return confirm('¿Seguro que quieres eliminar este evento?')">
                           Eliminar
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <a href="Home.php" class="volver">Volver a Home</a>

</div>

</body>
</html>
