<?php
// Inicializar variables
$mostrarResultados = false;
$noResultados = false;
$nombre = "";
$Id_control = ""; // Variable para almacenar el ID de control

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
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
    
    $nombreBuscado = $conn->real_escape_string($_POST['nombre']);
    
    // Consulta SQL para obtener los datos del alumno
    $sql = "SELECT Id_control FROM alumnos WHERE Alumnos LIKE ?";
    
    // Preparar statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Añadir comodines para búsqueda parcial
        $nombreParam = "%$nombreBuscado%";
        $stmt->bind_param("s", $nombreParam);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Vincular resultados a variables
        $stmt->bind_result($Id_control);
        
        // Verificar si se encontraron resultados
        if ($stmt->fetch()) {
            // Si encontramos un resultado, retornamos el ID de control
            $mostrarResultados = true;
        } else {
            // Si no hay resultados, definimos noResultados
            $noResultados = true;
        }
        
        // Cerrar statement
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
    
    // Cerrar conexión
    $conn->close();

    // Responder con JSON
    if ($mostrarResultados) {
        echo json_encode([
            'Id_control' => $Id_control,
            'error' => null
        ]);
    } else {
        echo json_encode([
            'error' => 'No se encontraron resultados para ese alumno.'
        ]);
    }
} else {
    echo json_encode([
        'error' => 'No se recibió el nombre del alumno.'
    ]);
}
?>
