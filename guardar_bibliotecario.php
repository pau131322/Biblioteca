<?php
// Incluir el archivo que deseas incluir
include 'agregarbibiot.html';  // Aquí se incluirá el archivo HTML que mencionaste

// Configuración de la base de datos
$servidor = "localhost";
$usuario = "root";  // Cambia si usas otro usuario en MySQL
$password = "";  // Pon la contraseña si tienes una configurada
$base_datos = "dinobase";

// Crear conexión
$conn = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se enviaron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    // En este caso, no se hace el hash de la contraseña, se guarda tal cual.
    // Preparar la consulta SQL para insertar datos
    $sql = "INSERT INTO bibliotecario (Nombre, Contraseña) VALUES (?, ?)";

    // Usamos prepared statements para evitar SQL Injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $contrasena);  // Pasamos la contraseña sin hash

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $mensaje = "Bibliotecario agregado con éxito";
    } else {
        $mensaje = "Error al agregar bibliotecario";
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
}
?>
