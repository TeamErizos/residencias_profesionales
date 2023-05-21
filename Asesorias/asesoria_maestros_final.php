<?php
include("../conectAWS.php");

$ID_Asesoria = $_GET['ID_Asesoria'];
$no_control = $_GET['no_control'];

$sql = "SELECT * FROM asesoria WHERE id_asesoria = :ID_Asesoria";
$query = $conn->prepare($sql);
$query->bindParam(':ID_Asesoria', $ID_Asesoria);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
?>

<html>
<head>
    <title>Terminar la Asesoría</title>
</head>
<body>
    <div class="Formulario_Proyectos">
        <form action="update_asesorias2.php" method="POST">
            <input type="hidden" name="ID_Asesoria" value="<?= $ID_Asesoria ?>">
            <input type="hidden" name="no_control" value="<?= $no_control ?>">
            <input type="hidden" name="Estado_Asesoria" value="Realizada">
            <input type="hidden" name="Tipo_Asesoria" value="<?= $row['tipo_asesoria'] ?? '' ?>">
            <input type="hidden" name="Lugar_Asesoria" value="<?= $row['lugar_asesoria'] ?? '' ?>">
            <input type="hidden" name="Temas_Asesoria" value="<?= $row['temas_asesoria'] ?? '' ?>">
            <input type="hidden" name="Fecha_Asesoria" value="<?= $row['fecha_asesoria'] ?? '' ?>">
            <input type="hidden" name="FK_ID_P_X_A" value="<?= $row['fk_id_p_x_a'] ?? '' ?>">
            <input type="hidden" name="Num_Asesoria" value="<?= $row['num_asesoria'] ?? '' ?>">
            <a href='asesorias_mastros_selecion.php?no_control=<?= $_GET["no_control"] ?>'>Atrás</a>
            <p><h3>Escriba la solución de la Asesoría</h3></p>
            <textarea cols="40" rows="5" wrap="physical" name="Solucion_Asesoria" id="Solucion_Asesoria"></textarea><br />
            <p><input type="submit" value="Actualizar"></p>
        </form>
    </div>
</body>
</html>

