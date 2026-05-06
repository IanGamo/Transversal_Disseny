<?php

class UserController
{
    private $connection;

    public function __construct()
    {
        $this->connection = new mysqli(
            "localhost",
            "root",
            "",
            "race_and_meet"
        );

        if ($this->connection->connect_error) {
            die("Error de conexión: " . $this->connection->connect_error);
        }
    }

    // Devuelve true si ok, o string con el error si falla
    public function login(): bool|string
    {
        $email    = trim($_POST["email"]    ?? "");
        $password = trim($_POST["password"] ?? "");

        if (empty($email) || empty($password)) {
            return "Debes rellenar todos los campos.";
        }

        $stmt = $this->connection->prepare(
            "SELECT id, name, email, password, rol FROM usuarios WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 0) {
            return "El usuario no existe.";
        }

        $usuario = $resultado->fetch_assoc();

        if (!password_verify($password, $usuario["password"])) {
            return "Contraseña incorrecta.";
        }

        $_SESSION["usuario_id"]    = $usuario["id"];
        $_SESSION["usuario_email"] = $usuario["email"];
        $_SESSION["usuario_name"]  = $usuario["name"];
        $_SESSION["usuario_rol"]   = $usuario["rol"];
        $_SESSION["logged"]        = true;
        return true;
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        header("Location: Login.php");
        exit;
    }

    // Devuelve true si ok, o string con el error si falla
    public function register(): bool|string
    {
        $name     = trim($_POST["name"]     ?? "");
        $email    = trim($_POST["email"]    ?? "");
        $password = trim($_POST["password"] ?? "");
        $rol      = trim($_POST["rol"]      ?? "usuario");

        if (empty($name) || empty($email) || empty($password)) {
            return "Debes rellenar todos los campos.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "El email no es válido.";
        }

        if (strlen($password) < 6) {
            return "La contraseña debe tener al menos 6 caracteres.";
        }

        // Comprobar que el email no esté ya registrado
        $check = $this->connection->prepare(
            "SELECT id FROM usuarios WHERE email = ?"
        );
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            return "Este email ya está registrado.";
        }

        if ($rol === "admin") {
            $codigo = trim($_POST["codigo_admin"] ?? "");
            if ($codigo !== "12345adm") {
                return "Código secreto incorrecto.";
            }
        }

        // Gestión de avatar 
        $imgPath = "";
        if (!empty($_FILES["avatar"]["name"])) {
            $allowed   = ["image/jpeg", "image/png", "image/gif", "image/webp"];
            $uploadDir = "../uploads/avatars/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $mimeType = mime_content_type($_FILES["avatar"]["tmp_name"]);

            if (!in_array($mimeType, $allowed)) {
                return "Formato de imagen no permitido (jpg, png, gif, webp).";
            }

            if ($_FILES["avatar"]["size"] > 2 * 1024 * 1024) {
                return "La imagen supera el tamaño máximo de 2 MB.";
            }

            $ext      = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
            $filename = uniqid("avatar_", true) . "." . $ext;
            $imgPath  = $uploadDir . $filename;
            move_uploaded_file($_FILES["avatar"]["tmp_name"], $imgPath);
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->connection->prepare(
            // "INSERT INTO usuarios (name, email, password, rol, path) VALUES (?, ?, ?, ?, ?)"
            "INSERT INTO usuarios (name, email, password, rol) VALUES (?, ?, ?, ?)"
        );
        // $stmt->bind_param("sssss", $name, $email, $passwordHash, $rol, $imgPath);
        $stmt->bind_param("ssss", $name, $email, $passwordHash, $rol);

        if ($stmt->execute()) {
            $_SESSION["usuario_id"]    = $this->connection->insert_id;
            $_SESSION["usuario_email"] = $email;
            $_SESSION["usuario_name"]  = $name;
            $_SESSION["usuario_rol"]   = $rol;
            $_SESSION["logged"]        = true;
            return true;
        }

        return "Error al registrar usuario.";
    }
}