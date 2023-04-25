<!--Lineas 6 y 7... Implementacion de la Base de Datos-->
<!--Lineas 9 a 16... Campos de la base de datos que se afectaran para la actualizacion de la tabla-->
<!--Lineas 18 a 25... Query UPDATE para actualizar una fila de la tabla-->
<?php

include("ConexionBD.php");
$con = connection();

$IDProyecto=$_POST["IDProyecto"];
$NombreProyecto = $_POST['NombreProyecto'];
$TipoProyecto = $_POST['TipoProyecto'];
$OpcionProyecto = $_POST['OpcionProyecto'];
$PeriodoInicio = $_POST['PeriodoInicio'];
$PeriodoFinal = $_POST['PeriodoFinal'];
$NombreAsesorInterno = $_POST['NombreAsesorInterno'];
$NumResidentes = $_POST['NumResidentes'];

$sql="UPDATE Proyectos SET NombreProyecto='$NombreProyecto', TipoProyecto='$TipoProyecto', OpcionProyecto='$OpcionProyecto', PeriodoInicio='$PeriodoInicio', PeriodoFinal='$PeriodoFinal', NombreAsesorInterno='$NombreAsesorInterno', NumResidentes='$NumResidentes' WHERE IDProyecto='$IDProyecto'";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: FormProyectos.php");
}else{

}

?>