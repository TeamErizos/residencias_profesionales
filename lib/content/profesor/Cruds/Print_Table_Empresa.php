<?php
require('fpdf185/fpdf.php');

//Crear instancia de la clase FPDF
$pdf = new FPDF();

//Agregar una página con orientación horizontal
$pdf->AddPage('L');

//Definir el tamaño y la orientación del papel
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Tabla de Empresas',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,10,'IDEmpresa',1,0,'C');
$pdf->Cell(50,10,'NombreEmpresa',1,0,'C');
$pdf->Cell(30,10,'Ramo',1,0,'C');
$pdf->Cell(30,10,'Sector',1,0,'C');
$pdf->Cell(40,10,'ActividadPrincipal',1,0,'C');
$pdf->Cell(40,10,'Domicilio',1,0,'C');
$pdf->Cell(30,10,'Colonia',1,0,'C');
$pdf->Cell(30,10,'Ciudad',1,0,'C');
$pdf->Cell(30,10,'RFC',1,0,'C');
$pdf->Cell(50,10,'NombreRepresentante',1,0,'C');
$pdf->Cell(30,10,'Puesto',1,1,'C');

//Incluir conexion a la Base de Datos y Query para mostrar los datos de la tabla
include("ConexionBD.php");
$con = connection();

$sql = "SELECT * FROM Empresa";
$query = mysqli_query($con, $sql);

//Definir las celdas de la tabla y agregar los datos de la consulta
$pdf->SetFont('Arial','',10);
while ($row = mysqli_fetch_array($query)){
    $pdf->Cell(20,10,$row['IDEmpresa'],1,0,'C');
    $pdf->Cell(50,10,$row['NombreEmpresa'],1,0,'L');
    $pdf->Cell(30,10,$row['Ramo'],1,0,'C');
    $pdf->Cell(30,10,$row['Sector'],1,0,'C');
    $pdf->Cell(40,10,$row['ActividadPrincipal'],1,0,'L');
    $pdf->Cell(40,10,$row['Domicilio'],1,0,'L');
    $pdf->Cell(30,10,$row['Colonia'],1,0,'L');
    $pdf->Cell(30,10,$row['Ciudad'],1,0,'L');
    $pdf->Cell(30,10,$row['RFC'],1,0,'L');
    $pdf->Cell(50,10,$row['NombreRepresentante'],1,0,'L');
    $pdf->Cell(30,10,$row['Puesto'],1,1,'L');
}

//Cerrar la conexión a la Base de Datos
mysqli_close($con);

//Mostrar el archivo PDF
$pdf->Output();
?>
