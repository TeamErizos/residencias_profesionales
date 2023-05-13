<?php

// Recibir la clave del proyecto a actualizar el asesor
// Cambiar el id_asesor_interno

$id_proyecto = $_GET['id_proyecto'];

// Recuperar conexion y clase
require "../../../../../login/conexion/conectAWS.php";
require "func_mostrar_proy_x_alum.php";

// Mostrar todos los nombres de los profesores de la carrera del proyecto

    // Instanciar clase
    $proyecto = new Proyecto($conn);

    // Recuperar arreglo de profesores
    $nombres_profesores = $proyecto->obtenerProfesoresDisponibles($id_proyecto);

    // Mostrar todos los posibles asesores...
?>

<form action="guardar_comision_asesor.php" method="POST">

<?php
    // Enviar por POST el id del proyecto
    echo '<input type="hidden" name="id_proyecto" value="' . $id_proyecto . '">';

    foreach ($nombres_profesores as $profesor) {
        echo '<input type="radio" name="profesor" value="' . $profesor['id_profesor'] . '">';
        echo '<label>' . $profesor['nombre_completo'] . '</label><br>';
    }
?>
    <input type="submit" value="Enviar">
</form>

