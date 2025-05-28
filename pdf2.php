<?php
// Incluir la biblioteca FPDF con ruta absoluta
require('C:\xampp\htdocs\Biblioteca\fpdf\fpdf.php');  

class PDF extends FPDF {
    // Cabecera
    function Header() {
        $this->Image('C:/xampp/htdocs/Biblioteca/logo.png',10,6,25); // Logo un poco más pequeño (ancho 25)
        $this->SetFont('Arial','B',20);
        $this->Cell(40);
        $this->Ln(20);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',10);
        $this->SetTextColor(128);
        $this->Cell(0,10,'Book of the Soul - Página '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Datos de conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$basededatos = "dinobase";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $basededatos);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los datos de la tabla alumnos
$sql = "SELECT Id_control, Alumnos FROM alumnos";
$result = $conn->query($sql);
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Crear el PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

// Título central
$pdf->Cell(0,10,'Listado de Alumnos',0,1,'C');
$pdf->Ln(5);

// Definir colores
$colorRosa = [255, 182, 193]; // rosa pastel
$colorBlanco = [255, 255, 255];
$colorTexto = [0, 0, 0];

// Encabezados y anchos de columnas
$headers = ['Id_control', 'Alumnos'];
$anchoColumnas = [40, 80];

// Imprimir encabezados con fondo rosa pastel
$pdf->SetFillColor($colorRosa[0], $colorRosa[1], $colorRosa[2]);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',12);
foreach ($headers as $key => $header) {
    $pdf->Cell($anchoColumnas[$key],10,$header,1,0,'C',true);
}
$pdf->Ln();

// Datos con filas alternadas
$pdf->SetFont('Arial','',12);
$fill = false;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($fill) {
            $pdf->SetFillColor($colorRosa[0], $colorRosa[1], $colorRosa[2]);
        } else {
            $pdf->SetFillColor($colorBlanco[0], $colorBlanco[1], $colorBlanco[2]);
        }
        $pdf->SetTextColor($colorTexto[0], $colorTexto[1], $colorTexto[2]);

        $pdf->Cell($anchoColumnas[0],10,$row['Id_control'],1,0,'C',true);
        $pdf->Cell($anchoColumnas[1],10,utf8_decode($row['Alumnos']),1,0,'L',true);

        $pdf->Ln();
        $fill = !$fill;
    }
} else {
    $pdf->Cell(array_sum($anchoColumnas),10,'No se encontraron datos',1,1,'C',true);
}

$conn->close();

$pdf->Output('I', 'ListadoAlumnos.pdf');
?>
