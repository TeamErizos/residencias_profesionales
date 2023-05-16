<?php

session_start();
?>


<!DOCTYPE html>
<html>


<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard </title>
  <link rel="stylesheet" type="text/css" href="EstiloEvaluacionesDashboard.css">
  <link rel="stylesheet" href="EstiloFormato.css">

</head>

<body>



  <div class="container">
    <div class="navigation">


      <ul>
        <li>
          <a href="#">
            <span class="icon"><ion-icon name="school-outline"></ion-icon></span>
            <span class="info">Panel de Control</span>
          </a>
        </li>

        <li class="hovered">
          <a href="#">
            <span class="icon"><ion-icon name="grid-outline"></ion-icon></span>
            <span class="title">Menu</span>
          </a>
        </li>

        <li class="expand">
          <a href="#">
            <span class="icon"><ion-icon name="notifications-outline"></ion-icon></span>
            <span class="title">Notificaciones</span>
          </a>
        </li>

        <li class="logout-btn">
          <a href="#">
            <span class="icon">
              <ion-icon name="log-out-outline"></ion-icon>
            </span>
            <span class="title">Cerrar Sesión</span>
          </a>
        </li>

      </ul>
    </div>

    <!-- main -->
    <div class="menu">
      <div class="topbar">
        <div class="toggle">
          <ion-icon name="menu-outline"></ion-icon>
        </div>
        <!-- busqueda -->
        <div class="titulo">
          <label class="slide-in">
            <span class="info">Menu</span>
          </label>
        </div>
        <!-- Imagen de usuario -->
        <div class="user">
          <!-- <img src="user.jpg">                                                 POSIBLE IMPLEMENTACION-->
        </div>
      </div>

      <!-- tarjetas -->
      <!-- tarjetas -->

      <main class="table slide-in">



        <section class="table__header">
          <div class="tit">
            <h1>Asesor Externo</h1>
          </div>
          <div class="p1">
            <h1>Parcial 2</h1>
          </div>

          <div class="cambioPagina">
            <label for="cambio-pagina" onclick="Atras()" class="cambio__pagina-btn" title="Atrás"></label>
            <label for="cambio-pagina" onclick="Adelante()" class="cambio__pagina-btn1" title="Adelante"></label>
          </div>
        </section>



        <section class="table__body slider-item" id="table1">


          <div class="containerForm">

            <form action="insertar_bd_p2E.php" method="post"><!--------------------------------------------------------------------->

              <div class="content">
                <div class="containerForm">

                  <?php

                  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (!isset($_POST['p_x_a_id'])) {
                      throw new Exception("p_x_a_id no está definido");
                    }
                    $p_x_a_id = $_POST['p_x_a_id'];
                  }


                  require "conectAWS.php";
                  require "insert_calif.php";

                  // Instanciar la clase Calificaciones
                  $calificaciones = new Calificaciones($conn);

                  $resultados = $calificaciones->obtenerDatosTodo($p_x_a_id);
                  if ($resultados === false) {
                    echo "obtenerDatosAlumno no devolvió resultados";
                    exit;
                  }


                  ?>


                  <div class="content">
                    <div class="input-box full-width">
                      <label class="full-width-label" for="IDProyecto">Nombre del Residente</label>
                      <input type="text" placeholder="Nombre del Residente" name="NomRe" value="<?php echo $resultados['nombre_alumno']; ?>" required>
                    </div>
                    <div class="input-box">
                      <label for="proyecto">Numero de control</label>
                      <input type="text" placeholder="Numero de control" name="numControl" value="<?php echo $resultados['no_control']; ?>" required>
                    </div>
                    <div class="input-box">
                      <label for="nombreAsesorExterno">Nombre del Proyecto</label>
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



          </div>

        </section>

        <section class="table__body slider-item " id="table2">

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
                <td> Asiste puntualmente en el horario establecido </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>
                  <p class="status cancelled">5</p>
                </td>
                <td> <input type="number" name="cal[]" id="cal" oninput="validateCinco(this)"></td>
              </tr>
              <tr>
                <td> Trabaja en equipo y se comunica en forma efectiva (oral y escrita) </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>
                  <p class="status pending">10</p>
                </td>
                <td> <input type="number" name="cal[]" id="cal" oninput="validateDiez(this)"> </td>
              </tr>
              <tr>
                <td> Tiene iniciativa para colaborar</td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>
                  <p class="status cancelled">5</p>
                </td>
                <td> <input type="number" name="cal[]" id="cal" oninput="validateCinco(this)"> </td>
              </tr>
              <tr>
                <td> Propone mejoras al proyecto</td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>
                  <p class="status pending">10</p>
                </td>
                <td> <input type="number" name="cal[]" id="cal" oninput="validateDiez(this)"> </td>
              </tr>
              <tr>
                <td> Cumple con los objetivos correspondientes al proyecto</td>
                <td></td>
                <td> </td>
                <td> </td>
                <td>
                  <p class="status medium">15</p>
                </td>
                <td> <input type="number" name="cal[]" id="cal" oninput="validateQuince(this)"> </td>
              </tr>
              <tr>
                <td> Es ordenado y cumple satisfactoriamente con las actividades encomendadas en los tiempos establecidos en el cronograma</td>
                <td></td>
                <td> </td>
                <td> </td>
                <td>
                  <p class="status medium">15</p>
                </td>
                <td> <input type="number" name="cal[]" id="cal" oninput="validateQuince(this)"> </td>
              </tr>
              <tr>
                <td> Demuestra liderazgo en su actuar</td>
                <td></td>
                <td> </td>
                <td> </td>
                <td>
                  <p class="status pending">10</p>
                </td>
                <td> <input type="number" name="cal[]" id="cal" oninput="validateDiez(this)"> </td>
              </tr>
              <tr>
                <td> Demuestra conocimiento en el área de su Especialidad</td>
                <td></td>
                <td> </td>
                <td> </td>
                <td>
                  <p class="status shipped">20</p>
                </td>
                <td> <input type="number" name="cal[]" id="cal" oninput="validate20(this)"> </td>
              </tr>
              <tr>
                <td> Demuestra un comportamiento ético (es disciplinado, acata órdenes, respeta a sus compañeros de <br>trabajo, entre otros)</td>
                <td></td>
                <td> </td>
                <td> </td>
                <td>
                  <p class="status pending">10</p>
                </td>
                <td> <input type="number" name="cal[]" id="cal" oninput="validateDiez(this)"> </td>
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
            </tbody>
          </table>
        </section>

        <section class="table__body slider-item" id="table3">

          <div class="containerForm">


            <div class="content">
              <div class="containerForm">



                <div class="content">
                  <div class="input-box full-width">
                    <label for="IDProyecto" class="input-box full-width">Nombre</label>
                    <input type="text" placeholder="Nombre del Residente" name="NomRe" required>
                  </div>


                  <div class="input-box">
                    <label for="observaciones">Observaciones</label>
                    <textarea placeholder="Observaciones" name="observaciones" required></textarea>
                  </div>

                  <div class="input-box">
                    <label for="fecha">Fecha</label>
                    <input type="date" placeholder="Fecha" name="fecha" required>
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