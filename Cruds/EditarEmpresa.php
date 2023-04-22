<!--Lineas 6 y 7... Implementacion de la Base de Datos-->
<!--Lineas 9 a 16... Campos de la base de datos que se afectaran para la actualizacion de la tabla-->
<!--Lineas 18 a 25... Query UPDATE para actualizar una fila de la tabla-->
<?php

include("ConexionBD.php");
$con = connection();

$IDEmpresa=$_POST["IDEmpresa"];
$NombreEmpresa = $_POST['NombreEmpresa'];
$Ramo = $_POST['Ramo'];
$Sector = $_POST['Sector'];
$ActividadPrincipal = $_POST['ActividadPrincipal'];
$Domicilio = $_POST['Domicilio'];
$Colonia = $_POST['Colonia'];
$Ciudad = $_POST['Ciudad'];
$RFC = $_POST['RFC'];
$NombreRepresentante = $_POST['NombreRepresentante'];
$Puesto = $_POST['Puesto'];

$sql="UPDATE Empresa SET NombreEmpresa='$NombreEmpresa', Ramo='$Ramo', Sector='$Sector', ActividadPrincipal='$ActividadPrincipal', Domicilio='$Domicilio', Colonia='$Colonia', Ciudad='$Ciudad', RFC='$RFC', NombreRepresentante='$NombreRepresentante', Puesto='$Puesto' WHERE IDEmpresa='$IDEmpresa'";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: FormEmpresa.php");
}else{

}

?>