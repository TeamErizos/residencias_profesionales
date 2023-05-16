<!--Lineas 5 y 6... Implementacion de la Base de Datos-->
<!--Lineas 8 a 15... Campos de la base de datos que se afectaran para la insercion a la tabla-->
<!--Lineas 18 a 25... Query INSERT para agragar datos a una fila de la tabla-->
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

$sql = "INSERT INTO Empresa VALUES('$IDEmpresa','$NombreEmpresa','$Ramo','$Sector','$ActividadPrincipal','$Domicilio','$Colonia','$Ciudad','$RFC','$NombreRepresentante','$Puesto')";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: FormEmpresa.php");
}else{

}

?>