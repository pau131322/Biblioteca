<?php
$servername = "localhost";
$username = "root"; // Cambia esto si tienes credenciales diferentes
$password = ""; // Cambia esto si tu base de datos tiene contraseña
$database = "dinobase";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$id_control = $_POST['contrasena']; // Asegúrate de que este campo solo tenga números

// Verificar que la consulta está bien
$sql = "INSERT INTO alumnos (Alumnos, Id_control) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en la consulta: " . $conn->error);
}

$stmt->bind_param("si", $nombre, $id_control);

if ($stmt->execute()) {
    echo "<script>alert('Alumno agregado correctamente'); window.location.href='alum.agregar.html';</script>";
} else {
    echo "<script>alert('Error al agregar alumno: " . $stmt->error . "'); window.history.back();</script>";
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>