<?php include("../../view/header.php"); ?>
<link rel="stylesheet" type="text/css" href="/residencias_profesionales/lib/content/profesor/view/EstiloFormato.css">
<!-- tarjetas -->
<!-- tarjetas -->

<main class="table slide-in">





  <!-- ///////////////////////////////////////////////////////// -->

  <h4 class="tableTitle">Evaluaciones del Segundo parcial</h3>







    <div class="tableContainer">
      <section class="table__body slider-item " id="table2">

        <!-- ///////////////////////////////////////////////////////// -->

        <!-- ///////////////////////////////////////////////////////// -->

        <section class="table__header">
          <table>
            <thead>
              <tr>
                <th>No. Control</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nombre del Proyecto</th>
                <th>Estado </th>
              </tr>
            </thead>
            <tbody>
        </section>




        <?php
        require "../../../../login/conexion/conectAWS.php";
        require_once "insert_calif.php";

        // Obtener los datos de los alumnos
        try {
          // Instancia la clase Calificaciones
          $calificaciones = new Calificaciones($conn);

          // Obtener todas las IDs de Proyecto_X_Alumno
          $ids_p_x_a = $calificaciones->obtenerIDProyectoXAlumno();

          // Verificar si se obtuvieron los resultados correctamente
          if ($ids_p_x_a) {
            // Iterar sobre las IDs y obtener los datos de los alumnos
            foreach ($ids_p_x_a as $id_p_x_a) {
              $p_x_a_id = $id_p_x_a['id_p_x_a'];

              // Obtener los datos de los alumnos para la ID actual
              $resultados = $calificaciones->obtenerDatosAlumnos($p_x_a_id);

              // Verificar si se obtuvieron los datos correctamente
              if ($resultados) {
                // Iterar sobre los resultados y generar el contenido de la tabla
                foreach ($resultados as $fila) {
                  echo "<tr>";
                  echo "<td>" . $fila['no_control'] . "</td>";
                  echo "<td>" . $fila['nombre_alumno'] . "</td>";
                  echo "<td>" . $fila['ape1_alumno'] . "</td>";
                  echo "<td>" . $fila['ape2_alumno'] . "</td>";
                  echo "<td>" . $fila['nombre_proyecto'] . "</td>";

                  // Verificar si existe una calificación para este estudiante
                  if ($calificaciones->existeCalificacionPar2Int($fila['id_p_x_a'])) {
                    // Si existe una calificación, el estudiante ya ha sido evaluado
                    echo '<td>
                        <div class="button-container-disabled"><button class="Evaluar" type="button" Style="background-color: #2ecc71;" disabled>Evaluado</button></div>
                                </td>';
                  } else {
                    // Si no existe una calificación, el estudiante aún no ha sido evaluado
                    echo '<td>
                                    <form action="EvaluacionParcial2Interno.php" method="POST">
                                        <input type="hidden" name="p_x_a_id" value="' . $fila['id_p_x_a'] . '">
                                        <div class="button-containerForm"><button class="Evaluar" type="submit">Evaluar</button></div>
                                    </form>
                                </td>';
                  }

                  echo "</tr>";
                }
              } else {
                // Mostrar un mensaje de error si no se pudieron obtener los datos
                echo "<tr><td colspan='6'>Error al obtener los datos de los alumnos.</td></tr>";
              }
            }
          } else {
            // Mostrar un mensaje de error si no se pudieron obtener las IDs de Proyecto_X_Alumno
            echo "<tr><td colspan='6'>Error al obtener las IDs de Proyecto_X_Alumno.</td></tr>";
          }
        } catch (PDOException $e) {
          // En caso de error, muestra el mensaje de error
          echo "Error: " . $e->getMessage();
          die();
        }
        ?>



        </tbody>
        </table>


      </section>
    </div>


</main>

</div>


</div>



<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script src="slider.js"></script>

</body>

</html>