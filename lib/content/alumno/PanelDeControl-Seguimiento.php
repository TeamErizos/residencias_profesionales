<?php 
include("view/header.php");
include_once('pdfDownloads.php'); 
require "../../login/conexion/conectAWS.php";

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
$id_p_x_a = $row['id_p_x_a'];

$query2 = "
        SELECT
        doc.solicitud_de_residencia,
        doc.carta_de_presentacion,
        doc.formato_de_convenio,
        doc.evaluacion_y_seguimiento,
        doc.evaluacion_reporte_final,
        doc.anteproyecto,
        doc.constancia_de_residencia,
        doc.reporte_final
        FROM documentos doc
        JOIN proyecto_x_alumno pa ON pa.id_p_x_a = doc.id_proyecto_activo
        WHERE doc.id_proyecto_activo = :id_proyecto_activo
    ";

$stmt2 = $conn->prepare($query2);
$stmt2->bindParam(':id_proyecto_activo', $id_p_x_a);
$stmt2->execute();
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
?>

      <!-- tarjetas -->
      <!-- tarjetas -->
<div class="cardBox">

  <?php 
      if ($row2['solicitud_de_residencia'] === null) 
      {
        // The field is NULL
        // Perform actions for NULL value
        ?>
        <a href="#">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Solicitud de Residencia</div>
            </div>
            <div class="iconBx">
              <ion-icon name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
      else 
      {
        // The field is not NULL
        // Perform actions for non-NULL value
        ?>
        <a href="downloadFiles.php" onclick="setCookieSolicitud(event, <?php echo $id_p_x_a; ?>)">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Solicitud de Residencia</div>
            </div>
            <div class="iconBx">
              <ion-icon style="color: #11d499;" name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
  ?>

  <?php 
      if ($row2['carta_de_presentacion'] === null) 
      {
        // The field is NULL
        // Perform actions for NULL value
        ?>
        <a href="#">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Carta de Presentación</div>
            </div>
            <div class="iconBx">
              <ion-icon name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
      else 
      {
        // The field is not NULL
        // Perform actions for non-NULL value
        ?>
        <a href="downloadFiles.php" onclick="setCookieCarta(event, <?php echo $id_p_x_a; ?>)">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Carta de Presentación</div>
            </div>
            <div class="iconBx">
              <ion-icon style="color: #11d499;" name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
  ?>

<?php 
      if ($row2['formato_de_convenio'] === null) 
      {
        // The field is NULL
        // Perform actions for NULL value
        ?>
        <a href="#">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Formato de Convenio</div>
            </div>
            <div class="iconBx">
              <ion-icon name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
      else 
      {
        // The field is not NULL
        // Perform actions for non-NULL value
        ?>
        <a href="downloadFiles.php" onclick="setCookieConvenio(event, <?php echo $id_p_x_a; ?>)">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Formato de Convenio</div>
            </div>
            <div class="iconBx">
              <ion-icon style="color: #11d499;" name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
  ?>

<?php 
      if ($row2['evaluacion_y_seguimiento'] === null) 
      {
        // The field is NULL
        // Perform actions for NULL value
        ?>
          <a href="#">
            <div class="card">
              <div>
                <div class="numbers"></div>
                <div class="cardName1">Evaluación y seguimiento</div>
              </div>
              <div class="iconBx">
                <ion-icon name="arrow-down-circle-outline"></ion-icon>
              </div>
            </div>
          </a>
        <?php
      } 
      else 
      {
        // The field is not NULL
        // Perform actions for non-NULL value
        ?>
        <a href="downloadFiles.php" onclick="setCookieEvalYSeg(event, <?php echo $id_p_x_a; ?>)">
          <div class="card">
              <div>
                <div class="numbers"></div>
                <div class="cardName1">Evaluación y seguimiento</div>
              </div>
              <div class="iconBx">
                <ion-icon style="color: #11d499;" name="arrow-down-circle-outline"></ion-icon>
              </div>
            </div>
          </a>
        <?php
      } 
  ?>

<?php 
      if ($row2['evaluacion_reporte_final'] === null) 
      {
        // The field is NULL
        // Perform actions for NULL value
        ?>
        <a href="#">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Evaluación Reporte Final</div>
            </div>
            <div class="iconBx">
              <ion-icon  name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
      else 
      {
        // The field is not NULL
        // Perform actions for non-NULL value
        ?>
        <a href="downloadFiles.php" onclick="setCookieEvalFinal(event, <?php echo $id_p_x_a; ?>)">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Evaluación Reporte Final</div>
            </div>
            <div class="iconBx">
              <ion-icon style="color: #11d499;" name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
  ?>

<?php 
      if ($row2['anteproyecto'] === null) 
      {
        // The field is NULL
        // Perform actions for NULL value
        ?>
        <a href="#">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Anteproyecto</div>
            </div>
            <div class="iconBx">
              <ion-icon name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
      else 
      {
        // The field is not NULL
        // Perform actions for non-NULL value
        ?>
        <a href="downloadFiles.php" onclick="setCookieAnteproyecto(event, <?php echo $id_p_x_a; ?>)">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Anteproyecto</div>
            </div>
            <div class="iconBx">
              <ion-icon style="color: #11d499;" name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
  ?>

<?php 
      if ($row2['constancia_de_residencia'] === null) 
      {
        // The field is NULL
        // Perform actions for NULL value
        ?>
        <a href="#">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Constancia de Residencia</div>
            </div>
            <div class="iconBx">
              <ion-icon name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
      else 
      {
        // The field is not NULL
        // Perform actions for non-NULL value
        ?>
        <a href="downloadFiles.php" onclick="setCookieCons(event, <?php echo $id_p_x_a; ?>)">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Constancia de Residencia</div>
            </div>
            <div class="iconBx">
              <ion-icon style="color: #11d499;" name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
  ?>

<?php 
      if ($row2['reporte_final'] === null) 
      {
        // The field is NULL
        // Perform actions for NULL value
        ?>
        <a href="#">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Reporte Final</div>
            </div>
            <div class="iconBx">
              <ion-icon name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
      else 
      {
        // The field is not NULL
        // Perform actions for non-NULL value
        ?>
        <a href="downloadFiles.php" onclick="setCookieReporFin(event, <?php echo $id_p_x_a; ?>)">
          <div class="card">
            <div>
              <div class="numbers"></div>
              <div class="cardName1">Reporte Final</div>
            </div>
            <div class="iconBx">
              <ion-icon style="color: #11d499;" name="arrow-down-circle-outline"></ion-icon>
            </div>
          </div>
        </a>
        <?php
      } 
  ?>
  
</div>
<script>
  //Funcion para descargar Carta de Presentacion
function setCookieCarta(event, id) {
  event.preventDefault();
  document.cookie = "cart=" + id + "; path=/";
  window.location.href = "downloadFiles.php";
}
  //Funcion para descargar Solicitud de Residencia
function setCookieSolicitud(event, id) {
  event.preventDefault();
  document.cookie = "soli=" + id + "; path=/";
  window.location.href = "downloadFiles.php";
}
  //Funcion para descargar Formato de Convenio
function setCookieConvenio(event, id) {
  event.preventDefault();
  document.cookie = "conv=" + id + "; path=/";
  window.location.href = "downloadFiles.php";
}
  //Funcion para descargar Evaluación y seguimiento
function setCookieEvalYSeg(event, id) {
  event.preventDefault();
  document.cookie = "seg=" + id + "; path=/";
  window.location.href = "downloadFiles.php";
}
  //Funcion para descargar Evaluación Reporte Final
function setCookieEvalFinal(event, id) {
  event.preventDefault();
  document.cookie = "fin=" + id + "; path=/";
  window.location.href = "downloadFiles.php";
}
  //Funcion para descargar Anteproyecto
function setCookieAnteproyecto(event, id) {
  event.preventDefault();
  document.cookie = "ante=" + id + "; path=/";
  window.location.href = "downloadFiles.php";
}
  //Funcion para descargar Constancia de Residencia
function setCookieCons(event, id) {
  event.preventDefault();
  document.cookie = "cons=" + id + "; path=/";
  window.location.href = "downloadFiles.php";
}
  //Funcion para descargar Reporte Final
function setCookieReporFin(event, id) {
  event.preventDefault();
  document.cookie = "reporFin=" + id + "; path=/";
  window.location.href = "downloadFiles.php";
}
</script>
    </div>

    <?php include("view/footer.php"); ?>