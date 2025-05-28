<?php
// Conectar a la base de datos
$servername = "localhost"; // Cambia esto si tu servidor de base de datos es diferente
$username = "root";        // Usuario de la base de datos (ajustar según sea necesario)
$password = "";            // Contraseña de la base de datos (ajustar según sea necesario)
$dbname = "dinobase";      // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los valores del formulario (con validación)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $id_control = $_POST['id_control'];
    $fcPresta = $_POST['fc_prestamo'];
    $fcRegreso = $_POST['fc_regreso'];
    $tiempoP = $_POST['tiempo_prestado'];
    $estadoL = $_POST['estado_libro'];
    $multa = $_POST['multa'];

    // Verificar si el ID de control está vacío
    if (empty($id_control)) {
        echo json_encode(['error' => 'El campo ID Control es obligatorio.']);
        exit();
    }

    // Preparar la consulta SQL para actualizar los datos
    $sql = "UPDATE prestamos SET 
            Nombre = ?, 
            FcPresta = ?, 
            FcRegreso = ?, 
            TiempoP = ?, 
            EstadoL = ?, 
            Multa = ? 
            WHERE Id_control = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nombre, $fcPresta, $fcRegreso, $tiempoP, $estadoL, $multa, $id_control);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(['success' => 'Datos actualizados correctamente.']);
    } else {
        echo json_encode(['error' => 'Error al actualizar los datos: ' . $conn->error]);
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
