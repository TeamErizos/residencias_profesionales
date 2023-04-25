<?php

// Incluir archivo de conexión a la base de datos
include '../conexion/conectAWS.php';

// Preparar la consulta SQL
$sql = "SELECT * FROM CUENTA";

// Ejecutar la consulta y obtener un objeto PDOStatement
$stmt = $conn->query($sql);

// Iterar sobre los resultados
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: " . $row['id_cuenta'] . "<br>";
    echo "Correo electrónico: " . $row['mail_cuenta'] . "<br>";
    echo "Contraseña: " . $row['password_cuenta'] . "<br>";
    echo "Rol ID: " . $row['fk_id_rol'] . "<br>";
    echo "<br>";
}


?>