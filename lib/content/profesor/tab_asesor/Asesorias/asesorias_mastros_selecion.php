<?php
include("../../../../login/conexion/conectAWS.php");
include("../../view/header.php");

$no_control = $_GET['no_control']; // Obtener el número de control desde el parámetro de la URL

$sql_asesorias = "SELECT asesoria.id_asesoria, asesoria.estado_asesoria, asesoria.tipo_asesoria, asesoria.lugar_asesoria, asesoria.temas_asesoria, asesoria.fecha_asesoria, asesoria.solucion_asesoria, asesoria.num_asesoria
FROM asesoria
INNER JOIN proyecto_x_alumno ON asesoria.fk_id_p_x_a = proyecto_x_alumno.id_p_x_a
INNER JOIN alumno ON proyecto_x_alumno.id_alumno = alumno.no_control
WHERE alumno.no_control = :no_control"; // Agregar la cláusula WHERE para filtrar por el número de control
$query_asesorias = $conn->prepare($sql_asesorias);
$query_asesorias->bindParam(':no_control', $no_control);
$query_asesorias->execute();
$asesorias = $query_asesorias->fetchAll(PDO::FETCH_ASSOC);

?>
<link rel="stylesheet" type="text/css" href="/residencias_profesionales/lib/content/profesor/view/EstiloFormato.css">

<html>

<head>
    <title>Asesorias</title>
</head>

<body>

    <h4 class="tableTitle">Asesorias Registradas</h2>
        <div class="button-containerLeft">
            <div class="button-containerForm"
                onclick="window.location.href='asesoria_insert.php?no_control=<?= $no_control ?>'">
                <button class="buttonLarge">
                    <a class="seleccionar">Agregar Asesoría</a>
                </button>
            </div>

        </div>

        <div class="tableContainer">

            <table>
                <thead>
                    <tr>
                        <th>ID de Asesoria</th>
                        <th>Estado de la Asesoria</th>
                        <th>Tipo de la Asesoria</th>
                        <th>Localizacion de la Asesoria</th>
                        <th>Temas a Tratar</th>
                        <th>Fecha de la Asesoria</th>
                        <th>Número de Asesoria</th>
                        <th>Solucion de la Asesoria</th>
                        <th></th>
                        <th>Acciones</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asesorias as $row): ?>
                        <tr>
                            <td>
                                <?= $row['id_asesoria'] ?>
                            </td>
                            <td>
                                <?= $row['estado_asesoria'] ?>
                            </td>
                            <td>
                                <?= $row['tipo_asesoria'] ?>
                            </td>
                            <td>
                                <?= $row['lugar_asesoria'] ?>
                            </td>
                            <td>
                                <?= $row['temas_asesoria'] ?>
                            </td>
                            <td>
                                <?= $row['fecha_asesoria'] ?>
                            </td>
                            <td>
                                <?= $row['num_asesoria'] ?>
                            </td>
                            <td>
                                <?= $row['solucion_asesoria'] ?>
                            </td>
                            <?php if ($row['estado_asesoria'] == "Realizada"): ?>
                                <td></td>
                                <td></td>
                                <td></td>
                            <?php endif; ?>

                            <?php if ($row['estado_asesoria'] != "Realizada"): ?>

                                <td>
                                    <div class="button-containerForm">
                                        <button class="button">
                                            <a class="seleccionar"
                                                href='asesoria_maestros_modificacion.php?no_control=<?= $no_control ?>&ID_Asesorias=<?= $row['id_asesoria'] ?>'>Modificar</a>
                                        </button>
                                    </div>
                                </td>

                                <td>
                                    <div class="button-container-green">
                                        <button class="button">
                                            <a class="seleccionarBlack"
                                                href="asesoria_maestros_final.php?ID_Asesoria=<?= $row['id_asesoria'] ?>&no_control=<?= $no_control ?>"
                                                class="Asesorias--Update">Solucionar</a>
                                        </button>
                                    </div>
                                </td>

                                <td>
                                    <div class="button-container-red">
                                        <button class="button">
                                            <a class="seleccionar"
                                                href="delete_asesoria.php?id_asesoria=<?= $row['id_asesoria'] ?>&no_control=<?= $no_control ?>"
                                                class="Tabla de Asesorias--Delete">Eliminar</a>
                                        </button>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="button-containerLeft">
            <div class="button-containerForm"
                onclick="window.location.href='asesorias_main.php?no_control=<?= $no_control ?>'">
                <button class="button">
                    <a class="seleccionar">Atrás</a>
                </button>
            </div>

        </div>

        <?php include("../../view/footer.php"); ?>