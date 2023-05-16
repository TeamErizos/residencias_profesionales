<?php
require_once('conectAWS.php');

$sql = "SELECT * FROM Proyecto_X_Alumno";
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