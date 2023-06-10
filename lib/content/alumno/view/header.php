<?php
// Iniciar la sesión
session_start();
// Verificar la existencia de la sesión o la cookie de inicio de sesión
if (!isset($_SESSION['no_control'])) {
  // Redirigir al usuario a la página de inicio de sesión
  header("Location: http://localhost/residencias_profesionales/");
}

// Establish a PDO connection
try {
  $dsn = "pgsql:host=database-1.ce6k0ybbwxvv.us-east-2.rds.amazonaws.com;port=5432;dbname=residencia;user=postgres;password=ballena21";
  $conn = new PDO($dsn);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Failed to connect to the database: " . $e->getMessage();
  exit;
}

$no_control = $_SESSION['no_control'];

$query = "
        SELECT id_p_x_a
        FROM proyecto_x_alumno
        WHERE id_alumno = :no_control
    ";

$stmt = $conn->prepare($query);
$stmt->bindParam(':no_control', $no_control);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Access the value of the 'id_p_x_a' column in the fetched row
$valueToCheck = $row['id_p_x_a'];

// Searches if alumno is in the table documentos
$query2 = "SELECT EXISTS(SELECT 1 FROM documentos WHERE id_proyecto_activo = :valueToCheck)";
$stmt2 = $conn->prepare($query2);
$stmt2->bindParam(':valueToCheck', $valueToCheck);
$stmt2->execute();
$rowExists = $stmt2->fetchColumn();

?>

<!DOCTYPE html>
<html>
<head>  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard </title>
  <link rel="stylesheet" type="text/css" href="/residencias_profesionales/lib/content/alumno/view/Panel_style.css">
  <link rel="stylesheet" type="text/css" href="/residencias_profesionales/lib/content/alumno/view/FAQstyle.css">
  <link rel="stylesheet" type="text/css" href="/residencias_profesionales/lib/content/alumno/view/Solitude_style.css">
  <link rel="stylesheet" type="text/css" href="/residencias_profesionales/lib/content/alumno/view/table.css">
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

        <!-- Condicional para habilitar o no el boton "Seguimiento dependiendo si el alumno existe en documentos o no"-->
        <?php
          if ($rowExists === 't' || $rowExists === true) {
            ?>
            <li class="expand">
              <a href="/residencias_profesionales/lib/content/alumno/PanelDeControl-Seguimiento.php">
                <span class="icon"><ion-icon name="document-text-outline"></ion-icon></span>
                <span class="title">Seguimiento</span>
              </a>
            </li>
            <?php
          } 
          else 
          {
            ?>
            <li class="expand">
              <a href="#">
                <span class="icon"><ion-icon name="document-text-outline"></ion-icon></span>
                <span class="title">Seguimiento</span>
              </a>
            </li>
            <?php
          }
        ?>

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
            <span class="info"></span><!-- Fué elminado el texto que decia "Menu" -->
          </label>
        </div> 
        <!-- Imagen de usuario -->
        <div class="user">
          <!-- <img src="user.jpg">                                                 POSIBLE IMPLEMENTACION-->
        </div>
      </div>