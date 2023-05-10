<!-- Visible solo SI esta loggeado -->
<?php 
// Iniciar la sesión
session_start();
// Si no hay sesión, entonces...
if(!empty($_SESSION['id_profesor'])){?>
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
            <span class="infoTitle">Panel de Control
              Profesores y Coordinador<br></span>
            
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
            <span class="icon"><ion-icon name="document-text-outline"></ion-icon></span>
            <span class="title">Notificaciones</span>
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
        <!-- BOTON PARA CERRAR SESIÓN --->
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
  <a href="#">
    <div class="card">
      <div>
        <div class="numbers"></div>
        <div class="cardName">Seguimiento de Proyectos</div>
      </div>
      <div class="iconBx">
        <ion-icon name="mail-outline"></ion-icon>
      </div>
    </div>
  </a>

  <a href="#">
    <div class="card">
      <div>
        <div class="numbers"></div>
        <div class="cardName">Registro de Proyectos</div>
      </div>
      <div class="iconBx">
        <ion-icon name="document-outline"></ion-icon>
      </div>
    </div>
  </a>

  <a href="#">
    <div class="card">
      <div>
        <div class="numbers"></div>
        <div class="cardName">Revisión de Solicitudes</div>
      </div>
      <div class="iconBx">
        <ion-icon name="document-outline"></ion-icon>
      </div>
    </div>
  </a>

  
    </div>

    <div class="topbar">
      <div class="toggle2">
      </div>
      <!-- Titulo-->
      <div class="titulo">
        <label><span class="info">Tableros</span></label>
      </div>
      <div class="user"></div>
    </div>

    <!-- Tablero Asesor-->
    


    <div class="desplegableBox">
      <div class="desplegable-body">
        
      <div class="desplegable">
        <input type="text" class="textBoxDesplegable" 
        placeholder="Tablero Asesor" readonly>
        <div class="option">
          <a href="#">
            <div>Reportes Parciales</div>
          </a>
          <a href="#">
          <div>Evaluación y Seguimiento</div>
        </a>
        <a href="#">
          <div>Evaluación Reporte Final</div>
        </a>
          <a href="#">
          <div>Programador de Asesorias</div>
        </a>
        </div>
      </div>
    </div>

    <div class="desplegable-body">
        
      <div class="desplegable2">
        <input type="text" class="textBoxDesplegable" 
        placeholder="Tablero Coordinador" readonly>

        <div class="option">

          <a href="#">
            <div>Crear Dictamen</div>
          </a>
      
        </div>
      </div>
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

        //Activar menus desplegables
        let desplegable = document.querySelector('.desplegable');
        desplegable.onclick = function(){
        desplegable.classList.toggle('active');
      }

      let desplegable2 = document.querySelector('.desplegable2');
        desplegable2.onclick = function(){
        desplegable2.classList.toggle('active');
      }
      </script>  

      
    </body>
    </html>
<?php }?>