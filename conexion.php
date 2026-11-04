<?php
// =====================================================
// conexion.php - Conecta PHP con MySQL (XAMPP)
// Este archivo se incluye en todos los demás con: include "conexion.php";
// =====================================================

$servidor = "localhost";     // en XAMPP el servidor siempre es localhost
$usuario  = "root";          // usuario por defecto de XAMPP
$clave    = "";              // XAMPP no tiene contraseña por defecto
$bd       = "bd_maquillaje"; // nombre de nuestra base de datos

// mysqli_connect abre la conexión
$conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

// Si falla, mostramos el error y detenemos el programa
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Para que se vean bien los acentos y la ñ
mysqli_set_charset($conexion, "utf8mb4");
?>
