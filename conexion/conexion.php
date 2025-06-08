<?php
$server = "mysql";  // Importante: usar "mysql", no "some-mysql"
$user = "root";
$pass = "clave123";
$db = "criminalistica_db";

$conexion = new mysqli($server, $user, $pass, $db);

if ($conexion->connect_errno) {
    die("Conexion Fallida: " . $conexion->connect_error);
} else {
    echo "¡Conectado exitosamente a la base de datos!";
}
?>