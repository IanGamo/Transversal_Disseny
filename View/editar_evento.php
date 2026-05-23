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

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $resultado = $controller->actualizarEvento($_GET["id"]);

    if ($resultado === true) {
        header("Location: ver_evento.php?id=" . $_GET["id"]);
        exit;
    } else {
        $mensaje = $resultado;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="../src/css/editar_evento.css">
</head>
<body>

<div class="form-container">

    <h1>Editar evento</h1>
    <p class="subtitulo">Modifica los datos y guarda los cambios</p>

    <?php if (!empty($mensaje)): ?>
        <p class="error"><?= $mensaje ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">

        <label for="titulo">Título del evento</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($evento["titulo"]) ?>" required>

        <label for="fecha">Fecha</label>
        <input type="date" id="fecha" name="fecha" value="<?= $evento["fecha"] ?>" required>

        <label for="ubicacion">Ubicación</label>
        <input type="text" id="ubicacion" name="ubicacion" value="<?= htmlspecialchars($evento["ubicacion"]) ?>" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" required><?= htmlspecialchars($evento["descripcion"]) ?></textarea>

        <label>Imagen actual</label>
        <?php if (!empty($evento["imagen"])): ?>
            <img src="<?= $evento["imagen"] ?>" class="img-preview">
        <?php else: ?>
            <p class="no-img">Este evento no tiene imagen</p>
        <?php endif; ?>

        <input type="hidden" name="imagen_actual" value="<?= $evento["imagen"] ?>">

        <label for="imagen">Subir nueva imagen (opcional)</label>
        <input type="file" id="imagen" name="imagen" accept="image/*">

        <button type="submit" class="btn-guardar">Guardar cambios</button>
    </form>

    <a href="ver_evento.php?id=<?= $evento["id"] ?>" class="volver">Volver al evento</a>

</div>

</body>
</html>
