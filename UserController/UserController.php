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
    // Atributo: el signo "-" significa que es privado (private)
    private $connection;

    /**
     * Constructor para inicializar la conexión
     * (Opcional, pero recomendado para manejar el atributo 'connection')
     */
    public function __construct($dbConnection = null) {
        $this->connection = $dbConnection;
    }

    // Método: el signo "+" significa que es público (public)
    public function login(): void {
        // Lógica para iniciar sesión
        echo "Usuario logueado correctamente.";
    }

    // El tipo de retorno "void" indica que no devuelve ningún valor
    public function logout(): void {
        // Lógica para cerrar sesión
        echo "Sesión cerrada.";
    }

    public function register(): void {
        // Lógica para registrar un nuevo usuario
        echo "Usuario registrado.";
    }
}

//prueba