<?php
include("../conectAWS.php");

$Estado_Asesorias = 'Pendiente';
$Tipo_Asesorias = $_POST['Tipo_Asesorias'] ?? '';
$Lugar_Asesoria = $_POST['Lugar_Asesoria'] ?? '';
$Temas_Asesoria = $_POST['Temas_Asesoria'] ?? '';
$Fecha_Asesoria = $_POST['Fecha_Asesoria'] ?? '';
$Numero_Asesoria = $_POST['Numero_Asesoria'] ?? '';

// Obtener el valor de id_p_x_a basado en el no_control
$no_control = $_POST['no_control'] ?? '';
$sql_id_p_x_a = "SELECT id_p_x_a FROM proyecto_x_alumno WHERE id_alumno = '$no_control'";
$result_id_p_x_a = $conn->query($sql_id_p_x_a);
$row_id_p_x_a = $result_id_p_x_a->fetch(PDO::FETCH_ASSOC);
$id_p_x_a = $row_id_p_x_a['id_p_x_a'];

// Llamar a la función para insertar la asesoría
$sql_function = "SELECT insertar_asesoria(:estado, :tipo, :lugar, :temas, :fecha, :id_p_x_a, :num_asesoria)";
$query_function = $conn->prepare($sql_function);
$query_function->bindParam(':estado', $Estado_Asesorias);
$query_function->bindParam(':tipo', $Tipo_Asesorias);
$query_function->bindParam(':lugar', $Lugar_Asesoria);
$query_function->bindParam(':temas', $Temas_Asesoria);
$query_function->bindParam(':fecha', $Fecha_Asesoria);
$query_function->bindParam(':id_p_x_a', $id_p_x_a);
$query_function->bindParam(':num_asesoria', $Numero_Asesoria);

if ($query_function->execute()) {
    $no_control = $_POST['no_control'] ?? '';
    $redirectUrl = "asesorias_mastros_selecion.php?no_control=$no_control";
    redirectTo($redirectUrl);
} else {
    displayError($query_function->errorInfo()[2]);
}

function redirectTo($url) {
    echo "<script>window.location.href='$url';</script>";
    exit();
}

function displayError($errorMessage) {
    echo "Error: $errorMessage";
}
?>

