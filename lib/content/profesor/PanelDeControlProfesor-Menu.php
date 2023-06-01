<?php include("view/header.php");?>
      <!-- tarjetas -->
      <!-- tarjetas -->
<div class="cardBox">
  <a href="seguimiento/seguimiento_proyecto.php">
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

  <a href="registro_proyecto/select_carreras.php">
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

  <a href="revision_solicitud/lista_solicitudes_pendientes.php">
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
          <a href="tab_asesor/EvaluacionYSeguimiento.php">
          <div>Evaluación y Seguimiento</div>
        </a>
        <a href="tab_asesor/Ev.R.Final/Lista.php">
          <div>Evaluación Reporte Final</div>
        </a>
          <a href="tab_asesor/Asesorias/asesorias_main.php">
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

          <a href="dictamen_coordinador/dictamen.php">
            <div class="opcionDesplegable">Crear Dictamen</div>
          </a>
      
        </div>
      </div>
    </div>

  </div>

<?php include("view/footer.php"); ?>
