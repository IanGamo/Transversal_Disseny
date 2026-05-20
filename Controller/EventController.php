<?php

class EventController
{
    private PDO $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host=localhost;dbname=race_and_meet;charset=utf8",
                "adm1",
                "12345"
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // CREATE – Crear evento
    public function crearEvento(): bool|string
    {
        $titulo      = trim($_POST["titulo"]      ?? "");
        $fecha       = trim($_POST["fecha"]       ?? "");
        $ubicacion   = trim($_POST["ubicacion"]   ?? "");
        $descripcion = trim($_POST["descripcion"] ?? "");
        $creado_por  = $_SESSION["usuario_id"]     ?? null;

        if (empty($titulo) || empty($fecha) || empty($ubicacion) || empty($descripcion)) {
            return "Debes rellenar todos los campos.";
        }

        // Imagen
        $imgPath = "";
        if (!empty($_FILES["imagen"]["name"])) {
            $allowed   = ["image/jpeg", "image/png", "image/gif", "image/webp"];
            $uploadDir = "../src/uploads/eventos/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $mimeType = mime_content_type($_FILES["imagen"]["tmp_name"]);
            if (!in_array($mimeType, $allowed)) {
                return "Formato de imagen no permitido.";
            }

            if ($_FILES["imagen"]["size"] > 3 * 1024 * 1024) {
                return "La imagen supera el tamaño máximo de 3 MB.";
            }

            $ext      = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
            $filename = uniqid("evento_", true) . "." . $ext;
            $imgPath  = $uploadDir . $filename;

            move_uploaded_file($_FILES["imagen"]["tmp_name"], $imgPath);
        }

        $stmt = $this->connection->prepare(
            "INSERT INTO eventos (titulo, fecha, ubicacion, descripcion, imagen, creado_por)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        return $stmt->execute([$titulo, $fecha, $ubicacion, $descripcion, $imgPath, $creado_por])
            ? true
            : "Error al crear el evento.";
    }

    // READ – Obtener un evento
    public function obtenerEvento($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM eventos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // READ – Listar eventos
    public function listarEventos()
    {
        $stmt = $this->connection->query("SELECT * FROM eventos ORDER BY fecha ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE – Actualizar evento
    public function actualizarEvento($id): bool|string
    {
        $titulo      = trim($_POST["titulo"]      ?? "");
        $fecha       = trim($_POST["fecha"]       ?? "");
        $ubicacion   = trim($_POST["ubicacion"]   ?? "");
        $descripcion = trim($_POST["descripcion"] ?? "");

        if (empty($titulo) || empty($fecha) || empty($ubicacion) || empty($descripcion)) {
            return "Debes rellenar todos los campos.";
        }

        $imgPath = $_POST["imagen_actual"] ?? "";

        if (!empty($_FILES["imagen"]["name"])) {
            $allowed   = ["image/jpeg", "image/png", "image/gif", "image/webp"];
            $uploadDir = "../src/uploads/eventos/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $mimeType = mime_content_type($_FILES["imagen"]["tmp_name"]);
            if (!in_array($mimeType, $allowed)) {
                return "Formato de imagen no permitido.";
            }

            $ext      = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
            $filename = uniqid("evento_", true) . "." . $ext;
            $imgPath  = $uploadDir . $filename;

            move_uploaded_file($_FILES["imagen"]["tmp_name"], $imgPath);
        }

        $stmt = $this->connection->prepare(
            "UPDATE eventos SET titulo=?, fecha=?, ubicacion=?, descripcion=?, imagen=? WHERE id=?"
        );

        return $stmt->execute([$titulo, $fecha, $ubicacion, $descripcion, $imgPath, $id])
            ? true
            : "Error al actualizar el evento.";
    }

    // DELETE – Eliminar evento
    public function eliminarEvento($id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM eventos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
