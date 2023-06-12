<?php include("../../view/header.php") ?>
<link rel="stylesheet" type="text/css" href="/residencias_profesionales/lib/content/profesor/view/EstiloFormato.css">
<!-- tarjetas -->
<!-- tarjetas -->

<main class="table slide-in">



  <section class="table__header">
    <div class="tit">
      <h1>Asesor Interno</h1>
    </div>
    <div class="p1">
      <h1>Parcial 1</h1>
    </div>

    <div class="cambioPagina">
      <label for="cambio-pagina" onclick="Atras()" class="cambio__pagina-btn" title="Atrás"></label>
      <label for="cambio-pagina" onclick="Adelante()" class="cambio__pagina-btn1" title="Adelante"></label>
    </div>
  </section>



  <section class="table__body slider-item" id="table1">


    <div class="containerForm">

      <form action="insertar_bd_p1I.php" method="post"><!--------------------------------------------------------------------->

        <div class="content">
          <div class="containerForm">

            <?php

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              if (!isset($_POST['p_x_a_id'])) {
                throw new Exception("p_x_a_id no está definido");
              }
              $p_x_a_id = $_POST['p_x_a_id'];
            }


            require "../../../../login/conexion/conectAWS.php";
            require_once "insert_calif.php";

            // Instanciar la clase Calificaciones
            $calificaciones = new Calificaciones($conn);

            $resultados = $calificaciones->obtenerDatosTodo($p_x_a_id);
            if ($resultados === false) {
              echo "obtenerDatosAlumno no devolvió resultados";
              exit;
            }

            $resultadosAlum = $calificaciones->obtenerDatosAlumnos($p_x_a_id);
            if ($resultadosAlum === false) {
              echo "obtenerDatosAlumnos no devolvió resultados";
              exit;
            }


            $fechaHoy = date('Y-m-d');


            ?>


            <div class="content">
              <div class="input-box full-width">
                <label class="full-width-label" for="IDProyecto">Nombre del Residente</label>
                <input type="text" placeholder="Nombre del Residente" name="NomRe" value="<?php echo $resultados['nombre_alumno'], ' ', $resultadosAlum[0]['ape1_alumno'], ' ', $resultadosAlum[0]['ape2_alumno']; ?>" required>
              </div>
              <div class="input-box">
                <label for="proyecto">Numero de control</label>
                <input type="text" placeholder="Numero de control" name="numControl" value="<?php echo $resultados['no_control']; ?>" required>
              </div>
              <div class="input-box">
                <label for="nombreAsesorInterno">Nombre del Proyecto</label>
                <input type="text" placeholder="Nombre del proyecto" name="nomPro" value="<?php echo $resultados['nombre_proyecto']; ?>" required>
              </div>
              <div class="input-box">
                <label for="numResidentes">Programa educativo</label>
                <input type="text" placeholder="Programa educativo" name="proEdu" value="<?php echo $resultados['nom_carrera']; ?>" required>
              </div>
              <div class="input-box">
                <label for="periodoInicial">Periodo de realización de la Residencia Profesional:</label>
                <input type="text" placeholder="Periodo de realización" name="periodoRe" value="<?php echo $resultados['periodo_0_sem']; ?>" required>

              </div>
            </div>

          </div>



        </div>

  </section>

  <section class="table__body slider-item " id="table2">
    <section class="table__header">

      <table>
        <thead>
          <tr>
            <th>En qué medida el residente cumple con lo siguiente:</th>
            <th></th>
            <th></th>
            <th></th>
            <th>Valor</th>
            <th>Evaluación </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td> Asistió puntualmente a las reuniones de asesoría </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status pending">10</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateDiez(this)"></td>
          </tr>
          <tr>
            <td> Demuestra conocimiento en el área de su especialidad </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status shipped">20</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validate20(this)"> </td>
          </tr>
          <tr>
            <td> Trabaja en equipo y se comunica en forma efectiva (oral y escrita)</td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status medium">15</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateQuince(this)"> </td>
          </tr>
          <tr>
            <td> Es dedicado y proactivo en las actividades encomendadas</td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status shipped">20</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validate20(this)"> </td>
          </tr>
          <tr>
            <td> Es ordenado y cumple satisfactoriamente con las actividades encomendadas en los tiempos establecidos por el programa</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status shipped">20</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validate20(this)"> </td>
          </tr>
          <tr>
            <td> Propone mejoras al proyecto</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status medium">15</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateQuince(this)"> </td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td> </td>
            <td><b></td>
            <td>

            </td>
            <td> <br><br> </td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td> </td>
            <td><b></td>
            <td>

            </td>
            <td> <br><br> </td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td> </td>
            <td><b></td>
            <td>

            </td>
            <td> <br><br> </td>
          </tr>

          <tr>
            <td></td>
            <td></td>
            <td> </td>
            <td><b></td>
            <td>

            </td>
            <td> <br> </td>
          </tr>
        </tbody>
      </table>
    </section>
  </section>

  <section class="table__body slider-item" id="table3">

    <div class="containerForm">


      <div class="content">
        <div class="containerForm">



          <div class="content">
            <div class="input-box full-width">
              <label for="IDProyecto" class="input-box full-width">Nombre</label>
              <input type="text" placeholder="Nombre del Asesor" name="NomRe" value="<?php echo $resultados['nom_profesor'], ' ', $resultados['ape1_profesor'], ' ', $resultados['ape2_profesor']; ?>" required>
            </div>


            <div class="input-box">
              <label for="observaciones">Observaciones</label>
              <textarea placeholder="Observaciones" name="observaciones" required></textarea>
            </div>

            <div class="input-box">
              <label for="fecha">Fecha</label>
              <input type="date" placeholder="Fecha" name="fecha" value="<?php echo $fechaHoy; ?>" required>
            </div>


            <div class="input-box">
              <label for="firma">Firma</label>
              <input type="text" placeholder="Firma" name="firma" required>
            </div>


            <div class="input-box">
              <label for="sello">Sello</label>
              <input type="text" placeholder="Sello" name="sello" required>
            </div>

          </div>
          <input type="hidden" name="p_x_a_id" value="<?php echo $p_x_a_id; ?>">
          <button class="enviar" type="submit">Enviar</button>


        </div>


        </form><!--------------------------------------------------------------------->
      </div>


  </section>

</main>


</div>


</div>

<script>
  ///////////////MAX 10//////////////

  function validateDiez(input) {

    input.value = Math.abs(input.value);

    if (input.value < 0 || input.value.startsWith('-')) {
      input.value = 0;
    } else if (input.value > 10) {
      input.value = 10;
    }

  }

  ///////////////MAX 15//////////////

  function validateQuince(input) {

    input.value = Math.abs(input.value);

    if (input.value < 0 || input.value.startsWith('-')) {
      input.value = 0;
    } else if (input.value > 15) {
      input.value = 15;
    }

  }

  ///////////////MAX 20//////////////

  function validate20(input) {

    input.value = Math.abs(input.value);

    if (input.value < 0 || input.value.startsWith('-')) {
      input.value = 0;
    } else if (input.value > 20) {
      input.value = 20;
    }

  }
</script>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script src="slider.js"></script>
</body>

</html>