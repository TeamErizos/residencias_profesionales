<?php

include("../view/header.php");
    // Establish a connection to the PostgreSQL database
    require "../../../../login/conexion/conectAWS.php";

    $query = "
        SELECT
        pa.id_p_x_a,
        CONCAT(al.nombre_alumno, ' ', al.ape1_alumno, ' ', al.ape2_alumno) AS nombreEstudiante,
        al.no_control,
        al.seguro_medico_alumno,
        al.num_seguridad_social_alumno,
        ca.nom_carrera,
        pro.nombre_proyecto,
        e.nombre_empresa,
        CONCAT(e.nombre_del_titular_de_empresa, ' ', e.ape1_del_titular_de_empresa, ' ', e.ape2_del_titular_de_empresa) AS nombreTitularEmpresa,
        e.puesto_del_titular_de_empresa
        FROM proyecto_x_alumno pa
        JOIN proyecto pro ON pro.id_proyecto = pa.id_proyecto
        JOIN empresa e ON e.id_empresa = pro.fk_id_empresa
        JOIN alumno al ON al.no_control = pa.id_alumno
        JOIN carrera ca ON ca.id_carrera = al.fk_id_carrera
        WHERE pa.carta = FALSE
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
<link rel="stylesheet" type="text/css" href="/residencias_profesionales/lib/content/profesor/view/EstiloFormato.css">

<!-- Add a button to save the document -->
x
<!-- Inicio ContainerForm -->
<div class="tableContainer">

<!-- Inicio Body -->
<body>
    <!-- Añadir estilo individual -->
    <link rel="stylesheet" type="text/css" href="/residencias_profesionales/lib/content/jefe_dep/dep_vinculacion/view/cssCartaPresentacion.css">

<h2 >Información carta de presentación</h2>
<br>
    <table>
    <thead>
                <tr>
            <th>Nombre Estudiante</th>
            <th>No. Control</th>
            <th>Seguro Médico</th>
            <th>No. Seguridad Social</th>
            <th>Carrera</th>
            <th>Proyecto</th>
            <th>Empresa</th>
            <th>Titular Empresa</th>
            <th>Puesto</th>
            <th>Descargar Carta</th>
            </tr>
            </thead>
            
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?php echo $row['nombreestudiante']; ?></td>
            <td><?php echo $row['no_control']; ?></td>
            <td><?php echo $row['seguro_medico_alumno']; ?></td>
            <td><?php echo $row['num_seguridad_social_alumno']; ?></td>
            <td><?php echo $row['nom_carrera']; ?></td>
            <td><?php echo $row['nombre_proyecto']; ?></td>
            <td><?php echo $row['nombre_empresa']; ?></td>
            <td><?php echo $row['nombretitularempresa']; ?></td>
            <td><?php echo $row['puesto_del_titular_de_empresa']; ?></td>
            <td>
                <form action="carta_presentacion2.php" method="post">
                    <input type="hidden" name="id_p_x_a" value="<?php echo $row['id_p_x_a']; ?>">
                    <input type="text" id="numOficio" name="numOficio" placeholder="Ingrese Numero de Oficio" required>
                    <button class="enviar" type="submit">Descargar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>



    <!-- FinBody -->
</body>
    <!-- Fin ContainerForm -->
        </div >
        
<?php include("../view/footer.php"); ?>