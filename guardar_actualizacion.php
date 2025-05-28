<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "dinobase");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$titulo_original = $_POST['titulo_original'] ?? '';
$codigo = $_POST['codigo'] ?? '';
$autor = $_POST['autor'] ?? '';
$editorial = $_POST['editorial'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$idioma = $_POST['idioma'] ?? '';
$formato = $_POST['formato'] ?? '';

// Verificar que todos los datos estén presentes
if ($titulo_original === '' || $codigo === '' || $autor === '' || $editorial === '' || $categoria === '' || $idioma === '' || $formato === '') {
    echo "Faltan datos del formulario.";
    exit;
}

// Preparar y ejecutar la actualización
$sql = "UPDATE libros SET Codigo = ?, Autor = ?, Editorial = ?, Categoria = ?, Idioma = ?, Formato = ? WHERE Titulo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("issssss", $codigo, $autor, $editorial, $categoria, $idioma, $formato, $titulo_original);

if ($stmt->execute()) {
    echo "<h2>Libro actualizado correctamente.</h2>";
    echo '<a href="actualizacion.html">Volver</a>';
} else {
    echo "Error al actualizar el libro: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
