<?php
// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "dinobase");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$mensaje = "";
$mostrarFormulario = true;
$logs = [];
function registrar_log($mensaje) {
    global $logs;
    $logs[] = $mensaje;
    error_log($mensaje); // Esto lo manda al log de PHP
}

// Eliminar libro si se envió el código
if (isset($_POST['eliminar']) && isset($_POST['codigo'])) {
    $codigo = $conn->real_escape_string($_POST['codigo']);
    $sqlEliminar = "DELETE FROM libros WHERE Codigo = '$codigo'";
    if ($conn->query($sqlEliminar)) {
        if ($conn->affected_rows > 0) {
            $mensaje = "✅ Libro eliminado correctamente.";
        } else {
            $mensaje = "⚠️ No se encontró el libro para eliminar.";
        }
    } else {
        $mensaje = "❌ Error al eliminar: " . $conn->error;
    }
    $mostrarFormulario = true;
}

// Buscar libro por título
if (isset($_GET['titulo']) && !$mensaje) {
    $titulo = $conn->real_escape_string($_GET['titulo']);
    $sqlBuscar = "SELECT * FROM libros WHERE Titulo LIKE '%$titulo%' COLLATE utf8mb4_general_ci LIMIT 1";
    $resultado = $conn->query($sqlBuscar);

    if ($resultado && $resultado->num_rows > 0) {
        $libro = $resultado->fetch_assoc();
        $mostrarFormulario = false;
    } else {
        $mensaje = "⚠️ No se encontró el libro con ese título.";
        $mostrarFormulario = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Libro</title>
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
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #d882c4;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .mensaje {
            margin-bottom: 20px;
            font-weight: bold;
            color: #a33;
        }
        p {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consultar Libro</h1>

        <?php if ($mensaje): ?>
            <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <?php if ($mostrarFormulario): ?>
            <form method="GET" action="">
                <input type="text" name="titulo" placeholder="Ingresa el título del libro" required>
                <button type="submit" class="button">Buscar Libro</button>
            </form>
        <?php else: ?>
            <h2><?= htmlspecialchars($libro['Titulo']) ?></h2>
            <p><strong>Código:</strong> <?= htmlspecialchars($libro['Codigo']) ?></p>
            <p><strong>Autor:</strong> <?= htmlspecialchars($libro['Autor']) ?></p>
            <p><strong>Editorial:</strong> <?= htmlspecialchars($libro['Editorial']) ?></p>
            <p><strong>Categoría:</strong> <?= htmlspecialchars($libro['Categoria']) ?></p>
            <p><strong>Idioma:</strong> <?= htmlspecialchars($libro['Idioma']) ?></p>
            <p><strong>Formato:</strong> <?= htmlspecialchars($libro['Formato']) ?></p>

        
            <button onclick="window.location.href=''" class="button" style="background-color:#ccc; color:#333;">Buscar otro libro</button>
        <?php endif; ?>

        <?php if (!empty($logs)): ?>
            <div style="text-align:left; margin-top:30px; background:#f9f9f9; border:1px solid #ccc; padding:10px;">
                <h3>Registro de eventos (debug):</h3>
                <ul>
                    <?php foreach ($logs as $log): ?>
                        <li><?= htmlspecialchars($log) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    </form>
        <a href="mernu.html" class="back-link">Volver al inicio</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
