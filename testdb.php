<?php
header("Content-Type: text/html; charset=utf-8");

$mysqli = new mysqli("localhost", "proyecto_cf", "9dejulio1449", "costura fina");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}
echo "Conexión exitosa";

$mysqli->close();
?>
