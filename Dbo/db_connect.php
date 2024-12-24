<?php

$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración
$database = "portafolio"; // Asegúrate de que este sea el nombre de tu base de datos

// Crear conexión
$mysqli = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

/*
$servername = "sql305.infinityfree.com";
$username = "if0_37278911"; // Cambia según tu configuración
$password = "gPaWqIeQn5IHB"; // Cambia según tu configuración
$database = "if0_37278911_portafolio"; // Asegúrate de que este sea el nombre de tu base de datos

// Crear conexión
$mysqli = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8");

*/

?>