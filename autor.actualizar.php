<?php
// Inicializar variables
$autor = "";
$libro = "";
$response = array(); // Array para almacenar la respuesta

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['autor']) && isset($_POST['libro'])) {
    // Configuración de la conexión a la base de datos
    $servername = "localhost"; // Cambia según tu configuración
    $username = "root";        // Cambia según tu configuración
    $password_db = "";         // Cambia según tu configuración
    $dbname = "dinobase";
    
    // Crear conexión
    $conn = new mysqli($servername, $username, $password_db, $dbname);
    
    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Recibir los valores enviados del formulario
    $autor = $conn->real_escape_string($_POST['autor']);
    $libro = $conn->real_escape_string($_POST['libro']);
    
    // Consulta SQL para actualizar los datos del autor
    $sql = "UPDATE autores SET Libro = ? WHERE Autor = ?";
    
    // Preparar statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Vincular parámetros
        $stmt->bind_param("ss", $libro, $autor);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la actualización fue exitosa
            $response['success'] = "Datos actualizados correctamente.";
        } else {
            // Si ocurrió un error en la ejecución de la consulta
            $response['error'] = "Error al actualizar los datos: " . $stmt->error;
        }

        // Cerrar statement
        $stmt->close();
    } else {
        // Error en la preparación de la consulta
        $response['error'] = "Error en la preparación de la consulta: " . $conn->error;
    }

    // Cerrar conexión
    $conn->close();
}

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>
