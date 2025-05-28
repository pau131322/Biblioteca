<?php
// Inicializar variables
$mostrarResultados = false;
$noResultados = false;
$nombre = "";
$password = "";

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
    
    
    $sql = "SELECT Alumnos, Id_control FROM alumnos WHERE Alumnos LIKE ?";
    
    // Preparar statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Añadir comodines para búsqueda parcial
        $nombreParam = "%$nombreBuscado%";
        $stmt->bind_param("s", $nombreParam);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Vincular resultados a variables
        $stmt->bind_result($nombre, $password);
        
        // Verificar si se encontraron resultados
        if ($stmt->fetch()) {
            $mostrarResultados = true;
            $noResultados = false;
        } else {
            $mostrarResultados = false;
            $noResultados = true;
        }
        
        // Cerrar statement
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
    
    // Cerrar conexión
    $conn->close();
}

// Incluir el archivo HTML para mostrar los resultados
include 'Alum.consultar.html';
?>