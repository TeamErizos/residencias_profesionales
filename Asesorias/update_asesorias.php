<?php
include("../conectAWS.php");

$ID_Asesoria = $_POST["ID_Asesorias"];
$Estado_Asesoria = $_POST['Estado_Asesorias'];
$Tipo_Asesoria = $_POST['Tipo_Asesorias'];
$Lugar_Asesoria = $_POST['Lugar_Asesorias'];
$Temas_Asesoria = $_POST['Temas_Asesorias'];
$Fecha_Asesoria = $_POST['Fecha_Asesorias'];
$Solucion_Asesoria = $_POST['Solucion_Asesorias'];
$FK_ID_P_X_A = $_POST['FK_ID_P_X_A'];
$Num_Asesoria = $_POST['Num_Asesoria'];

$sql_update = "UPDATE asesoria SET estado_asesoria = :estado, tipo_asesoria = :tipo, lugar_asesoria = :lugar, temas_asesoria = :temas, fecha_asesoria = :fecha, solucion_asesoria = :solucion, fk_id_p_x_a = :fk_id_p_x_a, num_asesoria = :num_asesoria WHERE id_asesoria = :id";
$query_update = $conn->prepare($sql_update);
$query_update->bindParam(':estado', $Estado_Asesoria);
$query_update->bindParam(':tipo', $Tipo_Asesoria);
$query_update->bindParam(':lugar', $Lugar_Asesoria);
$query_update->bindParam(':temas', $Temas_Asesoria);
$query_update->bindParam(':fecha', $Fecha_Asesoria);
$query_update->bindParam(':solucion', $Solucion_Asesoria);
$query_update->bindParam(':fk_id_p_x_a', $FK_ID_P_X_A);
$query_update->bindParam(':num_asesoria', $Num_Asesoria);
$query_update->bindParam(':id', $ID_Asesoria);

if ($query_update->execute()) {
    $no_control = $_POST['no_control'] ?? '';
    $redirectUrl = "asesorias_mastros_selecion.php?no_control=$no_control";
    redirectTo($redirectUrl);
} else {
    displayError($query_update->errorInfo()[2]);
}

function redirectTo($url) {
    echo "<script>window.location.href='$url';</script>";
    exit();
}

function displayError($errorMessage) {
    echo "Error: $errorMessage";
}
?>
