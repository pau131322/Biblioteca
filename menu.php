<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: inicio.html"); 
    exit();
}
?>


<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ola.css">
    <title>Menú</title>
</head>
<body>
    <div class="menu-container">
        <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
        <h3>Tipo de libros</h3>
        <ul>
            <li>Terror</li>
            <li>Romántico</li>
            <li>Fantasía</li>
            <li>Poemas</li>
            <li>Aventura</li>
            <li>Manga</li>
        </ul>
        <button onclick="consultarLibros()">Consultar Libros en Stock</button>
        <button onclick="prestamoLibros()">Préstamo de Libros</button>
    </div>

    <script>
        function consultarLibros() {
            alert("Consulta de libros en stock."); // Aquí puedes implementar la lógica para consultar
        }

        function prestamoLibros() {
            alert("Iniciar préstamo de libros."); // Aquí puedes implementar la lógica para el préstamo
        }
    </script>
</body>
</html>
