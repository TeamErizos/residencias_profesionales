<!DOCTYPE html>
<html>
<head>
	<title>Búsqueda de Empresas</title>
</head>
<body>
	<h1>Búsqueda de Empresas</h1>
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
		// Consulta SQL para buscar las empresas
		$sql = "SELECT * FROM Empresa WHERE NombreEmpresa LIKE '%$search%' OR ActividadPrincipal LIKE '%$search%' OR NombreRepresentante LIKE '%$search%' OR Puesto LIKE '%$search%'";
		$result = $conn->query($sql);

		// Mostrar los resultados en una tabla
		if ($result->num_rows > 0) {
            echo "<table border=1>";
            echo "<tr><th>Nombre de la Empresa</th><th>Actividad Principal</th><th>Nombre del Representante</th><th>Puesto</th><th>Acciones</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row['NombreEmpresa']."</td><td>".$row['ActividadPrincipal']."</td><td>".$row['NombreRepresentante']."</td><td>".$row['Puesto']."</td><td>";
                echo "<a href='UPDATEEmpresa.php?IDEmpresa=".$row['IDEmpresa']."' class='Tabla de Empresa--Update'>Editar</a> ";
                echo "<a href='DELETEEmpresa.php?IDEmpresa=".$row['IDEmpresa']."' class='Tabla de Empresa--Delete'>Eliminar</a> ";
                echo "<a href='VistaEmpresa.php?IDEmpresa=".$row['IDEmpresa']."' class='Tabla de Empresa--Vista'>Ver más detalles</a>";
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
    <a href="FormEmpresa.php"> Regresar al Formulario de Empresas</a>
</body>
</html>
