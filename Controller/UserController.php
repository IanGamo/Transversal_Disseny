<?php

class UserController
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

    // LOGIN
    public function login(): bool|string
    {
        $email    = trim($_POST["email"]    ?? "");
        $password = trim($_POST["password"] ?? "");

        if (empty($email) || empty($password)) {
            return "Debes rellenar todos los campos.";
        }

        $stmt = $this->connection->prepare(
            "SELECT id, name, email, password, rol, path 
             FROM usuarios 
             WHERE email = ?"
        );
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            return "El usuario no existe.";
        }

        if (!password_verify($password, $usuario["password"])) {
            return "Contraseña incorrecta.";
        }

        $_SESSION["usuario_id"]    = $usuario["id"];
        $_SESSION["usuario_email"] = $usuario["email"];
        $_SESSION["usuario_name"]  = $usuario["name"];
        $_SESSION["usuario_rol"]   = $usuario["rol"];
        $_SESSION["usuario_path"]  = $usuario["path"];
        $_SESSION["logged"]        = true;

        return true;
    }

    // LOGOUT
    public function logout(): void
    {
        session_unset();
        session_destroy();
        header("Location: Login.php");
        exit;
    }

    // ELIMINAR CUENTA PROPIA
    public function deleteOwnAccount(): bool|string
    {
        if (empty($_SESSION['logged'])) {
            return "No hay sesión activa.";
        }

        $id = (int) ($_SESSION['usuario_id'] ?? 0);

        if ($id <= 0) {
            return "ID de usuario no válido.";
        }

        // Obtener avatar antes de borrar
        $stmt = $this->connection->prepare(
            "SELECT path FROM usuarios WHERE id = ?"
        );
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return "El usuario no existe.";
        }

        // Eliminar avatar del servidor si existe
        if (!empty($user['path']) && file_exists($user['path'])) {
            unlink($user['path']);
        }

        // Borrar de la BD
        $stmt = $this->connection->prepare(
            "DELETE FROM usuarios WHERE id = ?"
        );
        $ok = $stmt->execute([$id]);

        if ($ok) {
            // Destruir sesión
            session_unset();
            session_destroy();
            return true;
        }

        return "Error al eliminar la cuenta.";
    }

    // LISTAR USUARIOS ESTÁNDAR
    public function listStandardUsers(): array
    {
        $stmt = $this->connection->prepare(
            "SELECT id, name, email, path, created_at
             FROM usuarios
             WHERE rol = 'usuario'
             ORDER BY name ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ELIMINAR USUARIO ESTÁNDAR
    public function deleteUser(): bool|string
    {
        // Solo admins pueden eliminar
        if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
            return "Acceso denegado: no tienes permisos de administrador.";
        }

        $id = (int) ($_POST['user_id'] ?? 0);

        if ($id <= 0) {
            return "ID de usuario no válido.";
        }

        // Evitar que el admin se elimine a sí mismo
        if ($id === (int) ($_SESSION['usuario_id'] ?? 0)) {
            return "No puedes eliminar tu propia cuenta.";
        }

        // Obtener datos del usuario antes de borrarlo
        $stmt = $this->connection->prepare(
            "SELECT rol, path FROM usuarios WHERE id = ?"
        );
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return "El usuario no existe.";
        }

        if ($user['rol'] !== 'usuario') {
            return "Solo se pueden eliminar usuarios estándar.";
        }

        // Eliminar el avatar del servidor si existe
        if (!empty($user['path']) && file_exists($user['path'])) {
            unlink($user['path']);
        }

        // Eliminar de la BD
        $stmt = $this->connection->prepare(
            "DELETE FROM usuarios WHERE id = ? AND rol = 'usuario'"
        );
        $ok = $stmt->execute([$id]);

        return $ok ? true : "Error al eliminar el usuario.";
    }

    // REGISTER
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

        // Comprobar si el email ya existe
        $stmt = $this->connection->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            return "Este email ya está registrado.";
        }

        // Validación de admin
        if ($rol === "admin") {
            $codigo = trim($_POST["codigo_admin"] ?? "");
            if ($codigo !== "12345adm") {
                return "Código secreto incorrecto.";
            }
        }

        // AVATAR
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
                return "La imagen supera los 2 MB.";
            }

            $ext      = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
            $filename = uniqid("avatar_", true) . "." . $ext;
            $imgPath  = $uploadDir . $filename;

            move_uploaded_file($_FILES["avatar"]["tmp_name"], $imgPath);
        }

        // INSERTAR USUARIO
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->connection->prepare(
            "INSERT INTO usuarios (name, email, password, rol, path)
             VALUES (?, ?, ?, ?, ?)"
        );

        $ok = $stmt->execute([$name, $email, $passwordHash, $rol, $imgPath]);

        if ($ok) {
            $_SESSION["usuario_id"]    = $this->connection->lastInsertId();
            $_SESSION["usuario_email"] = $email;
            $_SESSION["usuario_name"]  = $name;
            $_SESSION["usuario_rol"]   = $rol;
            $_SESSION["usuario_path"]  = $imgPath;
            $_SESSION["logged"]        = true;
            return true;
        }

        return "Error al registrar usuario.";
    }
}