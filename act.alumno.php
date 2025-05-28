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
$alumno = '';
$id_control = '';

// Verificar si se realizó una búsqueda
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alumno']) && !isset($_POST['nuevo_alumno'])) {
    // Buscar alumno
    $alumnoBuscado = $conn->real_escape_string($_POST['alumno']);
    $sql = "SELECT Alumnos, Id_control FROM alumnos WHERE Alumnos LIKE ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $alumnoParam = "%$alumnoBuscado%";
    $stmt->bind_param("s", $alumnoParam);
    
    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si la consulta devuelve algo
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Se encontraron resultados
        while ($row = $result->fetch_assoc()) {
            $alumno = $row['Alumnos'];
            $id_control = $row['Id_control'];
        }
        $mostrarResultados = true;
    } else {
        // No se encontraron resultados
        echo "No se encontraron resultados para '$alumnoBuscado'.<br><br>";
    }

    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nuevo_alumno']) && isset($_POST['nuevo_id_control'])) {
    // Actualizar alumno
    $alumnoOriginal = $conn->real_escape_string($_POST['alumno_original']);
    $nuevoAlumno = $conn->real_escape_string($_POST['nuevo_alumno']);
    $nuevoIdControl = $conn->real_escape_string($_POST['nuevo_id_control']);

    $sql = "UPDATE alumnos SET Alumnos=?, Id_control=? WHERE Alumnos=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $nuevoAlumno, $nuevoIdControl, $alumnoOriginal);
        if ($stmt->execute()) {
            echo "Datos actualizados correctamente<br><br>";
        } else {
            echo "Error al actualizar los datos<br><br>";
        }
        $stmt->close();
    }
}

$conn->close();

// Incluir el HTML con los resultados después de procesar la lógica
include 'alum.actualizar.html';
?>
