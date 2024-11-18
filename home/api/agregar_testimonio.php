<?php
session_start(); // Inicia la sesión para mantener la información del usuario durante la sesión actual
include '../../config/config.php'; // Incluye el archivo de configuración para establecer la conexión a la base de datos

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Obtener el cuerpo de la solicitud
$json = file_get_contents('php://input');

// Decodificar el JSON a un array asociativo
$data = json_decode($json, true);

$result = [
    'isSuccess' => false,
    'errorMessage' => ''
];

$errorMessage = ""; // Inicializa el mensaje de error
$texto = trim($data['comentario']); // Obtiene y limpia el texto del testimonio
$autor = trim($data['autor']); // Obtiene y limpia el nombre del autor

// Validaciones para asegurarse de que los campos no estén vacíos
if (empty($texto) || empty($autor)) {
    $result['errorMessage'] = "Todos los campos son obligatorios."; // Mensaje de error
} else {
    // Prepara la consulta SQL para insertar un nuevo testimonio
    $stmt = $conn->prepare("INSERT INTO testimonios (texto, autor) VALUES (?, ?)");
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);

    }
    $stmt->bind_param("ss", $texto, $autor);
    // Ejecuta la consulta
    if ($stmt->execute()) {
        $result['isSuccess'] = true;
    } else {
        $result['errorMessage'] = "Error al agregar el testimonio: " . $stmt->error;
    }
    $stmt->close(); // Cierra la declaración

}
echo json_encode($result);



$conn->close(); // Cierra la conexión a la base de datos
?>