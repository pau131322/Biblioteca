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
$titulo = '';
$autor = '';
$isbn = '';

// Buscar libro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['titulo']) && !isset($_POST['nuevo_titulo'])) {
    $tituloBuscado = $conn->real_escape_string($_POST['titulo']);
    $sql = "SELECT Titulo, Autor, ISBN FROM libros WHERE Titulo LIKE ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $tituloParam = "%$tituloBuscado%";
        $stmt->bind_param("s", $tituloParam);
        $stmt->execute();
        $stmt->bind_result($titulo, $autor, $isbn);

        if ($stmt->fetch()) {
            $mostrarResultados = true;
        }

        $stmt->close();
    }
}
// Actualizar libro
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nuevo_titulo']) && isset($_POST['nuevo_autor']) && isset($_POST['nuevo_isbn'])) {
    $tituloOriginal = $conn->real_escape_string($_POST['titulo_original']);
    $nuevoTitulo = $conn->real_escape_string($_POST['nuevo_titulo']);
    $nuevoAutor = $conn->real_escape_string($_POST['nuevo_autor']);
    $nuevoISBN = $conn->real_escape_string($_POST['nuevo_isbn']);

    $sql = "UPDATE libros SET Titulo=?, Autor=?, ISBN=? WHERE Titulo=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $nuevoTitulo, $nuevoAutor, $nuevoISBN, $tituloOriginal);
        if ($stmt->execute()) {
            echo "Libro actualizado correctamente";
        } else {
            echo "Error al actualizar el libro";
        }
        $stmt->close();
    }
}

$conn->close();

// Incluir el archivo HTML de la interfaz
include 'libroactualizacion.html';
?>
