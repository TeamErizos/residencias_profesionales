<!--Lineas 6 y 7... Incluye la base de datos a la clase-->
<!--Lineas 8 a 15... Se realiza una Query para eliminar filas de la base de datos y la pagina-->
<?php

include("ConexionBD.php");
$con = connection();

$IDProyecto=$_GET["IDProyecto"];

$sql="DELETE FROM Proyectos WHERE IDProyecto='$IDProyecto'";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: FormProyectos.php");
}else{

}

?>