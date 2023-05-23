
<?php include("../view/header.php");?>

<!-- Condición 
    El usuario que registra debe de seleccionar las 
    carreras de interes para el proyecto
-->
    
<div class="containerForm">
<form method="post" action="select_new_asesor.php">

<div class="input-checkbox">

<!-- RadioButton de las carreras escogibles -->

</br>

<h3>Selecciona las carreras que te interesen:</h3>

</br>

    <input type="checkbox" name="carrera[]" value="373436" id="IA">
    <label for="IA">Ingeniería en Administración</label><br>

</br>

    <input type="checkbox" name="carrera[]" value="407567" id="LA">
    <label for="LA">Licenciatura en Administración</label><br>

</br>

    <input type="checkbox" name="carrera[]" value="743202" id="LT">
    <label for="LT">Licenciatura en Turismo</label><br>

</br>

    <input type="checkbox" name="carrera[]" value="902922" id="LB">
    <label for="LB">Licenciatura en Biología</label><br>
   
</br>

    <input type="checkbox" name="carrera[]" value="906829" id="A">
    <label for="A">Arquitectura</label><br>

</br>

    <input type="checkbox" name="carrera[]" value="897879" id="IC">
    <label for="IC">Ingeniería Civil</label><br>

</br>

    <input type="checkbox" name="carrera[]" value="696443" id="CP">
    <label for="CP">Contador Público</label><br>

</br>

    <input type="checkbox" name="carrera[]" value="297376" id="IE">
    <label for="IE">Ingeniería Eléctrica</label><br>

</br>

    <input type="checkbox" name="carrera[]" value="279083" id="IGE">
    <label for="IGE">Ingeniería en Gestión Empresarial</label><br>

</br>

    <input type="checkbox" name="carrera[]" value="106261" id="ISC">
    <label for="ISC">Ingeniería en Sistemas Computacionales</label><br>

</br>

    <input type="checkbox" name="carrera[]" value="174429" id="ITIC">
    <label for="ITIC">Ingeniería en Tecnologías de la Información y Comunicaciones</label><br>

    <?php

        // Establecer una cookie con el mismo nombre y un tiempo de expiración pasado
        //setcookie('nombre_seleccionado', '', time() - 3600);
        //setcookie('clave_profesor', '', time() - 3600);
        // La cookie se eliminará del navegador cuando se reciba la respuesta del servidor
        // Esto con el objetivo de limpiar el nombre y el id del profesor


    ?>

    <div class="button-container">
        <button type="submit" value="Enviar">Enviar</button>
    </div>

</br>

</div>    

<!-- Después de seleccionar, guardar las carreras seleccionadas como cookies -->

</form>
</div>

<?php include("../view/footer.php");?>
