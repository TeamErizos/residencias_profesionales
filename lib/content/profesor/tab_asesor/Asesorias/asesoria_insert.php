<?php
include("../../../../login/conexion/conectAWS.php");
include("../../view/header.php");
?>


    <!-- Título del HTML -->
    <h1>Asesorías</h1>

    <form action="insert_asesorias_alumnos.php" method="POST">
        <!-- Número de control -->
        <input type="hidden" name="no_control" value="<?php echo $_GET['no_control']; ?>">

        <!-- Tipo de Asesoría -->
        <p><h3>Elegir la Modalidad de la Asesoría</h3></p>
        <p>Presencial: <input type="radio" name="Tipo_Asesorias" id="Tipo_Asesorias" value="Presencial"></p>
        <p>Virtual: <input type="radio" name="Tipo_Asesorias" id="Tipo_Asesorias" value="Virtual"></p>
        <p><h5>*Si se eligió la modalidad "Presencial", especifique el lugar*</h5></p>
        <p>Lugar: <input type="text" size="50" id="Lugar_Asesoria" name="Lugar_Asesoria"></p>

        <!-- Temas a tratar -->
        <p><h3>Elegir los Temas a Tratar en la Asesoría</h3></p>
        <textarea cols="40" rows="5" wrap="physical" name="Temas_Asesoria" id="Temas_Asesoria"></textarea><br>

        <!-- Fecha y hora -->
        <p><h3>Elegir la Fecha</h3></p>
        <p>Elegir fecha: <input type="date" id="Fecha_Asesoria" name="Fecha_Asesoria"></p>
        
        <p><h3>Número de Asesoría</h3></p>
        <p><input type="text" name="Numero_Asesoria" id="Numero_Asesoria" pattern="[0-9]+" title="Ingrese solo números"></p>

        <!-- Botón -->
        <input type="submit" value="Confirmar">
    </form>
    
    <a href="asesorias_mastros_selecion.php?no_control=<?php echo $_GET['no_control']; ?>">Atrás</a>

<?php include("../../view/footer.php");?>