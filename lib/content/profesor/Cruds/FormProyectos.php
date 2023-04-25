<!--Incluir conexion a la Base de Datos y Query para mostrar los datos de la tabla-->
<?php
include("ConexionBD.php");
$con = connection();

$sql = "SELECT * FROM Proyectos";
$query = mysqli_query($con, $sql);
?>



<html>

<head>

    <!--Titulo de la ventana-->
    <title>Formulario - Proyectos</title>

</head>

<body>
    <!--Apertura de Clase - Formulario de Proyecto-->
    <div class="Formulario_Proyectos">
        <h1>Agregar Proyectos</h1>
        <form action="INSERTProyectos.php" method="POST">
            <!--Campo ID-->
            <b> ID del Proyecto: </b> <input type="text" name="IDProyecto" placeholder="ID del Proyecto">
            <br>
            <br>
            <!--Campo Nombre del Proyecto-->
            <b> Nombre del Proyecto: </b> <input type="text" name="NombreProyecto" placeholder="Nombre del Proyecto">
            <br>
            <br>
            <!--Campo Tipo de Proyecto-->
            <b> Tipo de Proyecto (Interno - Externo - Dual): </b> <input type="text" name="TipoProyecto" placeholder="Tipo de Proyecto">
            <br>
            <br>
            <!--Campo Opcion de Proyecto-->
            <b> Opcion de Proyecto (Propuesta Propia - Trabajador - Banco de Proyectos): </b> <input type="text" name="OpcionProyecto" placeholder="Opcion del Proyecto">
            <br>
            <br>
            <!--Campo Periodo Inicial-->
            <b> Periodo Inicial (dd-mm-aaaa): </b><input type="text" name="PeriodoInicio" placeholder="Periodo Inicial">
            <br>
            <br>
            <!--Campo Periodo Final-->
            <b> Periodo Final (dd-mm-aaaa): </b> <input type="text" name="PeriodoFinal" placeholder="Periodo Final">
            <br>
            <br>
            <!--Campo Nombre del Asesor Interno-->
            <b> Nombre del Asesor Interno: </b> <input type="text" name="NombreAsesorInterno" placeholder="Nombre del Asesor Interno">
            <br>
            <br>
            <!--Campo Numero de Residentes-->
            <b> Numero de Residentes en el Proyecto: </b> <input type="text" name="NumResidentes" placeholder="Numero de Residentes">
            <br>
            <br>
            <!--Boton para Agregar a la Base de Datos-->
            <input type="submit" value="Agregar">
        </form>
    </div>

    <!-- Filtro de Proyectos -->
<div class="Filtro_Proyectos">
    <h3>Filtros</h3>
    <form action="FiltrosProyectos.php" method="POST">
        <b> Tipo de Proyecto: </b> 
        <select name="TipoProyecto">
            <option value="">Todos</option>
            <option value="Interno">Interno</option>
            <option value="Externo">Externo</option>
            <option value="Dual">Dual</option>
        </select>
        <br>
        <br>
        <input type="submit" value="Filtrar">
    </form>

    <form action="FiltrosProyectos.php" method="POST">
        <b> Opcion de Proyecto: </b> 
        <select name="OpcionProyecto">
            <option value="">Todos</option>
            <option value="Propuesta Propia">Propuesta Propia</option>
            <option value="Trabajador">Trabajador</option>
            <option value="Banco de Proyectos">Banco de Proyectos</option>
        </select>
        <br>
        <br>
        <input type="submit" value="Filtrar">
    </form>
</div>

<!-- Busqueda de Proyectos -->
<p>
<h3>Busqueda</h3>
¿No encuentras la fila que necesitas? Prueba nuestro motor de busqueda: <a href="BusquedaProyectos.php"> Iniciar una Busqueda</a>
</P>

    <!--Apertura de Clase - Tabla de Proyectos-->
    <div class="Tabla de Proyectos">
        <h2>Vista de Proyectos Registrados</h2>
        <!--Tabla para mostrar los campos de la base de datos a la que fue llamada (Query Line 6)-->
        <table border="1">
            <thead>
                <tr>
                    <!--<th>IDProyecto</th>-->
                    <th>NombreProyecto</th>
                    <th>TipoProyecto</th>
                    <th>OpcionProyecto</th>
                    <!--<th>PeriodoInicio</th>-->
                    <!--<th>PeriodoFinal</th>-->
                    <th>NombreAsesorInterno</th>
                    <th>NumResidentes</th>
                    <th colspan = 3>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!--Inicio de ciclo While para que mientras haya una fila en la tabla, se muestre los botones y la informacion-->
                <?php while ($row = mysqli_fetch_array($query)) : ?>
                    <tr>
                        <!--<th><?= $row['IDProyecto'] ?></th>-->
                        <th><?= $row['NombreProyecto'] ?></th>
                        <th><?= $row['TipoProyecto'] ?></th>
                        <th><?= $row['OpcionProyecto'] ?></th>
                        <!--<th><?= $row['PeriodoInicio'] ?></th>-->
                        <!--<th><?= $row['PeriodoFinal'] ?></th>-->
                        <th><?= $row['NombreAsesorInterno'] ?></th>
                        <th><?= $row['NumResidentes'] ?></th>

                        <!--Botones de lado derecho para editar o eliminar un registro de la pagina y de la base de datos-->
                        <th><a href="UPDATEProyectos.php?IDProyecto=<?= $row['IDProyecto'] ?>" class="Tabla de Proyectos--Update">Editar</a></th>
                        <th><a href="DELETEProyectos.php?IDProyecto=<?= $row['IDProyecto'] ?>" class="Tabla de Proyectos--Delete">Eliminar</a></th>
                        <th><a href="VistaProyectos.php?IDProyecto=<?= $row['IDProyecto'] ?>" class="Tabla de Proyectos--Vista">Ver mas detalles</a></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <a href="MenuPrincipal.php"> Regresar al Menu Principal</a>
        <br>
        <br>
        <a href="Print_Table_Proyectos.php"> Imprimir Tabla</a>
    </div>

</body>

</html>