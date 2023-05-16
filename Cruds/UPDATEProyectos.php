<?php 
    include("ConexionBD.php");
    $con=connection();

    $IDProyecto=$_GET['IDProyecto'];

    $sql="SELECT * FROM Proyectos WHERE IDProyecto = '$IDProyecto'";

    $query=mysqli_query($con, $sql);

    $row=mysqli_fetch_array($query);
?>

<?php
$sql = "SELECT * FROM Proyectos";
$query = mysqli_query($con, $sql);
?>

<html>
    <head>

        <!--Titulo de la ventana-->
        <title>Edicion - Proyectos</title>

    </head>
    <body>
        <div class="Formulario_Proyectos">
        <h1>Centro de Edicion de Filas</h1>
            <form action="EditarProyectos.php" method="POST">
                <!--Campo ID del Proyecto-->
                <b> ID del Proyecto: </b> <input type="text" name="IDProyecto" placeholder="ID del Proyecto" value="<?= $row['IDProyecto']?>">
                <br>
                <br>
                <!--Campo Nombre del Proyecto-->
                <b> Nombre del Proyecto: </b> <input type="text" name="NombreProyecto" placeholder="Nombre del Proyecto" value="<?= $row['NombreProyecto']?>">
                <br>
                <br>
                <!--Campo Tipo de Proyecto-->
                <b> Tipo de Proyecto (Interno - Externo - Dual): </b> <input type="text" name="TipoProyecto" placeholder="Tipo de Proyecto" value="<?= $row['TipoProyecto']?>">
                <br>
                <br>
                <!--Campo Opcion del Proyecto-->
                <b> Opcion de Proyecto (Propuesta Propia - Trabajador - Banco de Proyectos): </b> <input type="text" name="OpcionProyecto" placeholder="Opcion del Proyecto" value="<?= $row['OpcionProyecto']?>">
                <br>
                <br>
                <!--Campo Periodo Inicial-->
                <b> Periodo Inicial (dd-mm-aaaa): </b> <input type="text" name="PeriodoInicio" placeholder="Periodo Inicial" value="<?= $row['PeriodoInicio']?>">
                <br>
                <br>
                <!--Campo Periodo Final-->
                <b> Periodo Final (dd-mm-aaaa): </b> <input type="text" name="PeriodoFinal" placeholder="Periodo Final" value="<?= $row['PeriodoFinal']?>">
                <br>
                <br>
                <!--Campo Nombre del Asesor Interno-->
                <b> Nombre del Asesor Interno: </b> <input type="text" name="NombreAsesorInterno" placeholder="Nombre del Asesor Interno" value="<?= $row['NombreAsesorInterno']?>">
                <br>
                <br>
                <!--Campo Numero de Residentes-->
                <b> Numero de Residentes en el Proyecto: </b> <input type="text" name="NumResidentes" placeholder="Numero de Residentes" value="<?= $row['NumResidentes']?>">
                <br>
                <br>
                <!--Boton para Actualizar fila de la Base de Datos-->
                <input type="submit" value="Actualizar">
            </form>
        </div>
        <br>
        <a href="FormProyectos.php"> Regresar al Formulario de Proyectos</a>
    </body>
</html>