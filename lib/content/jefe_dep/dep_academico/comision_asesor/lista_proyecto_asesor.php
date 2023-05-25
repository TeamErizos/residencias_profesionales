<?php
include("../view/header.php");

// Una lista que permita mostrar a los proyectos que tienen asesor (profesor)
// segun el campo [comisionado] de la tabla asesores_proyecto, este campo booleano
// permite recuperar a los proyectos que tienen asesor pero aun no ha sido comisionado

// De la misma forma, se mostrará: nombre del proyecto, asesor sugerido (el asesor
// que fue capturado al inicio). Cada registro contará con dos botones

// Boton 1. Crear la comisión de asesor con el asesor actual
// Boton 2. Cambiar de asesor

// Si se va mantener el asesor actual, ir directo a guardar_comision_asesor.php
// Si se va cambiar de asesor, ir a cambio_asesor.php

// Conexion y funciones
require "resources/func_mostrar_proy_x_alum.php";
require "../../../../login/conexion/conectAWS.php";

// Instancair clase

$proyecto = new Proyecto($conn);

// Usar las funciones para recuperar el arreglo de proyectos y profesores
$proyectos = $proyecto->obtenerProyectosSinAsesor();

$nombre_proyectos = $proyecto->obtenerNombreProyectos($proyectos);
$nombre_asesores = $proyecto->obtenerNombreCompletoAsesores($proyectos);

// Imprimir los nombres de los proyectos, los nombres de los asesores y los botones de acción
foreach ($proyectos as $key => $proyecto) {
  $id_proyecto = $proyecto['id_proyecto'];
  $nombre_proyecto = $nombre_proyectos[$key];
  $nombre_asesor = $nombre_asesores[$key];

  echo "Proyecto: " . $nombre_proyecto . "<br>";
  echo "Asesor: " . $nombre_asesor . "<br>";
  
  // Agregar los botones con eventos onclick
  echo "<button onclick='accion1($id_proyecto)'>Crear comisión</button>";
  echo "<button onclick='accion2($id_proyecto)'>Cambiar asesor</button>";
  
  echo "<br><br>";
}

?>

<script>
    function accion1(idProyecto) {
    // Redirigir a la página para crear la comision del asesor con el ID del proyecto
    window.location.href = "resources/guardar_comision_asesor.php?id_proyecto=" + idProyecto;
    }

    function accion2(idProyecto) {
    // Redirigir a la página de para cambiar al asesor con el ID del proyecto
    window.location.href = "resources/cambio_asesor.php?id_proyecto=" + idProyecto;
    }
</script>

<?php include("../view/footer.php"); ?>