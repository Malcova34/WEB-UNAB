<?php
include '../../config/config.php'; // Incluye el archivo de configuración para establecer la conexión a la base de datos
header("Content-Type: application/json");

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "unab_students");

// Verificar la conexión
if ($conexion->connect_error) {
    echo json_encode(["error" => "Error en la conexión: " . $conexion->connect_error]);
    exit();
}

// Consultar los testimonios
$sql = "SELECT texto, autor FROM testimonios ORDER BY fecha DESC LIMIT 10";
$resultado = $conexion->query($sql);

$testimonios = array();
while ($row = $resultado->fetch_assoc()) {
    $testimonios[] = $row;
}

// Cerrar la conexión
$conexion->close();

// Enviar los testimonios en formato JSON
echo json_encode($testimonios);
?>