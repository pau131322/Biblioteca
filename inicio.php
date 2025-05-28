<?php

session_start();


$host = "localhost";
$usuario_db = "root";  
$contraseña_db = "";   
$base_datos = "dinobase";


$conexion = new mysqli($host, $usuario_db, $contraseña_db, $base_datos);


if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario = $_POST['nombre'];
$contraseña = $_POST['contraseña'];


$consulta = $conexion->prepare("SELECT * FROM bibliotecario WHERE nombre = ? AND contraseña = ?");
$consulta->bind_param("ss", $usuario, $contraseña);
$consulta->execute();
$resultado = $consulta->get_result();

if ($resultado->num_rows > 0) {
    
    $_SESSION['nombre'] = $usuario;
    
    
    header("Location: mernu.html");
    exit(); 
} else {
    
    echo "Usuario o contraseña incorrectos";
}

$consulta->close();
$conexion->close();
?>

