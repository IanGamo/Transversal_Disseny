<?php
session_start();
//Validar forms
if ($_SERVER["REQUEST_METHOD"=="POST"]){
    $user = new UserController();
    
    if (isset($_POST["Login"])){
            echo "<p> Login button is clicked.</p>";
            $user->login();
    }
    if (isset($_POST["Logout"])) {
        echo "<p> Logout button is clicked.</p>";
        $user->logout();
    }
    if (isset($_POST["Rehister"])) {
         echo "<p> register button is clicked.</p>";
         $user->register();
    }
}
class UserController {

    private $connection;

    public function __construct() {

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

    public function login(): void {

        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        if (empty($email) || empty($password)) {
            echo "<p style='color:red;'>Debes rellenar todos los campos.</p>";
            return;
        }

        $stmt = $this->connection->prepare(
            "SELECT id, email, password FROM usuarios WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 0) {
            echo "<p style='color:red;'>El usuario no existe.</p>";
            return;
        }

        $usuario = $resultado->fetch_assoc();

        if (!password_verify($password, $usuario["password"])) {
            echo "<p style='color:red;'>Contraseña incorrecta.</p>";
            return;
        }

        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["usuario_email"] = $usuario["email"];

        echo "<p style='color:green;'>Usuario logueado correctamente.</p>";
    }

    public function logout(): void {
        session_destroy();
        echo "Sesión cerrada.";
    }

    public function register(): void {

        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        if (empty($email) || empty($password)) {
            echo "<p style='color:red;'>Debes rellenar todos los campos.</p>";
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->connection->prepare(
            "INSERT INTO usuarios (email, password) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $email, $passwordHash);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Usuario registrado correctamente.</p>";
        } else {
            echo "<p style='color:red;'>Error al registrar usuario.</p>";
        }
    }
}
