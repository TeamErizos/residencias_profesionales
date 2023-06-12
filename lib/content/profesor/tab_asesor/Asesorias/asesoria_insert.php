<?php
include("../../../../login/conexion/conectAWS.php");
include("../../view/header.php");
?>


<!-- Título del HTML -->
<h4 class="tableTitle">Asesorías</h4>

<div class="containerSelector">
    <div class="selector-container">

        <form action="insert_asesorias_alumnos.php" method="POST">
            <!-- Número de control -->
            <input type="hidden" name="no_control" value="<?php echo $_GET['no_control']; ?>">

            <!-- Tipo de Asesoría -->
            <h3>Elegir la Modalidad de la Asesoría</h3>



            <label for="custom-label">
                <input type="radio" name="Tipo_Asesorias" id="Tipo_Asesorias" value=Presencial">
                <span>:Presencial</span>
            </label>

            <label for="custom-label">
                <input type="radio" name="Tipo_Asesorias" id="Tipo_Asesorias" value="Virtual">
                <span>:Virtual</span>
            </label>

            <label for="custom-label">

                <h3>Lugar (en caso de seleccionar Presencial)</h3>
            <div class="input-box">
                <input type="text" placeholder="Ingrese el lugar de la asesoria"size="50" id="Lugar_Asesoria" name="Lugar_Asesoria">
            </div>

                <span></span>


            </label>

            <!-- Temas a tratar -->

            <h3>Elegir los Temas a Tratar en la Asesoría</h3>

            <textarea cols="40" rows="5" wrap="physical" name="Temas_Asesoria" id="Temas_Asesoria"></textarea><br>

            <!-- Fecha y hora -->

            <h3>Elegir la Fecha</h3>

            <input type="date" id="Fecha_Asesoria" name="Fecha_Asesoria">

            <h3>Número de Asesoría</h3>
            <div class="input-box">
                <input type="text" placeholder="Ingrese un número" name="Numero_Asesoria" id="Numero_Asesoria"
                    pattern="[0-9]+" title="Ingrese solo números">
            </div>

            <!-- Botón -->
            <div class="button-containerForm">
            <input type="submit" value="Confirmar">
            </div>
        </form>
    </div>
</div>
<div class="button-containerForm" onclick="window.location.href='asesorias_mastros_selecion.php?no_control=<?php echo $_GET['no_control']; ?>'">
  <button class="button">
    <a class="white">Atrás</a>
  </button>
</div>


<?php include("../../view/footer.php"); ?>