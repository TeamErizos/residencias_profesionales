<?php

include("../../view/header.php");

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

<h4 class="centeredTitle">Seleccione el nuevo Asesor</h4>
<div class="containerFormCentered">
    <div class="centered-div">

        <form class="formContainerCheckbox" action="guardar_comision_asesor.php" method="POST">
            <h3>Asesores:</h3>

            <?php
            // Enviar por POST el id del proyecto
            echo '<input type="hidden" name="id_proyecto" value="' . $id_proyecto . '">';

            foreach ($nombres_profesores as $profesor) {
                echo '<div class="container_btn">';
                echo '<label class="custom-label">';
                echo '<input type="radio" name="profesor" value="' . $profesor['id_profesor'] . '">';
                echo '<span>' . $profesor['nombre_completo'] . '</span>';
                echo '</label>';
                echo '</div>';
            }

            ?>
            <div class="button-containerForm">
                <input type="submit" value="Enviar">
            </div>
        </form>
    </div>
</div>

<?php include("../../view/footer.php"); ?>