<?php
include("../conectAWS.php");

$ID_Asesoria = $_POST["ID_Asesoria"];
$no_control = $_POST["no_control"];
$Estado_Asesoria = $_POST['Estado_Asesoria'];
$Tipo_Asesoria = $_POST['Tipo_Asesoria'];
$Lugar_Asesoria = $_POST['Lugar_Asesoria'];
$Temas_Asesoria = $_POST['Temas_Asesoria'];
$Fecha_Asesoria = $_POST['Fecha_Asesoria'];
$Solucion_Asesoria = $_POST['Solucion_Asesoria'];
$FK_ID_P_X_A = $_POST['FK_ID_P_X_A'];
$Num_Asesoria = $_POST['Num_Asesoria'];

$sql_update = "UPDATE asesoria SET estado_asesoria = :Estado_Asesoria, tipo_asesoria = :Tipo_Asesoria, lugar_asesoria = :Lugar_Asesoria, temas_asesoria = :Temas_Asesoria, fecha_asesoria = :Fecha_Asesoria, solucion_asesoria = :Solucion_Asesoria, fk_id_p_x_a = :FK_ID_P_X_A, num_asesoria = :Num_Asesoria WHERE id_asesoria = :ID_Asesoria";
$query_update = $conn->prepare($sql_update);
$query_update->bindParam(':Estado_Asesoria', $Estado_Asesoria);
$query_update->bindParam(':Tipo_Asesoria', $Tipo_Asesoria);
$query_update->bindParam(':Lugar_Asesoria', $Lugar_Asesoria);
$query_update->bindParam(':Temas_Asesoria', $Temas_Asesoria);
$query_update->bindParam(':Fecha_Asesoria', $Fecha_Asesoria);
$query_update->bindParam(':Solucion_Asesoria', $Solucion_Asesoria);
$query_update->bindParam(':FK_ID_P_X_A', $FK_ID_P_X_A);
$query_update->bindParam(':Num_Asesoria', $Num_Asesoria);
$query_update->bindParam(':ID_Asesoria', $ID_Asesoria);
$query_update->execute();

header("Location: asesorias_mastros_selecion.php?no_control=".$no_control);
exit();
?>