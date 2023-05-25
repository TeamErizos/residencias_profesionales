<?php include("view/header.php"); ?>

<!-- Corroborar SI existe el rol -->
<?php echo $_SESSION['user_rol']; ?>

      <!-- tarjetas -->
      <!-- tarjetas -->
<div class="cardBox">
  <a href="comision_asesor/lista_proyecto_asesor.php">
    <div class="card">
      <div>
        <div class="numbers"></div>
        <div class="cardName">Crear Comision de Asesor</div>
      </div>
      <div class="iconBx">
        <ion-icon name="document-attach-outline"></ion-icon>
      </div>
    </div>
  </a>

  <a href="#">
    <div class="card">
      <div>
        <div class="numbers"></div>
        <div class="cardName">Crear Comision de Revisión</div>
      </div>
      <div class="iconBx">
        <ion-icon name="document-attach-outline"></ion-icon>
      </div>
    </div>
  </a>
</div>

<?php include("view/footer.php"); ?> 