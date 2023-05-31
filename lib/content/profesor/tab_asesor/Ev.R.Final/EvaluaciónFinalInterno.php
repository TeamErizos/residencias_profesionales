<?php include("../../view/header.php"); ?>
<!-- tarjetas -->
<!-- tarjetas -->

<main class="table slide-in">





  <!-- ///////////////////////////////////////////////////////// -->

  <section class="table__header">
    <div class="tit">
      <h1>Asesor Interno</h1>
    </div>
    <div class="p1">
      <h1>Evaluación Reporte Final</h1>
    </div>

    <div class="cambioPagina">
      <label for="cambio-pagina" onclick="Atras()" class="cambio__pagina-btn" title="Atrás"></label>
      <label for="cambio-pagina" onclick="Adelante()" class="cambio__pagina-btn1" title="Adelante"></label>
    </div>
  </section>


  <section class="table__body slider-item" id="table1">


    <div class="containerForm">

      <!-- ///////////////////////////////////////////////////////// -->

      <form action="insertar_bd.php" method="post">

        <!-- ///////////////////////////////////////////////////////// -->
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
            <td> Portada </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status cancelled">1</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateUno(this)"></td>
          </tr>
          <tr>
            <td> Agradecimientos </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status pending">0</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateCero(this)"> </td>
          </tr>



          <tr>
            <td> Resumen</td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status gris">2</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateDos(this)"> </td>

          </tr>

          <tr>
            <td> Índice</td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status gris">2</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateDos(this)"> </td>
          </tr>

          <tr>
            <td> Introducción</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status medium">5</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateCinco(this)"> </td>
          </tr>
          <tr>
            <td> Antecendentes o marco teórico</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status medium">5</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateCinco(this)"> </td>
          </tr>
          <tr>
            <td> Justificación</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status medium">5</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateCinco(this)"> </td>
          </tr>
          <tr>
            <td> Objetivos</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status turquesa">10</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateDiez(this)"> </td>
          </tr>

          <tr>
            <td> Metodología</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status turquesa">10</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateDiez(this)"> </td>
          </tr>

          <tr>
            <td> Resultados</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status naranjoso">15</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateQuince(this)"> </td>
          </tr>


          <tr>
            <td> Discusiones</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status shipped">25</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validate25(this)"> </td>
          </tr>

          <tr>
            <td> Conclusiones</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status naranjoso">15</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateQuince(this)"> </td>
          </tr>

          <tr>
            <td> Fuentes de información</td>
            <td></td>
            <td> </td>
            <td> </td>
            <td>
              <p class="status medium">5</p>
            </td>
            <td> <input type="number" name="cal[]" id="cal" oninput="validateCinco(this)"> </td>
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


        </form>
      </div>


  </section>

</main>

<script>
  ///////////////MAX 0//////////////

  function validateCero(input) {

    input.value = Math.abs(input.value);

    if (input.value < 0 || input.value.startsWith('-')) {
      input.value = 0;
    } else if (input.value > 0) {
      input.value = 0;
    }

  }

  ///////////////MAX 1//////////////

  function validateUno(input) {

    input.value = Math.abs(input.value);

    if (input.value < 0 || input.value.startsWith('-')) {
      input.value = 0;
    } else if (input.value > 1) {
      input.value = 1;
    }

  }

  ///////////////MAX 2//////////////

  function validateDos(input) {

    input.value = Math.abs(input.value);

    if (input.value < 0 || input.value.startsWith('-')) {
      input.value = 0;
    } else if (input.value > 2) {
      input.value = 2;
    }

  }

  ///////////////MAX 5//////////////

  function validateCinco(input) {

    input.value = Math.abs(input.value);

    if (input.value < 0 || input.value.startsWith('-')) {
      input.value = 0;
    } else if (input.value > 5) {
      input.value = 5;
    }

  }

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

  ///////////////MAX 25//////////////

  function validate25(input) {

    input.value = Math.abs(input.value);

    if (input.value < 0 || input.value.startsWith('-')) {
      input.value = 0;
    } else if (input.value > 25) {
      input.value = 25;
    }

  }
</script>

<script src="slider.js"></script>

<?php include("../../view/footer.php"); ?>