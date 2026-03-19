<?php

class UserController {
    // Atributo: el signo "-" significa que es privado (private)
    private $connection;

    /**
     * Constructor para inicializar la conexión
     * (Opcional, pero recomendado para manejar el atributo 'connection')
     */
    public function __construct($dbConnection) {
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