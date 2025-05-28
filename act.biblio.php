<?php 
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "dinobase";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$mostrarResultados = false;
$nombre = '';
$password = '';

// Verificar si se realizó una búsqueda o una actualización
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && !isset($_POST['nuevo_nombre'])) {
    // Buscar bibliotecario
    $nombreBuscado = $conn->real_escape_string($_POST['nombre']);
    $sql = "SELECT Nombre, Contraseña FROM bibliotecario WHERE Nombre LIKE ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $nombreParam = "%$nombreBuscado%";
        $stmt->bind_param("s", $nombreParam);
        $stmt->execute();
        $stmt->bind_result($nombre, $password);

        if ($stmt->fetch()) {
            $mostrarResultados = true; // Solo muestra los resultados si hay coincidencias
        }

        $stmt->close();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nuevo_nombre']) && isset($_POST['nueva_password'])) {
    // Actualizar bibliotecario
    $nombreOriginal = $conn->real_escape_string($_POST['nombre_original']);
    $nuevoNombre = $conn->real_escape_string($_POST['nuevo_nombre']);
    $nuevaPassword = $conn->real_escape_string($_POST['nueva_password']);

    $sql = "UPDATE bibliotecario SET Nombre=?, Contraseña=? WHERE Nombre=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $nuevoNombre, $nuevaPassword, $nombreOriginal);
        if ($stmt->execute()) {
            echo "Datos actualizados correctamente";
        } else {
            echo "Error al actualizar los datos";
        }
        $stmt->close();
    }
}

$conn->close();

// Incluir el archivo HTML para la interfaz
include 'biblioactualizacion.html';
?>
