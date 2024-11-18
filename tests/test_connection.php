<?php
$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Contraseña por defecto está vacía
$dbname = "unab_students"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}
echo "Conexión exitosa a la base de datos.<br>";

// Ejecutar una consulta simple
$sql = "SELECT * FROM students"; // Reemplaza 'tu_tabla' con el nombre de una tabla existente en tu base de datos
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Mostrar los resultados
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . " - Nombre: " . $row["nombre"] . "<br>"; // Cambia 'id' y 'nombre' según los campos de tu tabla
        }
    } else {
        echo "No hay resultados.";
    }
} else {
    echo "Error en la consulta: " . $conn->error;
}

$conn->close();
?>
