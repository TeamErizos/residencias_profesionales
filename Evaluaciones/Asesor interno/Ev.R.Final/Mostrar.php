<?php
require_once('conectAWS.php');

$sql = "SELECT calif_reporte_asesor_interno, calif_reporte_asesor_externo FROM Proyecto_X_Alumno WHERE id_p_x_a = 453747";
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