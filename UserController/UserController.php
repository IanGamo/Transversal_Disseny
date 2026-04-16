<?php
session_start();
//Validar forms
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new UserController();

    if (isset($_POST["Login"])) {
        echo "<p> Login button is clicked.</p>";
        $user->login();
        $result = $user->login();
        // if ($result === true) {
        //     header("Location: profile.php");
        //     exit;
        // } else {
        //     $error = $result; // Muestra el mensaje de error en el HTML
        // }
    }
    if (isset($_POST["Logout"])) {
        echo "<p> Logout button is clicked.</p>";
        $user->logout();
    }
    if (isset($_POST["Register"])) {
        echo "<p> register button is clicked.</p>";
        $user->register();
    }
}
class UserController
{

    private $connection;

    public function __construct()
    {
        $this->connection = new mysqli(
            "localhost",
            "adm1",
            "12345",
            "Race_and_Meet"
        );

        if ($this->connection->connect_error) {
            die("Error de conexión: " . $this->connection->connect_error);
        }
    }

    // Devuelve true si ok, o string con el error si falla
    public function login(): bool|string
    {
        echo "en login";

        // $email    = trim($_POST["email"]    ?? "");
        // $password = trim($_POST["password"] ?? "");

        // if (empty($email) || empty($password)) {
        //     return "Debes rellenar todos los campos.";
        // }

        // $stmt = $this->connection->prepare(
        //     "SELECT id, email, password FROM usuarios WHERE email = ?"
        // );
        // $stmt->bind_param("s", $email);
        // $stmt->execute();
        // $resultado = $stmt->get_result();

        // if ($resultado->num_rows === 0) {
        //     return "El usuario no existe.";
        // }

        // $usuario = $resultado->fetch_assoc();

        // if (!password_verify($password, $usuario["password"])) {
        //     return "Contraseña incorrecta.";
        // }

        // $_SESSION["usuario_id"]    = $usuario["id"];
        // $_SESSION["usuario_email"] = $usuario["email"];

        return true;
    }

    public function logout(): void
    {
        session_destroy();
        header("Location: index.php");
        exit;
    }

    // Devuelve true si ok, o string con el error si falla
    public function register(): bool|string
    {

        $name     = trim($_POST["name"]     ?? "");
        $email    = trim($_POST["email"]    ?? "");
        $password = trim($_POST["password"] ?? "");

        if (empty($name) || empty($email) || empty($password)) {
            return "Debes rellenar todos los campos.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "El email no es válido.";
        }

        if (strlen($password) < 6) {
            return "La contraseña debe tener al menos 6 caracteres.";
        }

        // Subida de imagen (path)
        $imgPath = "";
        if (!empty($_FILES["avatar"]["name"])) {
            $allowed   = ["image/jpeg", "image/png", "image/gif", "image/webp"];
            $uploadDir = "uploads/avatars/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $mimeType = mime_content_type($_FILES["avatar"]["tmp_name"]);

            if (!in_array($mimeType, $allowed)) {
                return "Formato de imagen no permitido.";
            }
            if ($_FILES["avatar"]["size"] > 2 * 1024 * 1024) {
                return "La imagen no puede superar 2MB.";
            }
            $mimeToExt = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
            $ext       = $mimeToExt[$mimeType];
            $filename  = uniqid("avatar_", true) . "." . $ext;
            $imgPath  = $uploadDir . $filename;
            move_uploaded_file($_FILES["avatar"]["tmp_name"], $imgPath);
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->connection->prepare(
            "INSERT INTO usuarios (name, email, password, path) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $name, $email, $passwordHash, $imgPath);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Error al registrar usuario.";
        }
    }
}


