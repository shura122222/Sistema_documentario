<?php
// === CONFIGURACIÓN DE CONEXIÓN ===
$server = "mysql"; 
$user = "root";
$pass = "clave123";
$db = "criminalistica_db";

// === CONEXIÓN A LA BASE DE DATOS ===
$conexion = new mysqli($server, $user, $pass, $db);

if ($conexion->connect_errno) {
    die("Conexión fallida: " . $conexion->connect_error);
} else {
    $conexion->set_charset("utf8mb4");
    // echo "¡Conectado exitosamente a la base de datos!";
}

?>
