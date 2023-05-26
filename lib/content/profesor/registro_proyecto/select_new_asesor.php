<!-- Condición:

    Se deben mostrar los profesores de las carreras de interés seleccionadas
    Debe de contar con una función de regresar

-->

<?php

include("../view/header.php");

// Archivos requeridos
require "../../../login/conexion/conectAWS.php";
require "resources/funciones_proyecto.php";




// Verificar si se hizo un envío de formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Verificar si se seleccionaron carreras
    if (isset($_POST['carrera'])) {
        // Recuperar el array de carreras seleccionadas
        $carreras_ids = $_POST['carrera'];

        // Crear una instancia de la clase Proyecto
        $proyecto = new Proyecto($conn);

        // Obtener los nombres de los profesores de la carrera seleccionada
        $nombres_profesores = $proyecto->buscarProfesoresPorCarrera($carreras_ids);

        // -----------------------------------------------------------------------------

        // Obtener los nombres de las carreras seleccionadas y guardarlas en cookies
        // $nombres_carreras = $proyecto->obtenerNombreCarrera($carreras_ids);

        // Serializar el array de nombres de carreras
        $nombres_carreras_serializados = serialize($carreras_ids);

        // Establecer el tiempo de vida de la cookie (en este caso, 30 días)
        $tiempo_de_vida = time() + (30 * 24 * 60 * 60);

        // Guardar el array de nombres de carreras serializado en una cookie
        setcookie("id_carreras", $nombres_carreras_serializados, $tiempo_de_vida);

?>
        <h4 class="centeredTitle">Seleccione el nuevo Asesor</h4>
        <div class="containerFormCentered">
            <div class="centered-div">
                <form action="form_proyecto.php" method="post">
                    <h3>Asesores:</h3>


            <?php   // Recibo un array con nombres, de ese array debo generar
            // Radio buttons por cada nombre recibido

            // Recorrer cada fila de resultados
            foreach ($nombres_profesores as $fila) {

                // Almacenar el id_profesor y el nombre completo en variables
                $id_profesor = $fila['id_profesor'];
                $nombre_completo = $fila['nombre_completo'];

                // Imprimir el radiobutton con el id_profesor como value y el nombre completo como texto
                echo '<div class="container_btn">';
                echo '<label class="custom-label">';
                echo "<input type='radio' name='nombre' value='$id_profesor'/>";
                echo "<span>$nombre_completo</span>";
                echo '</label>';
                echo '</div>';
            }
        }
    }

            ?>
            <div class="button-containerForm">
                <input type="submit" value="Enviar">
            </div>
                </form>
            </div>
        </div>

        <?php include("../view/footer.php"); ?>