<!--Incluir conexion a la Base de Datos y Query para mostrar los datos de la tabla-->
<?php
include("../view/header.php");
include("../../../../login/conexion/conectAWS.php");

$sql = "SELECT * FROM proyecto_x_alumno";
$query = $conn->query($sql);
$results = $query->fetchAll(PDO::FETCH_ASSOC);
?>

    <!--Apertura de Clase - Tabla de Alumnos-->
    <div class="Tabla de Proyectos">
        <h2>Alumnos en Proyectos</h2>
        <!--Tabla para mostrar los campos de la base de datos a la que fue llamada (Query Line 6)-->
        <table border="1">
            <thead>
                <tr>
                    <th>ID Alumno</th>
                    <th>Nombre Completo del Alumno</th>
                    <th>Nombre del Proyecto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!--Inicio de ciclo While para que mientras haya una fila en la tabla, se muestre los botones y la informacion-->
                <?php
                $sql = "SELECT proyecto_x_alumno.*, string_agg(alumno.nombre_alumno || ' ' || alumno.ape1_alumno || ' ' || alumno.ape2_alumno, ' ') AS nombre_completo, proyecto.nombre_proyecto
                FROM proyecto_x_alumno
                INNER JOIN alumno ON proyecto_x_alumno.id_alumno = alumno.no_control
                INNER JOIN proyecto ON proyecto_x_alumno.id_proyecto = proyecto.id_proyecto
                GROUP BY proyecto_x_alumno.id_p_x_a, proyecto_x_alumno.id_proyecto, proyecto_x_alumno.id_alumno, proyecto.nombre_proyecto";
                $query = $conn->query($sql);
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) :
                ?>
                    <tr>
                        <th><?= $row['id_alumno'] ?></th>
                        <th><?= $row['nombre_completo'] ?></th>
                        <th><?= $row['nombre_proyecto'] ?></th>
                        <th><a href="Convenios2.php?id=<?= $row['id_p_x_a'] ?>">Generar Convenio (.pdf)</a></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <a href="MenuPrincipal.php"> Regresar al Menu Principal</a>
    </div>

<?php include("../view/footer.php");