<?php 
    include("ConexionBD.php");
    $con=connection();

    $IDProyecto=$_GET['IDProyecto'];

    $sql="SELECT * FROM Proyectos WHERE IDProyecto = '$IDProyecto'";

    $query=mysqli_query($con, $sql);

    $row=mysqli_fetch_array($query);
?>

<?php
$sql="SELECT * FROM Proyectos WHERE IDProyecto = '$IDProyecto'";

$query = mysqli_query($con, $sql);
?>

<html>
    <head>

        <!--Titulo de la ventana-->
        <title>Vista - Proyectos</title>

    </head>
    <body>
        <!--Apertura de Clase - Tabla de Proyectos-->
    <div class="Tabla de Proyectos">
        <h2>Vista General del Proyecto</h2>
        <!--Tabla para mostrar los campos de la base de datos a la que fue llamada (Query Line 6)-->
        <table border="1">
            <thead>
                <tr>
                    <th>IDProyecto</th>
                    <th>NombreProyecto</th>
                    <th>TipoProyecto</th>
                    <th>OpcionProyecto</th>
                    <th>PeriodoInicio</th>
                    <th>PeriodoFinal</th>
                    <th>NombreAsesorInterno</th>
                    <th>NumResidentes</th>
                </tr>
            </thead>
            <tbody>
                <!--Inicio de ciclo While para que mientras haya una fila en la tabla, se muestre los botones y la informacion-->
                <?php while ($row = mysqli_fetch_array($query)) : ?>
                    <tr>
                        <th><?= $row['IDProyecto'] ?></th>
                        <th><?= $row['NombreProyecto'] ?></th>
                        <th><?= $row['TipoProyecto'] ?></th>
                        <th><?= $row['OpcionProyecto'] ?></th>
                        <th><?= $row['PeriodoInicio'] ?></th>
                        <th><?= $row['PeriodoFinal'] ?></th>
                        <th><?= $row['NombreAsesorInterno'] ?></th>
                        <th><?= $row['NumResidentes'] ?></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <a href="FormProyectos.php"> Regresar al Formulario de Proyectos</a>
    </div>
    </body>
</html>