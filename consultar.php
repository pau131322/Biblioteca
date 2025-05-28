<?php
session_start();

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "dinobase";

// Variables para almacenar los datos de los libros
$codigo = "";
$titulo = "";
$autor = "";
$editorial = "";
$categoria = "";
$idioma = "";
$formato = "";

$mensaje = "";
$tipoMensaje = "";
$mostrarResultados = false;

// Verificar si hay mensajes de sesión
if (isset($_SESSION['mensaje']) && isset($_SESSION['tipoMensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $tipoMensaje = $_SESSION['tipoMensaje'];

    // Limpiar los mensajes de sesión
    unset($_SESSION['mensaje']);
    unset($_SESSION['tipoMensaje']);
}

// Crear conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Comprobar si se ha enviado el código del libro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];

    // Consultar el libro con el código proporcionado
    $sql = "SELECT codigo, titulo, autor, editorial, categoria, idioma, formato FROM libros WHERE codigo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);
    
    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar si se encontró el libro
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $codigo = $row["codigo"];
        $titulo = $row["titulo"];
        $autor = $row["autor"];
        $editorial = $row["editorial"];
        $categoria = $row["categoria"];
        $idioma = $row["idioma"];
        $formato = $row["formato"];
        $mostrarResultados = true;
    } else {
        $mensaje = "No se encontró ningún libro con ese código.";
        $tipoMensaje = "error";
    }
    
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();

// Incluir la vista para mostrar los resultados
include 'consultar.html';
?>
