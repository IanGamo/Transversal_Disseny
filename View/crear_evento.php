<?php
session_start();
require_once("../Controller/EventController.php");

// Si no está logueado, lo echamos
if (!isset($_SESSION["logged"])) {
    header("Location: Login.php");
    exit;
}

$controller = new EventController();
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $resultado = $controller->crearEvento();

    if ($resultado === true) {
        header("Location: listar_eventos.php");
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
    <title>Crear Evento</title>
    <link rel="stylesheet" href="../src/css/form_evento.css">
</head>
<body>

<div class="form-container">

    <h1>Crear un nuevo evento</h1>
    <p class="subtitulo">Rellena los datos y súbelo a la comunidad</p>

    <?php if (!empty($mensaje)): ?>
        <p class="error"><?= $mensaje ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">

        <label for="titulo">Título del evento</label>
        <input type="text" id="titulo" name="titulo" placeholder="Ej: Drift Barcelona 2026" required>

        <label for="fecha">Fecha</label>
        <input type="date" id="fecha" name="fecha" required>

        <label for="ubicacion">Ubicación</label>
        <input type="text" id="ubicacion" name="ubicacion" placeholder="Ej: Circuit de Catalunya" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" placeholder="Describe el evento..." required></textarea>

        <label for="imagen">Imagen del evento</label>
        <input type="file" id="imagen" name="imagen" accept="image/*">

        <button type="submit" class="btn-crear">Crear Evento</button>
    </form>

    <a href="Home.php" class="volver">Volver a Home</a>

</div>

</body>
</html>
