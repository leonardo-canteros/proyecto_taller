<?php
$conexion = new mysqli("localhost", "proyecto_cf", "9dejulio1449", "costura_fina");

if ($conexion->connect_error) {
    echo "Error: No se pudo conectar a la base de datos";
} else {
    echo "¡Conexión exitosa a la base de datos!";
}
?>
