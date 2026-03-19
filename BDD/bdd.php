<?php
$host = "localhost";
$user = "adm1";
$pass = "12345";
$db   = "Race_&_Meet";

// MySQLi Object-oriented (Requerimiento 4.2)
$connection = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($connection->connect_error) {
    die("Error de conexión: " + $connection->connect_error);
}
echo "Connection ennabled"

?>