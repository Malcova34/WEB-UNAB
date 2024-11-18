<?php
session_start(); // Inicia la sesión para mantener la información del usuario durante la sesión actual
include '../config/config.php'; // Incluye el archivo de configuración para establecer la conexión a la base de datos

$errorMessage = ""; // Inicializa la variable de mensaje de error para almacenar cualquier error que ocurra

// Comprueba si el método de la solicitud es POST (es decir, si se envió un formulario)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action']; // Obtiene la acción (registro o inicio de sesión) desde el formulario

    // Si la acción es "register", se procesa el registro de un nuevo usuario
    if ($action == "register") {
        $name = trim($_POST['username']); // Obtiene y limpia el nombre del usuario
        $email = trim($_POST['email']); // Obtiene y limpia el correo electrónico
        $password = trim($_POST['password']); // Obtiene y limpia la contraseña

        // Validaciones para asegurarse de que los campos no estén vacíos
        if (empty($name) || empty($email) || empty($password)) {
            $errorMessage = "Todos los campos son obligatorios."; // Mensaje de error si algún campo está vacío
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Correo electrónico no válido."; // Mensaje de error si el correo no es válido
        } else {
            // Cifra la contraseña antes de almacenarla en la base de datos
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Prepara la consulta SQL para insertar un nuevo usuario en la tabla 'students'
            $stmt = $conn->prepare("INSERT INTO students (name, email, password) VALUES (?, ?, ?)");
            // Verifica si hubo un error al preparar la consulta
            if ($stmt === false) {
                die("Error en la preparación de la consulta: " . $conn->error);
            }
            // Asocia los parámetros a la consulta
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            // Ejecuta la consulta
            if ($stmt->execute()) {
                // Muestra un mensaje de éxito y redirige al usuario a la página de inicio de sesión
                echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.');</script>";
                echo "<script>window.location.href = 'http://localhost/web_unab/login/login.html?#';</script>"; // Redirige al login
            } else {
                // Si ocurre un error durante la ejecución, se guarda el mensaje de error
                $errorMessage = "Error al registrar: " . $stmt->error;
            }
            $stmt->close(); // Cierra la declaración
        }
    } // Si la acción es "login", se procesa el inicio de sesión del usuario
    elseif ($action == "login") {
        $email = trim($_POST['email']); // Obtiene y limpia el correo electrónico
        $password = trim($_POST['password']); // Obtiene y limpia la contraseña

        // Validaciones para el inicio de sesión
        if (empty($email) || empty($password)) {
            $errorMessage = "Todos los campos son obligatorios."; // Mensaje de error si algún campo está vacío
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Correo electrónico no válido."; // Mensaje de error si el correo no es válido
        } else {
            // Prepara la consulta SQL para buscar el usuario por correo electrónico
            $stmt = $conn->prepare("SELECT id, password FROM students WHERE email = ?");
            $stmt->bind_param("s", $email); // Asocia el parámetro del correo electrónico
            $stmt->execute(); // Ejecuta la consulta
            $stmt->store_result(); // Almacena el resultado de la consulta
            // Verifica si se encontró al menos un usuario con ese correo
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id, $hashed_password); // Asocia el resultado a variables
                $stmt->fetch(); // Obtiene los valores
                // Verifica si la contraseña ingresada coincide con la almacenada
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $user_id; // Guarda el ID del usuario en la sesión
                    header("Location: http://localhost/web_unab/home/home.html?#"); // Redirige a otra página después del inicio de sesión
                    exit(); // Termina la ejecución del script
                } else {
                    $errorMessage = "Contraseña incorrecta."; // Mensaje de error si la contraseña es incorrecta
                }
            } else {
                $errorMessage = "No se encontró una cuenta con ese correo electrónico."; // Mensaje de error si no hay coincidencias
            }
            $stmt->close(); // Cierra la declaración
        }
    }
}

$conn->close(); // Cierra la conexión a la base de datos
?>

<?php if (!empty($errorMessage)): ?> <!-- Comprueba si hay un mensaje de error -->
<script>
    alert("<?php echo addslashes($errorMessage); ?>"); // Muestra el mensaje de error en una alerta
    // Redirige a la página de inicio de sesión después de que se acepte la alerta
    window.location.href = "http://localhost/web_unab/login/login.html?#"; // ruta
</script>
<?php endif; ?>
