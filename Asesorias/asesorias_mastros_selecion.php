<?php
include("../conectAWS.php");

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

<html>
<head>
    <title>Asesorias</title>
</head>
<body>
    <div class="Asesorias">
        <h2>Asesorias Registradas</h2>
        <a href='asesoria_insert.php?no_control=<?= $no_control ?>'>Agregar Asesoria</a>
        <table border="1">
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asesorias as $row): ?>
                    <tr>
                        <td><?= $row['id_asesoria'] ?></td>
                        <td><?= $row['estado_asesoria'] ?></td>
                        <td><?= $row['tipo_asesoria'] ?></td>
                        <td><?= $row['lugar_asesoria'] ?></td>
                        <td><?= $row['temas_asesoria'] ?></td>
                        <td><?= $row['fecha_asesoria'] ?></td>
                        <td><?= $row['num_asesoria'] ?></td>
                        <td><?= $row['solucion_asesoria'] ?></td>
                        
                        <?php if ($row['estado_asesoria'] != "Realizada"): ?>
                            <td><a href='asesoria_maestros_modificacion.php?no_control=<?= $no_control ?>&ID_Asesorias=<?= $row['id_asesoria'] ?>'>Modificar</a></td>
                            <td><a href="asesoria_maestros_final.php?ID_Asesoria=<?= $row['id_asesoria'] ?>&no_control=<?= $no_control ?>" class="Asesorias--Update">Solucionar</a></td>
                            <td><a href="delete_asesoria.php?id_asesoria=<?= $row['id_asesoria'] ?>&no_control=<?= $no_control ?>" class="Tabla de Asesorias--Delete">Eliminar</a></td>
                        <?php endif; ?>   
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="asesorias_main.php?no_control=<?= $no_control ?>">Atrás</a>
</body>
</html>
