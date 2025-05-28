<?php 
// Inicializar variables
$autor = "";
$libro = "";
$response = array(); // Array para almacenar la respuesta

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['autor'])) {
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
    
    $autorBuscado = $conn->real_escape_string($_POST['autor']);
    
    // Consulta SQL para buscar autores
    $sql = "SELECT Autor, Libro FROM autores WHERE Autor LIKE ?";
    
    // Preparar statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Añadir comodines para búsqueda parcial
        $autorParam = "%$autorBuscado%";
        $stmt->bind_param("s", $autorParam);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Vincular resultados a variables
        $stmt->bind_result($autor, $libro);
        
        // Verificar si se encontraron resultados
        if ($stmt->fetch()) {
            // Si encontramos resultados, devolverlos en JSON
            $response['libro'] = $libro;
            $response['autor'] = $autor;
        } else {
            // Si no se encuentran resultados, enviar error
            $response['error'] = "No se encontraron resultados para este autor.";
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
