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
$autor = $_POST['autor'];
$libro = $_POST['libro'];

// Preparar y ejecutar la consulta
$sql = "INSERT INTO autores (Autor, Libro) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en la consulta: " . $conn->error);
}

$stmt->bind_param("ss", $autor, $libro);

if ($stmt->execute()) {
    echo "<script>alert('Autor agregado correctamente'); window.location.href='autor.crea.html';</script>";
} else {
    echo "<script>alert('Error al agregar autor: " . $stmt->error . "'); window.history.back();</script>";
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
