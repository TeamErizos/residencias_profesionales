<!--Lineas 5 y 6... Implementacion de la Base de Datos-->
<!--Lineas 8 a 15... Campos de la base de datos que se afectaran para la insercion a la tabla-->
<!--Lineas 18 a 25... Query INSERT para agragar datos a una fila de la tabla-->
<?php
include("ConexionBD.php");
$con = connection();

$IDProyecto = $_POST['IDProyecto'];
$NombreProyecto = $_POST['NombreProyecto'];
$TipoProyecto = $_POST['TipoProyecto'];
$OpcionProyecto = $_POST['OpcionProyecto'];
$PeriodoInicio = $_POST['PeriodoInicio'];
$PeriodoFinal = $_POST['PeriodoFinal'];
$NombreAsesorInterno = $_POST['NombreAsesorInterno'];
$NumResidentes = $_POST['NumResidentes'];

$sql = "INSERT INTO Proyectos VALUES('$IDProyecto','$NombreProyecto','$TipoProyecto','$OpcionProyecto','$PeriodoInicio','$PeriodoFinal','$NombreAsesorInterno','$NumResidentes')";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: FormProyectos.php");
}else{

}

?>