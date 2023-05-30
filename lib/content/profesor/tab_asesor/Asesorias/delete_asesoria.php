<?php
include("../../../../login/conexion/conectAWS.php");

$id_asesoria = $_GET['id_asesoria'];

$sql_delete = "DELETE FROM asesoria WHERE id_asesoria = :id_asesoria";
$query_delete = $conn->prepare($sql_delete);
$query_delete->bindParam(':id_asesoria', $id_asesoria);

if ($query_delete->execute()) {
    $no_control = $_GET['no_control'] ?? '';
    $redirectUrl = "asesorias_mastros_selecion.php?no_control=$no_control";
    redirectTo($redirectUrl);
} else {
    displayError($query_delete->errorInfo()[2]);
}

function redirectTo($url) {
    echo "<script>window.location.href='$url';</script>";
    exit();
}

function displayError($errorMessage) {
    echo "Error: $errorMessage";
}
?>
