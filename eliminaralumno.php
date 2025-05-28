<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dinobase";

header('Content-Type: application/json');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

if (isset($_POST['nombre'])) {
    $nombre = trim($conn->real_escape_string($_POST['nombre']));
    
    if ($nombre === "") {
        echo json_encode(["error" => "El nombre no puede estar vacío"]);
        exit;
    }

    // Primero, buscamos los datos del alumno
    $sql = "SELECT Id_control, FcPresta, FcRegreso, TiempoP, EstadoL, Multa FROM prestamos WHERE Nombre = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Después de obtener los datos, procedemos a eliminar el registro
        $delete_sql = "DELETE FROM prestamos WHERE Nombre = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("s", $nombre);
        $delete_stmt->execute();
        
        if ($delete_stmt->affected_rows > 0) {
            echo json_encode(["success" => "Alumno '$nombre' eliminado correctamente", "data" => $row]);
        } else {
            echo json_encode(["error" => "No se pudo eliminar el registro de '$nombre'"]);
        }
        
        $delete_stmt->close();
    } else {
        echo json_encode(["error" => "No se encontraron datos para el alumno '$nombre'"]);
    }
    
    $stmt->close();
}
$conn->close();
?>
