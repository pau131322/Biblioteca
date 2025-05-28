<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "dinobase");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener el título del libro
$titulo = $_GET['titulo'] ?? '';

if ($titulo === '') {
    echo "No se proporcionó un título.";
    exit;
}

// Consulta por título
$sql = "SELECT * FROM libros WHERE Titulo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $titulo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "No se encontró un libro con ese título.";
    exit;
}

$libro = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Libro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fde4f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
            flex-direction: column;
        }
        .container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
            width: 400px;
        }
        h1 {
            color: #e7abd5;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #e7abd5;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #e7abd5;
            border-radius: 5px;
        }
        .button {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            background-color: #e7abd5;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #d882c4;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Modificar Datos del Libro</h1>
    <form action="guardar_actualizacion.php" method="post">
        <input type="hidden" name="titulo_original" value="<?= htmlspecialchars($libro['Titulo']) ?>">

        <div class="form-group">
            <label for="codigo">Código:</label>
            <input type="number" name="codigo" id="codigo" value="<?= $libro['Codigo'] ?>" required>
        </div>

        <div class="form-group">
            <label for="autor">Autor:</label>
            <input type="text" name="autor" id="autor" value="<?= htmlspecialchars($libro['Autor']) ?>" required>
        </div>

        <div class="form-group">
            <label for="editorial">Editorial:</label>
            <input type="text" name="editorial" id="editorial" value="<?= htmlspecialchars($libro['Editorial']) ?>" required>
        </div>

        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <input type="text" name="categoria" id="categoria" value="<?= htmlspecialchars($libro['Categoria']) ?>" required>
        </div>

        <div class="form-group">
            <label for="idioma">Idioma:</label>
            <input type="text" name="idioma" id="idioma" value="<?= htmlspecialchars($libro['Idioma']) ?>" required>
        </div>

        <div class="form-group">
            <label for="formato">Formato:</label>
            <input type="text" name="formato" id="formato" value="<?= htmlspecialchars($libro['Formato']) ?>" required>
        </div>

        <button type="submit" class="button">Guardar Cambios</button>
    </form>
</div>

</body>
</html>
