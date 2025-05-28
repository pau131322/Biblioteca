<?php
session_start();


$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "dinobase";


$mostrarResultados = false;
$nombre = "";
$password_bibliotecario = "";
$mensaje = "";
$tipoMensaje = "";


if (isset($_SESSION['mensaje']) && isset($_SESSION['tipoMensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $tipoMensaje = $_SESSION['tipoMensaje'];
 
    unset($_SESSION['mensaje']);
    unset($_SESSION['tipoMensaje']);
}

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $nombre = $_POST['nombre'];
    
    $sql_delete = "DELETE FROM bibliotecario WHERE Nombre = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("s", $nombre);
    
    if ($stmt_delete->execute()) {
        $mensaje = "Bibliotecario eliminado correctamente.";
        $tipoMensaje = "success";
    } else {
        $mensaje = "Error al eliminar el bibliotecario: " . $stmt_delete->error;
        $tipoMensaje = "error";
    }
    
    $stmt_delete->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['eliminar'])) {
    $nombre = $_POST['nombre'];
    

    $sql = "SELECT Nombre, Contraseña FROM bibliotecario WHERE Nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre);
    
    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar si se encontró el bibliotecario
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row["Nombre"];
        $password_bibliotecario = $row["Contraseña"];
        $mostrarResultados = true;
    } else {
        $mensaje = "No se encontró ningún bibliotecario con ese nombre.";
        $tipoMensaje = "error";
    }
    
    $stmt->close();
}

// Cerrar la conexión a la base de datos
include 'elimbibliotecar.html';
?>