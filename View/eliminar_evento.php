<?php
session_start();
require_once("../Controller/EventController.php");

// Si no está logueado, fuera
if (!isset($_SESSION["logged"])) {
    header("Location: Login.php");
    exit;
}

// Si no viene ID, volvemos
if (!isset($_GET["id"])) {
    header("Location: listar_eventos.php");
    exit;
}

$controller = new EventController();
$controller->eliminarEvento($_GET["id"]);

// Después de eliminar, volvemos al listado
header("Location: listar_eventos.php");
exit;
