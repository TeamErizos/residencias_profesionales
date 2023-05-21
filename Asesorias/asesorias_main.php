<?php
include("../conectAWS.php");
$sql_asesorias = "SELECT alumno.no_control, CONCAT(alumno.nombre_alumno, ' ', alumno.ape1_alumno, ' ', alumno.ape2_alumno) AS nombre_completo, proyecto.nombre_proyecto, id_p_x_a
FROM alumno
INNER JOIN proyecto_x_alumno ON alumno.no_control = proyecto_x_alumno.id_alumno
INNER JOIN proyecto ON proyecto_x_alumno.id_proyecto = proyecto.id_proyecto";
$query_asesorias = $conn->query($sql_asesorias);
$asesorias = $query_asesorias->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
    <head>
        <title>Seleccionar Alumno Asesoria</title>
    </head>
    <body>
        <div class="Seleccionar_Alumno">
            <h2>Seleccionar Alumno para dar Asesoria</h2>
            
            <table border="1">
                <thead>
                    <tr>
                        <th>Numero de Control del Alumno</th>
                        <th>Nombre Completo del Alumno</th>
                        <th>Nombre del Proyecto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asesorias as $row): ?>
                        <tr>
                            <td><?= $row['no_control'] ?></td>
                            <td><?= $row['nombre_completo'] ?></td>
                            <td><?= $row['nombre_proyecto'] ?></td>
                            <td><a href="asesorias_mastros_selecion.php?no_control=<?= $row['no_control'] ?>" class="Asesorias">Selecionar</a></td>

                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>