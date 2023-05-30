<?php
include("../../../../login/conexion/conectAWS.php");
include("../../view/header.php");

$ID_Asesorias = $_GET['ID_Asesorias'];
$no_control = $_GET['no_control'];

$sql = "SELECT * FROM asesoria WHERE id_asesoria = :id";
$query = $conn->prepare($sql);
$query->bindParam(':id', $ID_Asesorias);
$query->execute();

$row = $query->fetch(PDO::FETCH_ASSOC);
?>

    <div class="Formulario_Proyectos">
        <form method="post" action="update_asesorias.php">
            <input type="hidden" name="ID_Asesorias" value="<?= $row['id_asesoria'] ?>">
            <input type="hidden" name="Estado_Asesorias" value="<?= $row['estado_asesoria'] ?>">
            <input type="hidden" name="FK_ID_P_X_A" value="<?= $row['fk_id_p_x_a'] ?>">
            <input type="hidden" name="Solucion_Asesorias" value="<?= $row['solucion_asesoria'] ?>">
            </p>
            <p>Cambiar la Modalidad de la Asesoria
                <select name="Tipo_Asesorias" id="Tipo_Asesorias">
                    <?php if ($row['tipo_asesoria'] == 'Presencial') : ?>
                        <option value="Presencial" selected>Presencial</option>
                        <option value="Virtual">Virtual</option>
                    <?php elseif ($row['tipo_asesoria'] == 'Virtual') : ?>
                        <option value="Presencial">Presencial</option>
                        <option value="Virtual" selected>Virtual</option>
                    <?php endif; ?>
                </select>
            </p>
            <p>Cambiar el Lugar *Si cambió la modalidad a virtual favor de borrar el lugar de la asesoria*</p>
            <p><input type="text" name="Lugar_Asesorias" value="<?= $row['lugar_asesoria'] ?>"></p>
            <p>Cambiar los temas a tratar en la asesoria</p>
            <textarea cols="40" rows="5" wrap="physical" name="Temas_Asesorias" id="Temas_Asesorias"><?= $row['temas_asesoria'] ?></textarea><br />
            <p>Cambiar la fecha de la asesoria</p>
            <input type="date" name="Fecha_Asesorias" value="<?= $row['fecha_asesoria'] ?>">
            <p>Cambiar el numero de la asesoria</p>
            <input type="text" name="Num_Asesoria" value="<?= $row['num_asesoria'] ?>">
            <input type="hidden" name="no_control" value="<?= $no_control ?>">
            <p><input type="submit" value="Actualizar"></p>
        </form>
    </div>

<?php include("../../view/footer.php"); ?>
