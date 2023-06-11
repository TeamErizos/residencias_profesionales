<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
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
          <a href="/residencias_profesionales/lib/content/alumno/PanelDeControl-Menu.php">
            <span class="icon"><ion-icon name="grid-outline"></ion-icon></span>
            <span class="title">Menu</span>
          </a>
        </li>

        <li>
          <a href="/residencias_profesionales/lib/content/alumno/PanelDeControl-FAQ.php">
            <span class="icon"><ion-icon name="help-outline"></ion-icon></span>
            <span class="title">F.A.Q</span>
          </a>
        </li>

        <li class="expand">
          <a href="/residencias_profesionales/lib/content/alumno/PanelDeControl-Seguimiento.php">
            <span class="icon"><ion-icon name="document-text-outline"></ion-icon></span>
            <span class="title">Seguimiento</span>
          </a>
        </li>

        <li class="expand">
          <a href="#">
            <span class="icon"><ion-icon name="notifications-outline"></ion-icon></span>
            <span class="title">Notificaciones</span>
          </a>
        </li>
        
            <?php
            if(isset($_REQUEST['logout'])){
              // Destruir la sesión
              session_destroy();
              // Redireccionar al usuario
              header("Location: http://localhost/residencias_profesionales/");
              exit();
            }
            ?>

            <li class="logout-btn">
              <a href="<?php echo $_SERVER['PHP_SELF']; ?>?logout">
                <span class="icon">
                  <ion-icon name="log-out-outline"></ion-icon>
                </span>
                <span class="title">Cerrar Sesión</span>
              </a>
            </li>


      </ul>
      </ul>
    </div>
    <div class="menu">
      <div class="topbar">
        <div class="toggle">
          <ion-icon name="menu-outline"></ion-icon>
        </div>
        <div class="titulo">
          <label class="slide-in">
            <span class="info">Cargar Reporte Final</span>
          </label>
        </div> 
        <div class="user">
        </div>
      </div>
      <main class="table slide-in">
        <section class="table__header">
          <div class="tit">
            <h1></h1>
          </div>
          <div class="p1">
            <h1>Reporte Final</h1>
          </div>

        </section>






        <section class="table__body slider-item" id="table1">
          <form action="" method="post">
            <div class="content">
              <table>
                <thead>
                  <tr>
                    <th>Confirmar subida</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    require_once '../../../login/conexion/conectAWS.php';
                    $pdo = $conn;
                    session_start();

                    $id_alumno = $_SESSION['no_control']; // Ejemplo: ID del alumno como cadena

                    $query = "SELECT d.id_proyecto_activo, pa.id_alumno 
                              FROM Documentos d 
                              INNER JOIN proyecto_x_alumno pa ON d.id_proyecto_activo = pa.id_p_x_a 
                              WHERE pa.id_alumno = :id_alumno";

                    $stmt = $pdo->prepare($query);
                    $stmt->bindValue(":id_alumno", $id_alumno, PDO::PARAM_STR);
                    $stmt->execute();

                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($result)) {
                        $id_proyecto_activo = $result[0]['id_proyecto_activo'];
                        $id_alumno_recuperado = $result[0]['id_alumno'];

                        // Realizar las operaciones necesarias con los valores recuperados
                        // ...
                    } else {
                        echo "Alumno no encontrado";
                    }

                    echo "<tr>";
                    echo "<td>" . "¿Estas seguro que quieres subir tu Reporte Final " . $id_alumno_recuperado . " ?". "</td>";
                    echo "<td><button onclick=\"seleccionarProyecto(event, '" . $id_proyecto_activo . "')\">Si es así, presiona aquí</button></td>";
                    echo "</tr>";
                    
                  ?>
                </tbody>
              </table>
            </div>
          </form>
        </section>
        <section class="table__body slider-item" id="table2">
          <div class="containerForm">
            <form action="update.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id_proyecto_activo" id="id_proyecto_activo_input">
              <input type="file" name="file">
              <br>
              <br>
              <br>
              <button type="submit">Enviar</button>
              <br>
              <br>
              <button type="button" onclick="regresarTabla1()">Regresar</button>
            </form>
          </div>
        </section>
      </main>
    </div>
  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="slider.js"></script>
  <script>
    function seleccionarProyecto(event, id_proyecto) {
      event.preventDefault();
      document.getElementById('table1').style.display = 'none';
      document.getElementById('table2').style.display = 'block';
      document.getElementById('id_proyecto_activo_input').value = id_proyecto;
    }

    function regresarTabla1() {
      document.getElementById('table2').style.display = 'none';
      document.getElementById('table1').style.display = 'block';
    }
  </script>
</body>
</html>