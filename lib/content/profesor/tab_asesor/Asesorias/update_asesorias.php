<?php
include("../../../../login/conexion/conectAWS.php");

$ID_Asesoria = $_POST["ID_Asesorias"];
$no_control = $_POST["no_control"];
$Estado_Asesoria = $_POST['Estado_Asesorias'];
$Tipo_Asesoria = $_POST['Tipo_Asesorias'];
$Lugar_Asesoria = $_POST['Lugar_Asesorias'];
$Temas_Asesoria = $_POST['Temas_Asesorias'];
$Fecha_Asesoria = $_POST['Fecha_Asesorias'];
$Solucion_Asesoria = $_POST['Solucion_Asesorias'];
$FK_ID_P_X_A = $_POST['FK_ID_P_X_A'];
$Num_Asesoria = $_POST['Num_Asesoria'];

$sql_update = "UPDATE asesoria SET estado_asesoria = :Estado_Asesoria, tipo_asesoria = :Tipo_Asesoria, lugar_asesoria = :Lugar_Asesoria, temas_asesoria = :Temas_Asesoria, fecha_asesoria = :Fecha_Asesoria, solucion_asesoria = :Solucion_Asesoria, fk_id_p_x_a = :FK_ID_P_X_A, num_asesoria = :Num_Asesoria WHERE id_asesoria = :ID_Asesoria";
$query_update = $conn->prepare($sql_update);
$query_update->bindParam(':Estado_Asesoria', $Estado_Asesoria);
$query_update->bindParam(':Tipo_Asesoria', $Tipo_Asesoria);
$query_update->bindParam(':Lugar_Asesoria', $Lugar_Asesoria);
$query_update->bindParam(':Temas_Asesoria', $Temas_Asesoria);
$query_update->bindParam(':Fecha_Asesoria', $Fecha_Asesoria);
$query_update->bindParam(':Solucion_Asesoria', $Solucion_Asesoria, PDO::PARAM_STR); // Especificar el tipo de dato como cadena
$query_update->bindParam(':FK_ID_P_X_A', $FK_ID_P_X_A);
$query_update->bindParam(':Num_Asesoria', $Num_Asesoria);
$query_update->bindParam(':ID_Asesoria', $ID_Asesoria);

if ($query_update->execute()) {
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
