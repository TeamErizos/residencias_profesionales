<?php

// Configuración de la conexión a la base de datos
include '../conexion/conectAWS.php';

// Preparar la consulta
$sql = "SELECT * FROM ROL";
$stmt = $conn->prepare($sql);

// Ejecutar la consulta
$stmt->execute();

// Recuperar los resultados
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Iterar sobre los resultados y mostrarlos
foreach ($resultados as $fila) {
    echo "ID_Rol: " . $fila['id_rol'] . "<br>";
    echo "nom_rol: " . $fila['nom_rol'] . "<br>";
    echo "desc_rol: " . $fila['desc_rol'] . "<br>";
    echo "<br>";
}

?>