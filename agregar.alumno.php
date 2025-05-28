<?php
// Configuración de la base de datos
$host = 'localhost'; // O la dirección de tu servidor
$usuario = 'root'; // Tu usuario de base de datos
$contraseña = ''; // Tu contraseña de base de datos
$base_de_datos = 'dinobase';

// Conexión a la base de datos
$conn = new mysqli($host, $usuario, $contraseña, $base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si los datos del formulario fueron enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $id_control = $_POST['id_control'];
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $fecha_regreso = $_POST['fecha_regreso'];
    $tiempo_prestado = $_POST['tiempo_prestado'];
    $estado_libro = $_POST['estado_libro'];
    $multa = $_POST['multa'];

    // Consulta SQL para insertar los datos
    $sql = "INSERT INTO prestamos (Nombre, Id_control, FcPresta, FcRegreso, TiempoP, EstadoL, Multa)
            VALUES ('$nombre', '$id_control', '$fecha_prestamo', '$fecha_regreso', '$tiempo_prestado', '$estado_libro', '$multa')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo registro agregado correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>
