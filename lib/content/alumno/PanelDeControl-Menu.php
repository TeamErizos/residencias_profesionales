<?php include("view/header.php");?>

      <!-- tarjetas -->
      <!-- tarjetas -->
<?php 

// Esta función va determinar si se puede cargar el reporte final
// @@ input no_control y conexion
function verificarReporte($id_alumno, $pdo) {
  $consulta = "SELECT d.solicitud_de_residencia, d.reporte_final 
               FROM documentos AS d 
               INNER JOIN proyecto_x_alumno AS pxa ON d.id_proyecto_activo = pxa.id_p_x_a 
               WHERE pxa.id_alumno = :id_alumno";

  $stmt = $pdo->prepare($consulta);
  $stmt->bindParam(':id_alumno', $id_alumno);
  $stmt->execute();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $solicitud_de_residencia = $row['solicitud_de_residencia'];
      $reporte_final = $row['reporte_final'];

      if ($solicitud_de_residencia !== null && $reporte_final !== null) {
          return false;
      } elseif ($solicitud_de_residencia !== null && $reporte_final === null) {
          return true;
      }
  }

  return false;

}

function verificarSolicitud($id_alumno, $pdo) {
  $consulta = "SELECT solicitud_de_residencia 
               FROM documentos AS d 
               LEFT JOIN proyecto_x_alumno AS pxa ON d.id_proyecto_activo = pxa.id_p_x_a 
               WHERE pxa.id_alumno = :id_alumno";

  $stmt = $pdo->prepare($consulta);
  $stmt->bindParam(':id_alumno', $id_alumno);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row === false || $row['solicitud_de_residencia'] === null) {
      return true;
  }

  return false;
}




require "../../login/conexion/conectAWS.php";

?>
      
 
<div class="cardBox">
<?php if(verificarSolicitud($_SESSION['no_control'], $conn)){ ?>     
  <a href="solicitud_residencia/banco_proyecto.php">
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
  <?php } ?>
  <?php if(verificarReporte($_SESSION['no_control'], $conn)){?>
  <a href="carga_reporte/reporte_final.php">
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
  <?php } ?>

  <?php if(!verificarSolicitud($_SESSION['no_control'], $conn)){
            if(!verificarReporte($_SESSION['no_control'], $conn)){
               echo "<h4> Finalizado </h4>";
            }
    }?>

  </div>
</div>

<?php include("view/footer.php"); ?>

