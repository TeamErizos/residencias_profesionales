<?php

// Una lista de solicitudes que mostrará los proyectos encomendados a revisar
// Segun sea el id_profesor

// Step1: Recuperar el id del profesor segun la sesión -> $_SESSION['id_profesor]

// Step2: Buscar si tiene id_revisador (id_profesor) un registro de proyecto_x_alumno

// Step3: Mostrar los proyectos donde el id del profesor coincide con la $_SESSION

// Step4: Mostrar el contenido del anteproyecto, constancia y solicitud

// Step5: El profesor podrá seleccionar SI pasa el dictamen
    // Si pasa el dictamen, valor dictamen se vuelve true

    // SI NO, se elimina el registro de proyecto_x_alumno y documento

// Step6: El dictamen de proyecto se hace en base a los que tienen [Dictamen] TRUE

//----------------------------------------------------------
// USELESS CODE, ONLY FOR EXAMPLE
// --------->

// Crear instancia, conexion y sesión
require "resources/funciones_revision.php";
require "../../../login/conexion/conectAWS.php";
session_start(); // En la sesión está nuestro id de profesor
$revision = new Revision($conn);


// Llamada a la función para buscar Alumnos A Revisar por el Profesor
    $registros = $revision->buscarRegistrosAlumnoNoRevisado($_SESSION['id_profesor']);

// Crear arrays separados para id_p_x_a y id_alumno y id_proyecto
// -> Estos datos son recuperados por la funcion AlumnosNoRevisados
    $id_p_x_a_array = array();
    $id_alumno_array = array();
    $id_proyecto_array = array();

// Iterar sobre $registros y separar los valores en los arrays correspondientes
    foreach ($registros as $registro) {
        $id_p_x_a_array[] = $registro['id_p_x_a'];
        $id_proyecto_array[] = $registro['id_proyecto'];
        $id_alumno_array[] = $registro['id_alumno'];
    }

// Buscar los nombres de los alumnos segun el array id_alumno_array[]
    $alumnos = $revision->obtenerNombresAlumnos($id_alumno_array);

// Buscar los nombres de los proyectos segun el array id_proyecto_array[]
    $proyectos = $revision->buscarNombresProyectos($id_proyecto_array);

// --------------------------------------------------------------------
// FUSIONAR LOS 3 ARREGLOS
    $solicitudes_pendientes = $revision->fusionarArreglos($id_p_x_a_array, $alumnos, $proyectos);

    // <- Este arreglo contiene toda la información de los proyectos pendientes por revisar

?>

<!DOCTYPE html>
<html>
<head>
    <title>Arreglo Fusionado</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Arreglo Fusionado</h1>
    
    <?php

    // Imprimir la tabla
    echo '<table>';
    echo '<tr><th>String 1</th><th>String 2</th><th>Revisar</th></tr>';
    foreach ($solicitudes_pendientes as $arreglo) {
        $id = $arreglo[0];
        $string1 = $arreglo[1];
        $string2 = $arreglo[2];

        echo '<tr>';
        echo '<td>' . $string1 . '</td>';
        echo '<td>' . $string2 . '</td>';
        echo '<td>';
        echo '<button type="button" onclick="revisar(' . $id . ')">Revisar</button>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    ?>

    <script>
        function revisar(idSeleccionado) {
            // Redireccionar a otro archivo PHP con el ID seleccionado como parámetro en la URL
            window.location.href = 'resources/leer_archivos.php?id=' + idSeleccionado;
        }
    </script>
</body>
</html>



