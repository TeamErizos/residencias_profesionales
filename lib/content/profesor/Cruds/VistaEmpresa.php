<?php 
    include("ConexionBD.php");
    $con=connection();

    $IDEmpresa=$_GET['IDEmpresa'];

    $sql="SELECT * FROM Empresa WHERE IDEmpresa = '$IDEmpresa'";

    $query=mysqli_query($con, $sql);

    $row=mysqli_fetch_array($query);
?>

<?php
$sql="SELECT * FROM Empresa WHERE IDEmpresa = '$IDEmpresa'";

$query = mysqli_query($con, $sql);
?>

<html>
    <head>

        <!--Titulo de la ventana-->
        <title>Vista - Empresa</title>

    </head>
    <body>
        <!--Apertura de Clase - Tabla de Proyectos-->
        <div class="Tabla de Empresas">
        <h2>Vista de Empresas Registradas</h2>
        <!--Tabla para mostrar los campos de la base de datos a la que fue llamada (Query Line 6)-->
        <table border = "1">
            <thead>
                <tr>
                    <th>IDEmpresa</th>
                    <th>NombreEmpresa</th>
                    <th>Ramo</th>
                    <th>Sector</th>
                    <th>ActividadPrincipal</th>
                    <th>Domicilio</th>
                    <th>Colonia</th>
                    <th>Ciudad</th>
                    <th>RFC</th>
                    <th>NombreRepresentante</th>
                    <th>Puesto</th>
                </tr>
            </thead>
            <tbody>
                <!--Inicio de ciclo While para que mientras haya una fila en la tabla, se muestre los botones y la informacion-->
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <th><?= $row['IDEmpresa'] ?></th>
                        <th><?= $row['NombreEmpresa'] ?></th>
                        <th><?= $row['Ramo'] ?></th>
                        <th><?= $row['Sector'] ?></th>
                        <th><?= $row['ActividadPrincipal'] ?></th>
                        <th><?= $row['Domicilio'] ?></th>
                        <th><?= $row['Colonia'] ?></th>
                        <th><?= $row['Ciudad'] ?></th>
                        <th><?= $row['RFC'] ?></th>
                        <th><?= $row['NombreRepresentante'] ?></th>
                        <th><?= $row['Puesto'] ?></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <br>
    <a href="FormEmpresa.php"> Regresar al Formulario de Empresa</a>
    </body>
</html>