<?php
 include ("../view/header.php");
 require "../../../login/conexion/conectAWS.php";

// Obtener todas las carreras disponibles en la base de datos
$sql_carreras = "SELECT * FROM carrera";
$query_carreras = $conn->query($sql_carreras);
$carreras = $query_carreras->fetchAll(PDO::FETCH_ASSOC);
?>

    <h1>Tabla de Seguimiento de Proyectos</h1>

    <!-- Tabla de Proyectos -->
    <div class="Tabla de Proyectos">
    <?php
$sql = "SELECT proyecto_x_alumno.id_proyecto, proyecto.nombre_proyecto,
        string_agg(DISTINCT carrera.nom_carrera, '<br> <br>') AS carreras,
        string_agg(DISTINCT alumno.nombre_alumno || ' ' || alumno.ape1_alumno || ' ' || alumno.ape2_alumno, '<br> <br>') AS nombre_alumno,
        string_agg(DISTINCT profesor.nom_profesor || ' ' || profesor.ape1_profesor || ' ' || profesor.ape2_profesor, ', ') AS nombre_profesor,
        string_agg(DISTINCT asesor_x_proyecto.nom_asesor_externo || ' ' || asesor_x_proyecto.ape1_asesor_externo || ' ' || asesor_x_proyecto.ape2_asesor_externo, ', ') AS nombre_asesor_externo,
        empresa.nombre_empresa
        FROM proyecto_x_alumno
        INNER JOIN proyecto ON proyecto_x_alumno.id_proyecto = proyecto.id_proyecto
        INNER JOIN carrera_x_proyecto ON proyecto.id_proyecto = carrera_x_proyecto.id_proyecto
        INNER JOIN carrera ON carrera_x_proyecto.id_carrera = carrera.id_carrera
        INNER JOIN asesor_x_proyecto ON proyecto_x_alumno.id_proyecto = asesor_x_proyecto.id_proyecto
        INNER JOIN empresa ON proyecto.fk_id_empresa = empresa.id_empresa
        INNER JOIN alumno ON proyecto_x_alumno.id_alumno = alumno.no_control
        INNER JOIN profesor ON asesor_x_proyecto.id_asesor_interno = profesor.id_profesor
        GROUP BY proyecto_x_alumno.id_proyecto, proyecto.nombre_proyecto, empresa.nombre_empresa,
        profesor.nom_profesor, profesor.ape1_profesor, profesor.ape2_profesor, asesor_x_proyecto.nom_asesor_externo,
        asesor_x_proyecto.ape1_asesor_externo, asesor_x_proyecto.ape2_asesor_externo
        ORDER BY proyecto_x_alumno.id_proyecto";

$query = $conn->query($sql);
?>



        <!-- Display the filtered results in a table -->
        <table border="1">
            <thead>
                <tr>
                    <th>ID Proyecto</th>
                    <th>Nombre del Proyecto</th>
                    <th>Carreras</th>
                    <th>Residentes</th>
                    <th>Asesor Interno</th>
                    <th>Asesor Externo</th>
                    <th>Nombre de la Empresa</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr align="center">
                        <td><?= $row['id_proyecto'] ?></td>
                        <td><?= $row['nombre_proyecto'] ?></td>
                        <td><?= $row['carreras'] ?></td>
                        <td><?= $row['nombre_alumno'] ?></td>
                        <td><?= $row['nombre_profesor'] ?></td>
                        <td><?= $row['nombre_asesor_externo'] ?></td>
                        <td><?= $row['nombre_empresa'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
<?php include ("../view/footer.php"); ?>
