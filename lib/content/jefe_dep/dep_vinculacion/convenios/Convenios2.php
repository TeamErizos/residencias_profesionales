<?php

// Establish a connection to the PostgreSQL database
require "../../../../login/conexion/conectAWS.php";

$id_p_x_a = $_GET['id'];

// Obtener datos del alumno correspondiente
$sql = "SELECT proyecto_x_alumno.*,
        string_agg(alumno.nombre_alumno || ' ' || alumno.ape1_alumno || ' ' || alumno.ape2_alumno, ' ') AS nombre_completo,
        proyecto.nombre_proyecto, empresa.nombre_empresa,
        string_agg(DISTINCT carrera.nom_carrera, '<br> <br>') AS carreras,
        string_agg(DISTINCT profesor.nom_profesor || ' ' || profesor.ape1_profesor || ' ' || profesor.ape2_profesor, ', ') AS nombre_profesor,
        string_agg(DISTINCT asesor_x_proyecto.nom_asesor_externo || ' ' || asesor_x_proyecto.ape1_asesor_externo || ' ' || asesor_x_proyecto.ape2_asesor_externo, ', ') AS nombre_asesor_externo
        FROM proyecto_x_alumno
        INNER JOIN alumno ON proyecto_x_alumno.id_alumno = alumno.no_control
        INNER JOIN proyecto ON proyecto_x_alumno.id_proyecto = proyecto.id_proyecto
        INNER JOIN carrera_x_proyecto ON proyecto.id_proyecto = carrera_x_proyecto.id_proyecto
        INNER JOIN carrera ON carrera_x_proyecto.id_carrera = carrera.id_carrera
        INNER JOIN asesor_x_proyecto ON proyecto_x_alumno.id_proyecto = asesor_x_proyecto.id_proyecto
        INNER JOIN empresa ON proyecto.fk_id_empresa = empresa.id_empresa
        INNER JOIN profesor ON asesor_x_proyecto.id_asesor_interno = profesor.id_profesor
        WHERE proyecto_x_alumno.id_p_x_a = :id_p_x_a
        GROUP BY proyecto_x_alumno.id_p_x_a, proyecto_x_alumno.id_proyecto, proyecto_x_alumno.id_alumno, proyecto.nombre_proyecto, empresa.nombre_empresa, carrera.nom_carrera, profesor.nom_profesor, profesor.ape1_profesor, profesor.ape2_profesor, asesor_x_proyecto.nom_asesor_externo,
        asesor_x_proyecto.ape1_asesor_externo, asesor_x_proyecto.ape2_asesor_externo";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_p_x_a', $id_p_x_a);
$stmt->execute();

// Check if the query returned any rows
if ($stmt->rowCount() == 0) {
    echo "No data found.";
    // Redirect to another page
    header("Location: Convenios.php");
    exit();
}

// Set up the data for TBS to merge into the template
$data = array();
$count = 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
/*
    // Update the data in the database
    $stmt2 = $conn->prepare("SELECT update_dictamen(:id_p_x_a)");
    $stmt2->bindParam(':id_p_x_a', $row['id_p_x_a']);
    $stmt2->execute();
*/
}

setcookie('path', '../pdf/templates/Carta_Convenio.docx', time() + 60, '/');

$serialized_data = json_encode($data);

setcookie('data', $serialized_data, time() + 60, '/');

setcookie('conv', $id_p_x_a, time() + 60, '/');

// Close the database connection
$conn = null;

// Redirect to download.php to download the word
header("Location: ../../../../../func/download.php");
exit; // Make sure to exit after redirecting

?>