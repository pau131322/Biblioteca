<?php
// Verificar si se ha enviado la solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alumno'])) {
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
    
    $alumnoAEliminar = $conn->real_escape_string($_POST['alumno']);
    
    // Consulta SQL para eliminar el alumno
    $sql = "DELETE FROM alumnos WHERE Alumnos = ?";
    
    // Preparar statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $alumnoAEliminar);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode([
                'success' => 'Alumno eliminado correctamente.'
            ]);
        } else {
            echo json_encode([
                'error' => 'Error al eliminar el alumno.'
            ]);
        }
        
        // Cerrar statement
        $stmt->close();
    } else {
        echo json_encode([
            'error' => 'Error en la preparación de la consulta: ' . $conn->error
        ]);
    }
    
    // Cerrar conexión
    $conn->close();
} else {
    echo json_encode([
        'error' => 'No se recibió el nombre del alumno.'
    ]);
}
?>
