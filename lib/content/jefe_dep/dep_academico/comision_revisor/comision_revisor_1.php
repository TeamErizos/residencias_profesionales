<?php

include("../view/header.php");    

    // Establish a connection to the PostgreSQL database
    require "../../../../login/conexion/conectAWS.php";

    $query = "
        SELECT
        pa.id_p_x_a,
        CONCAT(al.nombre_alumno, ' ', al.ape1_alumno, ' ', al.ape2_alumno) AS nombreEstudiante,
        al.no_control,
        ca.nom_carrera,
        pro.nombre_proyecto
        FROM proyecto_x_alumno pa
        JOIN proyecto pro ON pro.id_proyecto = pa.id_proyecto
        JOIN alumno al ON al.no_control = pa.id_alumno
        JOIN carrera ca ON ca.id_carrera = al.fk_id_carrera
        WHERE pa.id_revisador IS NULL
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Set up the data for TBS to merge into the template
    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    $conn = null;
?>

    <table>
        <tr>
            <th>Nombre Estudiante</th>
            <th>No. Control</th>
            <th>Carrera</th>
            <th>Proyecto</th>
        </tr>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?php echo $row['nombreestudiante']; ?></td>
            <td><?php echo $row['no_control']; ?></td>
            <td><?php echo $row['nom_carrera']; ?></td>
            <td><?php echo $row['nombre_proyecto']; ?></td>
            <td>
                <form action="comision_revisor_2.php" method="post">
                    <input type="hidden" name="id_p_x_a" value="<?php echo $row['id_p_x_a']; ?>">
                    <button type="submit">Asignar Revisor</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

<?php include("../view/footer.php");