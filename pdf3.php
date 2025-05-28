<?php
require('C:\xampp\htdocs\Biblioteca\fpdf\fpdf.php');  

class PDF extends FPDF {
    function Header() {
        $this->Image('C:/xampp/htdocs/Biblioteca/logo.png',10,6,25);
        $this->SetFont('Arial','B',20);
        $this->Cell(40);
        $this->Ln(20);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',10);
        $this->SetTextColor(128);
        $this->Cell(0,10,'Book of the Soul - Página '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$host = "localhost";
$usuario = "root";
$contrasena = "";
$basededatos = "dinobase";

$conn = new mysqli($host, $usuario, $contrasena, $basededatos);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT Autor, Libro FROM autores";
$result = $conn->query($sql);
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$pdf->Cell(0,10,'Listado de Autores y Libros',0,1,'C');
$pdf->Ln(5);

$colorRosa = [255, 182, 193];
$colorBlanco = [255, 255, 255];
$colorTexto = [0, 0, 0];

$headers = ['Autor', 'Libro'];
$anchoColumnas = [70, 100];

$pdf->SetFillColor($colorRosa[0], $colorRosa[1], $colorRosa[2]);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',12);
foreach ($headers as $key => $header) {
    $pdf->Cell($anchoColumnas[$key],10,$header,1,0,'C',true);
}
$pdf->Ln();

$pdf->SetFont('Arial','',10);
$fill = false;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($fill) {
            $pdf->SetFillColor($colorRosa[0], $colorRosa[1], $colorRosa[2]);
        } else {
            $pdf->SetFillColor($colorBlanco[0], $colorBlanco[1], $colorBlanco[2]);
        }
        $pdf->SetTextColor($colorTexto[0], $colorTexto[1], $colorTexto[2]);

        $pdf->Cell($anchoColumnas[0],10,utf8_decode($row['Autor']),1,0,'L',true);
        $pdf->Cell($anchoColumnas[1],10,utf8_decode($row['Libro']),1,0,'L',true);

        $pdf->Ln();
        $fill = !$fill;
    }
} else {
    $pdf->Cell(array_sum($anchoColumnas),10,'No se encontraron datos',1,1,'C',true);
}

$conn->close();

$pdf->Output('I', 'ListadoAutoresLibros.pdf');
?>
