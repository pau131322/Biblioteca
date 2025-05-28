<?php
// Configuración de la base de datos
$servername = "localhost"; // Cambia según tu configuración
$username = "root";        // Cambia según tu configuración
$password_db = "";         // Cambia según tu configuración
$dbname = "dinobase";      // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se han recibido los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_control']) && isset($_POST['nombre'])) {
    // Obtener los datos del formulario
    $id_control = $_POST['id_control'];
    $nombre = $_POST['nombre'];

    // Preparar la consulta SQL para actualizar el nombre del alumno
    $sql = "UPDATE alumnos SET Alumnos = ? WHERE Id_control = ?";

    // Preparar el statement
    if ($stmt = $conn->prepare($sql)) {
        // Enlazar los parámetros
        $stmt->bind_param("si", $nombre, $id_control); // 's' para string, 'i' para integer
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la actualización es exitosa
            echo json_encode([
                'success' => 'Datos actualizados correctamente.'
            ]);
        } else {
            // Si la ejecución falla
            echo json_encode([
                'error' => 'Error al actualizar los datos.'
            ]);
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo json_encode([
            'error' => 'Error al preparar la consulta.'
        ]);
    }
} else {
    echo json_encode([
        'error' => 'Datos incompletos o no recibidos.'
    ]);
}

// Cerrar la conexión
$conn->close();
?>
