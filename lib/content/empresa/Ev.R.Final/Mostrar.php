<?php
require_once('../../Conexión/conectAWS.php');

$sql = "SELECT * FROM Proyecto_X_Alumno";
//$sql = "UPDATE Proyecto_X_Alumno SET calif_reporte_asesor_interno = NULL WHERE id_p_x_a = 103661"; 
//$sql = "UPDATE Proyecto_X_Alumno SET calif_parcial2_asesor_externo = NULL WHERE id_p_x_a = 103661";
//$sql = "UPDATE Proyecto_X_Alumno SET calif_parcial1_asesor_externo = NULL WHERE id_p_x_a = 103661";
//$sql = "UPDATE Proyecto_X_Alumno SET calif_parcial2_asesor_interno = NULL WHERE id_p_x_a = 103661";
//$sql = "UPDATE Proyecto_X_Alumno SET calif_parcial1_asesor_interno = NULL WHERE id_p_x_a = 103661"; 
//$sql = "UPDATE Proyecto_X_Alumno SET calif_reporte_asesor_interno = NULL WHERE id_p_x_a = 162666";
//$sql = "UPDATE Proyecto_X_Alumno SET calif_reporte_asesor_externo = NULL WHERE id_p_x_a = 162666"; 
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados como un arreglo asociativo
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mostrar los resultados
foreach ($resultado as $fila) {
  foreach ($fila as $clave => $valor) {
    echo "$clave: $valor <br>";
  }
  echo "<br>";
}
?>