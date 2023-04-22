<!DOCTYPE html>
<html>
<head>
	<title>Búsqueda de Proyectos</title>
</head>
<body>
	<h1>Búsqueda de Proyectos</h1>
	<form method="get">
		<label for="search">Buscar:</label>
		<input type="text" name="search" id="search">
		<input type="submit" value="Buscar">
	</form>

	<?php
	// Conexion a la base de datos
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "test";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Conexión fallida: " . $conn->connect_error);
	}

	// Verificar si se realizó una búsqueda
	if (isset($_GET['search'])) {
		$search = $_GET['search'];
		// Consulta SQL para buscar los proyectos
		$sql = "SELECT * FROM Proyectos WHERE NombreProyecto LIKE '%$search%' OR TipoProyecto LIKE '%$search%' OR OpcionProyecto LIKE '%$search%' OR NombreAsesorInterno LIKE '%$search%' OR NumResidentes LIKE '%$search%'";
		$result = $conn->query($sql);

		// Mostrar los resultados en una tabla
		if ($result->num_rows > 0) {
            echo "<table border=1>";
            echo "<tr><th>Nombre del Proyecto</th><th>Tipo de Proyecto</th><th>Opción de Proyecto</th><th>Nombre del Asesor Interno</th><th>Número de Residentes</th><th>Acciones</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row['NombreProyecto']."</td><td>".$row['TipoProyecto']."</td><td>".$row['OpcionProyecto']."</td><td>".$row['NombreAsesorInterno']."</td><td>".$row['NumResidentes']."</td><td>";
                echo "<a href='UPDATEProyectos.php?IDProyecto=".$row['IDProyecto']."' class='Tabla de Proyectos--Update'>Editar</a> ";
                echo "<a href='DELETEProyectos.php?IDProyecto=".$row['IDProyecto']."' class='Tabla de Proyectos--Delete'>Eliminar</a> ";
                echo "<a href='VistaProyectos.php?IDProyecto=".$row['IDProyecto']."' class='Tabla de Proyectos--Vista'>Ver más detalles</a>";
                echo "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron resultados.";
        }
	}

	$conn->close();
	?>
    <br>
    <a href="FormProyectos.php"> Regresar al Formulario de Proyectos</a>
</body>
</html>
