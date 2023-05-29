<?php

 // Meter dashboard
 include "../view/header.php";
 require "../../../login/conexion/conectAWS.php";

// Obtener todas las carreras disponibles en la base de datos
$sql_carreras = "SELECT * FROM carrera";
$query_carreras = $conn->query($sql_carreras);
$carreras = $query_carreras->fetchAll(PDO::FETCH_ASSOC);
?>


    <div class="containerForm">
        <h2>Banco de Proyectos</h2>
    <!-- Filtro de Proyectos -->

</br>

    <h3>Filtro</h3>

</br>

    <div class="Filtro_Proyectos">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <b> Carrera: </b>
            <select class="styled-select" name="Carrera">
                <option value="">Todos</option>
                <?php foreach ($carreras as $carrera) { ?>
                    <option value="<?= $carrera['id_carrera'] ?>"><?= $carrera['nom_carrera'] ?></option>
                <?php } ?>
            </select>
            <div class="button-containerForm">
                <button type="submit" name="Filtrar" value="Filtrar">Filtrar</button>
            </div>
        </form>
    </div>

</br>
</div>

    <!-- Tabla de Proyectos -->
    <div class="tableContainer">
        
        <?php
        // Obtener los valores de los filtros seleccionados
        $carrera = isset($_POST['Carrera']) ? $_POST['Carrera'] : "";

        // Construir la consulta SQL con los filtros seleccionados
        $sql = "SELECT proyecto.*, empresa.*, profesor.*, 
               string_agg(carrera.nom_carrera, ' - ') AS carreras,
               (proyecto.num_residentes - (
                   SELECT COUNT(*)
                   FROM proyecto AS p2
                   INNER JOIN proyecto_x_alumno AS cxp2 ON p2.id_proyecto = cxp2.id_proyecto
                   WHERE p2.id_proyecto = proyecto.id_proyecto
               )) AS residentes_disponibles
        FROM proyecto
        INNER JOIN empresa ON proyecto.fk_id_empresa = empresa.id_empresa
        INNER JOIN profesor ON proyecto.fk_id_profesor = profesor.id_profesor
        INNER JOIN carrera_x_proyecto ON proyecto.id_proyecto = carrera_x_proyecto.id_proyecto
        INNER JOIN carrera ON carrera_x_proyecto.id_carrera = carrera.id_carrera";

        $where = array();
        if (!empty($carrera)) {
            $where[] = "carrera.id_carrera = '$carrera'";
        }

        // Append the WHERE conditions to the SQL query if any filters are selected
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " GROUP BY proyecto.id_proyecto, empresa.id_empresa, profesor.id_profesor
    HAVING COUNT(*) > 0";

        $query = $conn->query($sql);
        ?>

        <!-- Display the filtered results in a table -->
        <table>
            <thead>
                <tr>
                    <!--<th>ID del Proyecto</th>-->
                    <th>Nombre del Proyecto</th>
                    <th>Objetivo General</th>
                    <th>Lugar de Realizacion</th>
                    <th>Numero de Participantes</th>
                    <th>Espacios Disponibles</th>
                    <th>Carreras Requisitadas</th>
                    <th>Supervisor del Proyecto</th>
                    <th>Contacto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) :
                ?>
                    <tr align="center">
                        <!--<td><?= $row['id_proyecto'] ?></td>-->
                        <td><?= $row['nombre_proyecto'] ?></td>
                        <td><?= $row['objetivo_general'] ?></td>
                        <td><?= $row['nombre_empresa'] ?></td>
                        <td><?= $row['num_residentes'] ?></td>
                        <td><?= $row['residentes_disponibles'] ?></td>
                        <td><?= $row['carreras'] ?></td>
                        <td><?= $row['nom_profesor'] ?></td>
                        <td><?= $row['correo_profesor'] ?></td>
                        <td>
                            <?php if ($row['residentes_disponibles'] > 0) : ?>
                                <!-- Dato a enviar a la solicitud-->
                                <a href="solicitud_residencia.php?pro=<?= $row['nombre_proyecto'] ?>">
                                    <div class="button-containerForm">
                                    <button>Registrarse</button>
                                </div>
                                </a>
                            <?php else : ?>
                            <div class="button-containerFormDisabled">
                                <button disabled>Cupo lleno</button>
                            </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <script>
            function registrar(id_proyecto, residentes_disponibles) {
                if (residentes_disponibles > 0) {
                    var mensaje = "Se ingresó al proyecto correctamente";
                } else {
                    var mensaje = "Cupo lleno";
                }
                alert(mensaje);
            }
        </script>

    </div>



<?php include "../view/footer.php"; ?>
