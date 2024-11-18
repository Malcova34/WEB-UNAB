<?php
// Configuración básica del proyecto
define('BASE_URL', 'http://localhost/web_unab/tests/test_connection.php');

// Configuración de la base de datos
$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Contraseña por defecto está vacía
$dbname = "unab_students"; // Nombre de tu base de datos

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Función para realizar consultas a la base de datos
function query($sql, $params = null) {
    global $conn;
    $stmt = $conn->prepare($sql);

    if ($params) {
        // Convertir los parámetros en un array
        $types = str_repeat('s', count($params)); // Suponiendo que todos son strings
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die('Error en la consulta: ' . $stmt->error);
    }

    return $result;
}
?>
