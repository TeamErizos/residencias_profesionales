<!-- Visible solo SI esta loggeado -->
<?php 
// Iniciar la sesión
session_start();

// Si no hay sesión, entonces...
if(!empty($_SESSION['no_control'])){?>
  <!DOCTYPE html>
  <html>
  <head>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard </title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
            <a href="PanelDeControl-Seguimiento.php">
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

          <li>
            <a href="#">
              <span class="icon"><ion-icon name="help-outline"></ion-icon></span>
              <span class="title">F.A.Q</span>
            </a>
          </li>
          
          
          <?php

            if(isset($_REQUEST['logout'])){
              // Destruir la sesión
              session_destroy();
              // Redireccionar al usuario
              header("Location: ../../../index.php");
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
      </div>

      <!-- main -->
      <div class="main">
        <div class="topbar">
          <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
          </div>
          <!-- busqueda -->
          <div class="titulo">
            <label>
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
  <div class="cardBox">
    <a href="solicitar_residencia.html">
      <div class="card">
        <div>
          <div class="numbers"></div>
          <div class="cardName">Solicitar Residencia</div>
        </div>
        <div class="iconBx">
          <ion-icon name="git-pull-request-outline"></ion-icon>
        </div>
      </div>
    </a>

    <a href="reportes_parciales.html">
      <div class="card">
        <div>
          <div class="numbers"></div>
          <div class="cardName">Reportes Parciales</div>
        </div>
        <div class="iconBx">
          <ion-icon name="document-outline"></ion-icon>
        </div>
      </div>
    </a>

    <a href="reporte_final.html">
      <div class="card">
        <div>
          <div class="numbers"></div>
          <div class="cardName">Reporte Final</div>
        </div>
        <div class="iconBx">
          <ion-icon name="document-text-outline"></ion-icon>
        </div>
      </div>
    </a>
    
    <a href="solicitar_asesoria.html">
      <div class="card">
        <div>
          <div class="numbers"></div>
          <div class="cardName">Solicitar Asesoria</div>
        </div>
        <div class="iconBx">
          <ion-icon name="calendar-outline"></ion-icon>
        </div>
      </div>
    </a>
  </div>




      </div>

      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

      <script>
      //MenuToggle
        let toggle = document.querySelector('.toggle');
        let navigation = document.querySelector('.navigation');
        let main = document.querySelector('.main');

        toggle.onclick = function(){
          navigation.classList.toggle('active')
          main.classList.toggle('active')
        }

      //add hover class in selected list item
        let list = document.querySelectorAll('.navigation li')
        function activeLink(){
          list.forEach((item) =>
            item.classList.remove('hovered'));
          this.classList.add('hovered');
        }
        list.forEach((item) =>
          item.addEventListener('mouseover',activeLink));
        </script>  
      </body>
      </html>
<?php }?>