<?php
$host = "localhost";
$usuario = "root";
$contrasenia = ""; 
$base_de_datos = "saeIICP"; 

$mysqli = new mysqli($host, $usuario, $contrasenia, $base_de_datos);

if ($mysqli->connect_errno) {
    die("Error al conectar con la base de datos saeIICP: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");

// Alias para mantener compatibilidad con funciones procedurales (mysqli_query)
$conexion = $mysqli;
?>