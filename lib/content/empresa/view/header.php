<?php
// Iniciar la sesión
session_start();
// Verificar la existencia de la sesión o la cookie de inicio de sesión
if (!isset($_SESSION['id_empresa'])) {
  // Redirigir al usuario a la página de inicio de sesión
  header("Location: http://localhost/residencias_profesionales/");
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard </title>
  <link rel="stylesheet" type="text/css" href="/residencias_profesionales/lib/content/empresa/view/style.css">
</head>
<body>
  <div class="container">
    <div class="navigation">
      <ul>
        <li>
          <a href="#">
            <span class="icon"><ion-icon name="school-outline"></ion-icon></span>
            <span class="infoTitle">Panel de Control
              Asesor Externo<br></span>
            
          </a>
        </li>
        
        <li class="hovered">
         <a href="/residencias_profesionales/lib/content/empresa/PanelDeControlAsesorExterno-Menu.php">
            <span class="icon"><ion-icon name="grid-outline"></ion-icon></span>
            <span class="title">Menu</span>
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