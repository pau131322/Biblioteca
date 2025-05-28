<?php
// Datos de conexión
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "dinobase";

// Conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    $mensaje = "Error de conexión: " . $conn->connect_error;
} else {
    // Obtener datos del formulario
    $codigo = $_POST['codigo'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];
    $categoria = $_POST['categoria'];
    $idioma = $_POST['idioma'];
    $formato = $_POST['formato'];

    // Insertar
    $sql = "INSERT INTO libros (Codigo, Titulo, Autor, Editorial, Categoria, Idioma, Formato) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $codigo, $titulo, $autor, $editorial, $categoria, $idioma, $formato);

    if ($stmt->execute()) {
        $mensaje = "✅ Libro agregado exitosamente.";
    } else {
        $mensaje = "❌ Error al agregar libro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fde4f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
            width: 400px;
        }
        h2 {
            color: #e7abd5;
            margin-bottom: 20px;
        }
        .message {
            font-size: 18px;
            color: #333;
            margin-bottom: 30px;
        }
        .back-link {
            display: inline-block;
            background-color: #e7abd5;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .back-link:hover {
            background-color: #d882c4;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Resultado</h2>
        <div class="message"><?php echo $mensaje; ?></div>
        <a class="back-link" href="agregar.html">Agregar otro libro</a><br><br>
        <a class="back-link" href="mernu.html">Volver al inicio</a>
    </div>
</body>
</html>
