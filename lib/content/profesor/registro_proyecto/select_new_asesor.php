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

        // Verificar si se encontraron profesores
        if (!empty($nombres_profesores)) {
            // -----------------------------------------------------------------------------

            // Obtener los nombres de las carreras seleccionadas y guardarlas en cookies
            // $nombres_carreras = $proyecto->obtenerNombreCarrera($carreras_ids);

            // Serializar el array de nombres de carreras
            $nombres_carreras_serializados = serialize($carreras_ids);

            // Establecer el tiempo de vida de la cookie (en este caso, 30 días)
            $tiempo_de_vida = time() + (30 * 24 * 60 * 60);

            // Guardar el array de nombres de carreras serializado en una cookie
            setcookie("id_carreras", $nombres_carreras_serializados, $tiempo_de_vida);
        } else {
            // Mostrar una alerta si no se encontraron profesores
            echo '<script>alert("No se encontraron profesores para las carreras seleccionadas.");</script>';
            exit; // Detener la ejecución del código
        }
    } else {
        // Mostrar una alerta si no se seleccionaron carreras
        echo '<script>alert("Debes seleccionar al menos una carrera.");</script>';
        exit; // Detener la ejecución del código
    }
}
?>

<h4 class="centeredTitle">Seleccione el nuevo Asesor</h4>
<div class="containerFormCentered">
  <div class="centered-div">
    <form class="formContainerCheckbox" action="form_proyecto.php" method="post" id="asesorForm">
      <h3>Asesores:</h3>

      <?php
      // Verificar si se encontraron profesores
      if (!empty($nombres_profesores)) {
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
      ?>

      <div class="button-containerForm">
        <input type="submit" value="Enviar">
      </div>
    </form>
  </div>
</div>

<script>
  // Obtener el formulario y el botón de enviar
  var form = document.getElementById('asesorForm');
  var submitButton = document.querySelector('input[type="submit"]');

  // Agregar evento de escucha al enviar el formulario
  form.addEventListener('submit', function(event) {
    // Obtener el valor del radio button seleccionado
    var selectedAsesor = form.querySelector('input[type="radio"]:checked');

    // Verificar si se ha seleccionado un asesor
    if (!selectedAsesor) {
      // Prevenir el envío del formulario si no se ha seleccionado un asesor
      event.preventDefault();
      alert('Debes seleccionar al menos un asesor.');
    }
  });
</script>

<?php include("../view/footer.php"); ?>
