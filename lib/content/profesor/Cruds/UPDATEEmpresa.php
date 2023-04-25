<?php 
    include("ConexionBD.php");
    $con=connection();

    $IDEmpresa=$_GET['IDEmpresa'];

    $sql="SELECT * FROM Empresa WHERE IDEmpresa = '$IDEmpresa'";

    $query=mysqli_query($con, $sql);

    $row=mysqli_fetch_array($query);
?>

<?php
$sql = "SELECT * FROM Empresa";
$query = mysqli_query($con, $sql);
?>

<html>
    <head>

        <!--Titulo de la ventana-->
        <title>Edicion - Empresa</title>

    </head>
    <body>
        <div class="Formulario_Empresa">
        <h1>Centro de Edicion de Filas</h1>
            <form action="EditarEmpresa.php" method="POST">
                <!--Campo ID del Proyecto-->
                <b> ID de la Empresa: </b> <input type="text" name="IDEmpresa" placeholder="ID de la Empresa" value="<?= $row['IDEmpresa']?>">
                <br>
                <br>
                <!--Campo Nombre del la Empresa-->
                <b> Nombre del la Empresa: </b> <input type="text" name="NombreEmpresa" placeholder="Nombre del la Empresa" value="<?= $row['NombreEmpresa']?>">
                <br>
                <br>
                <!--Campo Ramo-->
                <b> Ramo (Industrial - De Servicios - Otro): </b> <input type="text" name="Ramo" placeholder="Ramo" value="<?= $row['Ramo']?>">
                <br>
                <br>
                <!--Campo Sector-->
                <b> Sector (Publico - Privado): </b> <input type="text" name="Sector" placeholder="Sector" value="<?= $row['Sector']?>">
                <br>
                <br>
                <!--Campo Actividad Principal-->
                <b> Actividad Principal: </b> <input type="text" name="ActividadPrincipal" placeholder="Actividad Principal" value="<?= $row['ActividadPrincipal']?>">
                <br>
                <br>
                <!--Campo Domicilio-->
                <b> Domicilio: </b> <input type="text" name="Domicilio" placeholder="Domicilio" value="<?= $row['Domicilio']?>">
                <br>
                <br>
                <!--Campo Colonia-->
                <b> Colonia: </b> <input type="text" name="Colonia" placeholder="Colonia" value="<?= $row['Colonia']?>">
                <br>
                <br>
                <!--Campo Ciudad-->
                <b> Ciudad: </b> <input type="text" name="Ciudad" placeholder="Ciudad" value="<?= $row['Ciudad']?>">
                <br>
                <br>
                <!--Campo RFC-->
                <b> RFC: </b> <input type="text" name="RFC" placeholder="RFC" value="<?= $row['RFC']?>">
                <br>
                <br>
                <!--Campo Nombre del Representante-->
                <b> Nombre del Representante: </b> <input type="text" name="NombreRepresentante" placeholder="Nombre del Representante" value="<?= $row['NombreRepresentante']?>">
                <br>
                <br>
                <!--Campo Puesto-->
                <b> Puesto: </b> <input type="text" name="Puesto" placeholder="Puesto" value="<?= $row['Puesto']?>">
                <br>
                <br>
                <!--Boton para Actualizar fila de la Base de Datos-->
                <input type="submit" value="Actualizar">
            </form>
        </div>
        <br>
        <a href="FormEmpresa.php"> Regresar al Formulario de Empresa</a>
    </body>
</html>