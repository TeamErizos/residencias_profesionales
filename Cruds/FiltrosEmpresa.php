<?php
include("ConexionBD.php");
$con = connection();

$ramo = isset($_POST['Ramo']) ? $_POST['Ramo'] : '';
$sector = isset($_POST['Sector']) ? $_POST['Sector'] : '';

$sql = "SELECT * FROM Empresa";

if (!empty($ramo)) {
  $sql .= " WHERE Ramo = '$ramo'";
}

if (!empty($sector)) {
  $sql .= " WHERE Sector = '$sector'";
}

$query = mysqli_query($con, $sql);
?>

<html>

<head>

  <!--Titulo de la ventana-->
  <title>Formulario de Registro y Vista de los Empresas</title>

</head>

<body>
  <!--Apertura de Clase - Formulario de Empresa-->
  <div class="Formulario_Empresa">
    <h1>Agregar Empresas</h1>
    <form action="INSERTEmpresa.php" method="POST">
      <!--Campo ID-->
      <b> ID de la Empresa: </b> <input type="text" name="IDEmpresa" placeholder="ID de la Empresa">
      <br>
      <br>
      <!--Campo Nombre del la Empresa-->
      <b> Nombre del la Empresa: </b> <input type="text" name="NombreEmpresa" placeholder="Nombre del la Empresa">
      <br>
      <br>
      <!--Campo Ramo-->
      <b> Ramo (Industrial - De Servicios - Otro): </b> <input type="text" name="Ramo" placeholder="Ramo">
      <br>
      <br>
      <!--Campo Sector-->
      <b> Sector (Publico - Privado): </b> <input type="text" name="Sector" placeholder="Sector">
      <br>
      <br>
      <!--Campo Actividad Principal-->
      <b> Actividad Principal: </b> <input type="text" name="ActividadPrincipal" placeholder="Actividad Principal">
      <br>
      <br>
      <!--Campo Domicilio-->
      <b> Domicilio: </b> <input type="text" name="Domicilio" placeholder="Domicilio">
      <br>
      <br>
      <!--Campo Colonia-->
      <b> Colonia: </b> <input type="text" name="Colonia" placeholder="Colonia">
      <br>
      <br>
      <!--Campo Ciudad-->
      <b> Ciudad: </b> <input type="text" name="Ciudad" placeholder="Ciudad">
      <br>
      <br>
      <!--Campo RFC-->
      <b> RFC: </b> <input type="text" name="RFC" placeholder="RFC">
      <br>
      <br>
      <!--Campo Nombre del Representante-->
      <b> Nombre del Representante: </b> <input type="text" name="NombreRepresentante" placeholder="Nombre del Representante">
      <br>
      <br>
      <!--Campo Puesto-->
      <b> Puesto: </b> <input type="text" name="Puesto" placeholder="Puesto">
      <br>
      <br>
      <!--Boton para Agregar a la Base de Datos-->
      <input type="submit" value="Agregar">
    </form>
  </div>

  <!-- Filtro de Empresas -->
  <div class="Filtro_Empresa">
    <h3>Filtros</h3>
    <form action="FiltrosEmpresa.php" method="POST">
      <b> Ramo: </b>
      <select name="Ramo">
        <option value="">Todos</option>
        <option value="Industrial">Industrial</option>
        <option value="De Servicios">De Servicios</option>
        <option value="Otro">Otro</option>
      </select>
      <br>
      <br>
      <input type="submit" value="Filtrar">
    </form>

    <form action="FiltrosEmpresa.php" method="POST">
      <b> Sector: </b>
      <select name="Sector">
        <option value="">Todos</option>
        <option value="Publico">Publico</option>
        <option value="Privado">Privado</option>
      </select>
      <br>
      <br>
      <input type="submit" value="Filtrar">
    </form>
  </div>

<!-- Busqueda de Proyectos -->
<p>
<h3>Busqueda</h3>
¿No encuentras la fila que necesitas? Prueba nuestro motor de busqueda: <a href="BusquedaEmpresa.php"> Iniciar una Busqueda</a>
</P>

<!--Apertura de Clase - Tabla de Empresa-->
<div class="Tabla de Empresas">
        <h2>Vista de Empresas Registradas</h2>
        <!--Tabla para mostrar los campos de la base de datos a la que fue llamada (Query Line 6)-->
        <table border = "1">
            <thead>
                <tr>
                    <!--<th>IDEmpresa</th>-->
                    <th>NombreEmpresa</th>
                    <th>Ramo</th>
                    <th>Sector</th>
                    <th>ActividadPrincipal</th>
                    <!--<th>Domicilio</th>-->
                    <!--<th>Colonia</th>-->
                    <!--<th>Ciudad</th>-->
                    <!--<th>RFC</th>-->
                    <th>NombreRepresentante</th>
                    <th>Puesto</th>
                    <th colspan = 3>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!--Inicio de ciclo While para que mientras haya una fila en la tabla, se muestre los botones y la informacion-->
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <!--<th><?= $row['IDEmpresa'] ?></th>-->
                        <th><?= $row['NombreEmpresa'] ?></th>
                        <th><?= $row['Ramo'] ?></th>
                        <th><?= $row['Sector'] ?></th>
                        <th><?= $row['ActividadPrincipal'] ?></th>
                        <!--<th><?= $row['Domicilio'] ?></th>-->
                        <!--<th><?= $row['Colonia'] ?></th>-->
                        <!--<th><?= $row['Ciudad'] ?></th>-->
                        <!--<th><?= $row['RFC'] ?></th>-->
                        <th><?= $row['NombreRepresentante'] ?></th>
                        <th><?= $row['Puesto'] ?></th>
                        
                        <!--Botones de lado derecho para editar o eliminar un registro de la pagina y de la base de datos-->
                        <th><a href="UPDATEEmpresa.php?IDEmpresa=<?= $row['IDEmpresa'] ?>" class="Tabla de Empresa--Update">Editar</a></th>
                        <th><a href="DELETEEmpresa.php?IDEmpresa=<?= $row['IDEmpresa'] ?>" class="Tabla de Empresa--Delete" >Eliminar</a></th>
                        <th><a href="VistaEmpresa.php?IDEmpresa=<?= $row['IDEmpresa'] ?>" class="Tabla de Empresa--Vista">Ver mas detalles</a></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <a href="MenuPrincipal.php"> Regresar al Menu Principal</a>
        <br>
        <br>
        <a href="Print_Table_Empresa.php"> Imprimir Tabla</a>
    </div>

</body>

</html>