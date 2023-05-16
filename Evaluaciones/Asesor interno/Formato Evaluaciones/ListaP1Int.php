<!DOCTYPE html>
<html>


<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard </title>
  <link rel="stylesheet" type="text/css" href="EstiloEvaluacionesDashboard.css">
  <link rel="stylesheet" href="EstiloFormato.css">

  <style>
    .Evaluar {
      height: 40px;
      padding: 0 10px;
      border-radius: 25px;
      border: none;
      outline: none;
      background-color: #287bff;
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
  </style>


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





        <!-- ///////////////////////////////////////////////////////// -->

        <section class="table__header">
          <div class="tit">
            <h1>Lista</h1>
          </div>

        </section>







        <section class="table__body slider-item " id="table2">

          <!-- ///////////////////////////////////////////////////////// -->

            <!-- ///////////////////////////////////////////////////////// -->


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




                <?php
                require "conectAWS.php";
                require "insert_calif.php";

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
                            if ($calificaciones->existeCalificacionPar1Int($fila['id_p_x_a'])) {
                                // Si existe una calificación, el estudiante ya ha sido evaluado
                                echo '<td>
                                    <button class="Evaluar" type="button" Style="background-color: #2ecc71;" disabled>Evaluado</button>
                                </td>';
                            } else {
                                // Si no existe una calificación, el estudiante aún no ha sido evaluado
                                echo '<td>
                                    <form action="EvaluacionParcial1Interno.php" method="POST">
                                        <input type="hidden" name="p_x_a_id" value="' . $fila['id_p_x_a'] . '">
                                        <button class="Evaluar" type="submit">Evaluar</button>
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


      </main>

    </div>


  </div>



  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  <script src="slider.js"></script>

</body>

</html>