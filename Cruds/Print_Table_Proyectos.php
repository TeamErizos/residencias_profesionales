<?php
// Incluir la librería FPDF
require('fpdf185/fpdf.php');

// Crear un objeto de la clase FPDF con orientación horizontal y tamaño de página A4
$pdf = new FPDF('L','mm','A4');

// Añadir una página en orientación horizontal
$pdf->AddPage('L','A4');

// Establecer la fuente y el tamaño de letra para el título
$pdf->SetFont('Arial','B',16);

// Escribir el título
$pdf->Cell(0,10,'Vista de Proyectos Registrados',0,1);

// Establecer la fuente y el tamaño de letra para la tabla
$pdf->SetFont('Arial','',12);

// Crear la tabla
$pdf->Cell(20,10,'IDProyecto',1);
$pdf->Cell(40,10,'NombreProyecto',1);
$pdf->Cell(30,10,'TipoProyecto',1);
$pdf->Cell(50,10,'OpcionProyecto',1);
$pdf->Cell(30,10,'PeriodoInicio',1);
$pdf->Cell(30,10,'PeriodoFinal',1);
$pdf->Cell(50,10,'NombreAsesorInterno',1);
$pdf->Cell(30,10,'NumResidentes',1);
$pdf->Ln();

// Obtener los datos de la tabla y agregarlos a la tabla del PDF
include("ConexionBD.php");
$con = connection();

$sql = "SELECT * FROM Proyectos";
$query = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($query)) {
    $pdf->Cell(20,10,$row['IDProyecto'],1);
    $pdf->Cell(40,10,$row['NombreProyecto'],1);
    $pdf->Cell(30,10,$row['TipoProyecto'],1);
    $pdf->Cell(50,10,$row['OpcionProyecto'],1);
    $pdf->Cell(30,10,$row['PeriodoInicio'],1);
    $pdf->Cell(30,10,$row['PeriodoFinal'],1);
    $pdf->Cell(50,10,$row['NombreAsesorInterno'],1);
    $pdf->Cell(30,10,$row['NumResidentes'],1);
    $pdf->Ln();
}

// Descargar el documento PDF
$pdf->Output();
?>
