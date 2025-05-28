<?php
// Verificar si se recibió la solicitud POST con el nombre del autor
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

    // Recoger el nombre del autor
    $autor = $conn->real_escape_string($_POST['autor']);

    // Consulta SQL para eliminar el autor de la base de datos
    $sql = "DELETE FROM autores WHERE Autor LIKE ?";

    // Preparar el statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Añadir el parámetro para la consulta
        $autorParam = "%$autor%";
        $stmt->bind_param("s", $autorParam);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la eliminación fue exitosa
            $response = array('success' => "Autor eliminado correctamente.");
        } else {
            // Si hubo un error en la eliminación
            $response = array('error' => "No se pudo eliminar al autor.");
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        $response = array('error' => "Error en la preparación de la consulta: " . $conn->error);
    }

    // Cerrar la conexión
    $conn->close();

    // Enviar la respuesta como JSON
    echo json_encode($response);
}
?>
