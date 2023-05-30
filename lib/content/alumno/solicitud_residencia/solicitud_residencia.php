<?php
/*

// Estas son las variables de sesión recuperadas del anterior archivo
------------------------------
$_SESSION['nombre_alumno']
$_SESSION['domicilio_alumno']
$_SESSION['ciudad_alumno']
$_SESSION['correo_alumno']
$_SESSION['telefono_alumno']
$_SESSION['seguro_medico_alumno']
$_SESSION['num_seguridad_social_alumno']

$_SESSION['id_proyecto']
$_SESSION['tipo_proyecto']
$_SESSION['origen_proyecto']
$_SESSION['periodo_proyecto']
$_SESSION['num_residentes']

$_SESSION['nombre_empresa']
$_SESSION['ramo_empresa']
$_SESSION['rfc_empresa']
$_SESSION['sector_empresa']
$_SESSION['actividad_principal']
$_SESSION['domicilio_empresa']
$_SESSION['ciudad_empresa']
$_SESSION['colonia_empresa']
$_SESSION['nombre_del_titular_de_empresa']
$_SESSION['puesto_titular'] 
$_SESSION['codigo_postal']
$_SESSION['fax_empresa']
$_SESSION['tel_empresa']

$_SESSION['nombre_asesor_externo']
$_SESSION['puesto_asesor_externo']

ASÍ SE PONE EL DATO DENTRO DEL INPUT
<input type="text" value="<?php echo $_SESSION['nombre_variable']; ?>">


--------------------------------------------------------------------------
Y estas son las funciones:

recuperarDatosAlumno: Esta función recupera los datos del alumno a partir de su número de control 
y los guarda en variables de sesión. Regresa la clave de la carrera del alumno.

recuperarNombreCarrera: Esta función recupera el nombre de la carrera a partir de su clave y lo regresa.

recuperarDatosProyecto: Esta función recupera los datos del proyecto a partir de su nombre y 
los guarda en variables de sesión. Regresa la clave del profesor responsable del proyecto.

recuperarNombreProfesor: Esta función recupera el nombre completo del profesor a partir de su clave y lo regresa.

recuperarDatosEmpresa: Esta función recupera los datos de la empresa a partir del nombre del proyecto y los guarda
 en variables de sesión. No regresa ningún dato.


*/

// Insertar el dashboard
include("../view/header.php");
//session_start();

// llamar la conexión
require "../../../login/conexion/conectAWS.php";
require "resources/funciones_solicitud.php";

// Crear instancia del alumno
$alumno = new Alumno($conn);

// $_SESSION['no_control'] = "20390292"; // Este esta ahora en la base de datos
$_SESSION['nombre_proyecto'] = $_GET['pro']; // Este será pasado mediante una lista

// datos del alumno y regresar el id de carrera
$id_carrera = $alumno->recuperarDatosAlumno($_SESSION['no_control']);

// nombre de la carrera del alumno
$_SESSION['nombre_carrera'] = $alumno->recuperarNombreCarrera($id_carrera);

// datos del proyecto y regresar el id del profesor
$id_profesor = $alumno->recuperarDatosProyecto($_SESSION['nombre_proyecto']);

// buscar el nombre del profesor y regresarlo
$_SESSION['nombre_profe'] = $alumno->recuperarNombreProfesor($id_profesor);

// datos de la empresa segun el proyecto
// este no regresa nada
$alumno->recuperarDatosEmpresa($_SESSION['nombre_proyecto']);

// buscar al asesor externo
$alumno->recuperarAsesorExterno($_SESSION['id_proyecto']);


?>


<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device=width, initial-scale=1.0">
  <title>Banco de Proyectos</title>
</head>







    <!-- main -->
    <div class="menu">
      <div class="topbar">
    
        <!-- busqueda -->
        <div class="titulo">
          
        </div> 
        <!-- Imagen de usuario -->
        <div class="user">
          <!-- <img src="user.jpg">                                                 POSIBLE IMPLEMENTACION-->
        </div>
      </div>

      <!-- tarjetas -->
      <!-- tarjetas -->

      <main class="table slide-in">

<section class="table__header">
          <div class="tit">
            <h1></h1>
          </div>
          <div class="p1">
            <h1>DATOS DE SOLICITUD DE RESIDENCIA</h1>
          </div>

          <div class="cambioPagina">
            <label for="cambio-pagina" onclick="Atras()" class="cambio__pagina-btn" title="Atrás"></label>
            <label for="cambio-pagina" onclick="Adelante()" class="cambio__pagina-btn1" title="Adelante"></label>
          </div>
        </section>



<form action="resources/guardar_solicitud.php" method="post" enctype="multipart/form-data">
 





<section class="table__body slider-item" id="table1" >


<div class="containerForm">
  <form action="" method="post">

    <div class ="content">
      <div class="containerForm">
<form action="" method="post">


<div class="content">
<div class="input-box full-width">
<!-- Datos del Proyecto -->
  <div>
    <h3>Datos del Proyecto</h3>
    <br>
    <!-- Nombre del proyecto -->
    <div class="input-box">
      <label for="project_name"  >Nombre del proyecto:</label>
      <!-- Este no es variable de sesión -->
      <input type="text" value="<?php echo $_SESSION['nombre_proyecto']; ?>" id="project_name" name="project_name"
        disabled>
    </div>

    <!-- Tipo de Proyecto -->
    <div class="input-box">
      <label for="project_type">Tipo de Proyecto:</label>
      <input type="text" value="<?php echo $_SESSION['tipo_proyecto']; ?>" id="project_type" name="project_type"
        disabled>
    </div>

    <!-- Opcion elegida -->
    <div class="input-box">
      <label for="selected_option" >Opcion elegida:</label>
      <input type="text" value="<?php echo $_SESSION['origen_proyecto']; ?>" id="selected_option" name="selected_option"
        disabled>
    </div>

    <!-- Periodo proyectado -->
    <div class="input-box">
      <label for="projected_period">Periodo proyectado:</label>
      <input type="text" value="<?php echo ($alumno->getPeriodo()); ?>" id="projected_period" name="projected_period"
        disabled>
    </div>

    <!-- Nombre del asesor interno -->
    <div class="input-box">
      <!-- esta no es variable de sesión -->
      <label for="internal_advisor">Nombre del asesor interno:</label>
      <input type="text" value="<?php echo $_SESSION['nombre_profe']; ?>" id="internal_advisor" name="internal_advisor"
        disabled>
    </div>

    <!-- Numero de residentes -->
    <div class="input-box">
      <label for="num_residents">Numero de residentes:</label>
      <input type="text" value="<?php echo $_SESSION['num_residentes']; ?>" id="num_residents" name="num_residents"
        disabled>
    </div>
    </div>
    </div>
  </form>
</div>


              </form>
            </div>

          </section>










          <section class="table__body slider-item" id="table2">
  <div class="containerForm">
    <form action="" method="post">
      <div class="content">
        <div class="input-box full-width">
          <!-- Datos de la empresa -->
          <div class="column">

  
    <h3>Datos de la empresa</h3>
    <br>
    <!-- Nombre de la empresa -->
    <div class="input-box">
      <label for="company_name">Nombre de la empresa:</label>
      <input type="text" value="<?php echo $_SESSION['nombre_empresa']; ?>" id="company_name" name="company_name"
        disabled>
    </div>

    <!-- Ramo -->
    <div class="input-box">
      <label for="branch">Ramo:</label>
      <input type="text" value="<?php echo $_SESSION['ramo_empresa']; ?>" id="branch" name="branch" disabled>
    </div>

    <!-- RFC -->
    <div class="input-box">
      <label for="rfc">RFC:</label>
      <input type="text" value="<?php echo $_SESSION['rfc_empresa']; ?>" id="rfc" name="rfc" disabled>
    </div>

    <!-- Sector -->
    <div class="input-box">
      <label for="sector">Sector:</label>
      <input type="text" value="<?php echo $_SESSION['sector_empresa']; ?>" id="sector" name="sector" disabled>
    </div>

    <!-- Actividad principal -->
    <div class="input-box">
      <label for="main_activity">Actividad principal:</label>
      <input type="text" value="<?php echo $_SESSION['sector_empresa']; ?>" id="main_activity" name="main_activity"
        disabled>
    </div>

    <!-- Domicilio -->
    <div class="input-box">
      <label for="address">Domicilio:</label>
      <input type="text" value="<?php echo $_SESSION['domicilio_empresa']; ?>" id="address" name="address" disabled>
    </div>

    <!-- Colonia -->
    <div class="input-box">
      <label for="colony">Colonia:</label>
      <input type="text" value="<?php echo $_SESSION['colonia_empresa']; ?>" id="colony" name="colony" disabled>
    </div>

    <!-- Codigo Postal -->
    <div class="input-box">
      <label for="cp">CP:</label>
      <input type="text" value="<?php echo $_SESSION['codigo_postal']; ?>" id="cp" name="cp" disabled>
    </div>


    <div class="column">
            <div id="required_data">
    <!-- FAX -->
    <div class="input-box">
      <label for="fax">Fax:</label>
      <input type="text" value="<?php echo $_SESSION['fax_empresa']; ?>" id="fax" name="fax" disabled>
    </div>

    <!-- Ciudad -->
    <div class="input-box" >
      <label for="city">Ciudad:</label>
      <input type="text" value="<?php echo $_SESSION['ciudad_empresa']; ?>" id="city" name="city" disabled>
    </div>

    <!-- Telefono -->
    <div class="input-box">
      <label for="phone">Telefono:</label>
      <input type="text" value="<?php echo $_SESSION['tel_empresa']; ?>" id="phone" name="phone" disabled>
    </div>

    <!-- Nombre del titular de la empresa -->
    <div class="input-box">
      <label for="company_holder">Nombre del titular de la empresa:</label>
      <input type="text" value="<?php echo $_SESSION['nombre_del_titular_de_empresa']; ?>" id="company_holder"
        name="company_holder" disabled>
    </div>

    <!-- Puesto -->
    <div class="input-box">
      <label for="position">Puesto:</label>
      <input type="text" value="<?php echo $_SESSION['puesto_titular']; ?>" id="position" name="position" disabled>
    </div>
  </div>

    <!-- Nombre del asesor externo -->
    <div class="input-box">
      <label for="external_advisor">Nombre del asesor externo:</label>
      <input type="text" id="external_advisor" name="external_advisor"
        value="<?php echo $_SESSION['nombre_asesor_externo']; ?>" disabled>
    </div>

    <!-- Puesto del asesor externo -->
    <div class="input-box">
      <label for="external_advisor_position">Puesto del asesor externo:</label>
      <input type="text" id="external_advisor_position" name="external_advisor_position"
        value="<?php echo $_SESSION['puesto_asesor_externo']; ?>" disabled>
    </div>

    <!-- Nombre de la persona que firmará el acuerdo -->
    <div class="input-box">
      <label for="agreement_signer">Nombre de la persona que firmará el acuerdo:</label>
      <input type="text" id="agreement_signer" name="agreement_signer">
    </div>

    <!-- Puesto de la persona que firmará el acuerdo -->
    <div class="input-box">
      <label for="agreement_signer_position">Puesto de la persona que firmará el acuerdo:</label>
      <input type="text" id="agreement_signer_position" name="agreement_signer_position">
      </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>









          <section class="table__body slider-item" id="table3" >



  <form action="" method="post">

    <div class ="content">
      <div class="containerForm">
<form action="" method="post">


<div class="content">
<div class="input-box full-width">
  <!-- Datos del Alumno -->
  <div>
    <h3>Datos del Alumno</h3>

    <br>
    <!-- Nombre del alumno -->
    <div class="input-box">
      <label for="student_name">Nombre del alumno:</label>
      <input type="text" value="<?php echo $_SESSION['nombre_alumno']; ?>" id="student_name" name="student_name"
        disabled>
    </div>

    <!-- Carrera -->
    <div class="input-box">
      <label for="career">Carrera:</label>
      <input type="text" value="<?php echo $_SESSION['nombre_carrera']; ?>" id="career" name="career" disabled>
    </div>

    <!-- No. de control -->
    <div class="input-box">
      <label for="control_num">Numero de control:</label>
      <input type="text" value="<?php echo $_SESSION['no_control']; ?>" id="control_num" name="control_num" disabled>
    </div>

    <!-- Domicilio -->
    <div class="input-box">
      <label for="student_address">Domicilio:</label>
      <input type="text" value="<?php echo $_SESSION['domicilio_alumno']; ?>" id="student_address" name="student_address"
        disabled>
    </div>

    <!-- Email -->
    <div class="input-box">
      <label for="student_email">Email:</label>
      <input type="email" value="<?php echo $_SESSION['correo_alumno']; ?>" id="student_email" name="student_email"
        disabled>
    </div>

    <!-- Ciudad -->
    <div class="input-box">
      <label for="student_city">Ciudad:</label>
      <input type="text" value="<?php echo $_SESSION['ciudad_alumno']; ?>" id="student_city" name="student_city"
        disabled>
    </div>

    <!-- Telefono -->
    <div class="input-box">
      <label for="student_phone">Telefono:</label>
      <input type="text" value="<?php echo $_SESSION['telefono_alumno']; ?>" id="student_phone" name="student_phone"
        disabled>
    </div>

    <!-- Tipo de seguro -->
    <div class="input-box">
      <label for="insurance_type">Tipo de seguro:</label>
      <input type="text" value="<?php echo $_SESSION['seguro_medico_alumno']; ?>" id="insurance_type"
        name="insurance_type" disabled>
    </div>

    <!-- Numero de seguro social -->
    <div class="input-box">
      <label for="social_security_num">Numero de seguro social:</label>
      <input type="text" value="<?php echo $_SESSION['num_seguridad_social_alumno']; ?>" id="social_security_num"
        name="social_security_num" disabled>
    </div>

    <!-- Semestre a cursar -->
    <div class="input-box">
      <label for="semester">Semestre a cursar:</label>
      <input type="text" id="semester" name="semester">
    </div>
    </div>
    <!-- Espacios para cargar envios de archivos -->
    <!-- Cargar Anteproyecto -->
   <h3>Cargar anteproyecto</h3>
<div id="dropzone" style="border: 2px dashed #ccc; padding: 20px; text-align: center;">
  <p>Arrastra y suelta el archivo aquí, o haz clic para seleccionarlo.</p>
  <input type="file" id="fileInput" name="anteproyecto" style="display: none;">
</div>

<script>
  // Obtener el elemento de la zona de arrastrar y soltar
  var dropzone = document.getElementById('dropzone');

  // Agregar eventos para controlar el arrastre y soltar
  dropzone.addEventListener('dragover', handleDragOver, false);
  dropzone.addEventListener('dragleave', handleDragLeave, false);
  dropzone.addEventListener('drop', handleFileSelect, false);

  // Agregar evento para controlar el clic en la zona de arrastrar y soltar
  dropzone.addEventListener('click', function() {
    document.getElementById('fileInput').click();
  });

  // Controlador para el evento de arrastre sobre la zona de arrastrar y soltar
  function handleDragOver(event) {
    event.stopPropagation();
    event.preventDefault();
    event.dataTransfer.dropEffect = 'copy'; // Establecer el efecto de copia
    dropzone.style.background = '#f2f2f2';
  }

  // Controlador para el evento de salida del arrastre de la zona de arrastrar y soltar
  function handleDragLeave(event) {
    event.stopPropagation();
    event.preventDefault();
    dropzone.style.background = '#ffffff';
  }

  // Controlador para el evento de soltar un archivo en la zona de arrastrar y soltar
  function handleFileSelect(event) {
    event.stopPropagation();
    event.preventDefault();
    dropzone.style.background = '#ffffff';

    var files = event.dataTransfer.files; // Obtener los archivos soltados

    // Manejar los archivos
    handleFiles(files);
  }

  // Controlador para el evento de selección de archivo
  document.getElementById('fileInput').addEventListener('change', function(event) {
    var files = event.target.files; // Obtener los archivos seleccionados

    // Manejar los archivos
    handleFiles(files);
  });

  // Función para manejar los archivos
  function handleFiles(files) {
    // Recorrer los archivos y realizar las acciones necesarias
    for (var i = 0; i < files.length; i++) {
      var file = files[i];
      // Realizar acciones con el archivo, como mostrar su nombre, tamaño, etc.
      console.log('Archivo seleccionado:', file.name);
    }
  }
</script>











    <!-- Cargar Constancia de Residencia -->
   
    <h3>Cargar constancia de residencia</h3>
<div id="dropzone" style="border: 2px dashed #ccc; padding: 20px; text-align: center;">
  <p>Arrastra y suelta el archivo aquí, o haz clic para seleccionarlo.</p>
  <input type="file" id="fileInput" name="constancia" style="display: none;">
</div>

<script>
  // Obtener el elemento de la zona de arrastrar y soltar
  var dropzone = document.getElementById('dropzone');

  // Agregar eventos para controlar el arrastre y soltar
  dropzone.addEventListener('dragover', handleDragOver, false);
  dropzone.addEventListener('dragleave', handleDragLeave, false);
  dropzone.addEventListener('drop', handleFileSelect, false);

  // Agregar evento para controlar el clic en la zona de arrastrar y soltar
  dropzone.addEventListener('click', function() {
    document.getElementById('fileInput').click();
  });

  // Controlador para el evento de arrastre sobre la zona de arrastrar y soltar
  function handleDragOver(event) {
    event.stopPropagation();
    event.preventDefault();
    event.dataTransfer.dropEffect = 'copy'; // Establecer el efecto de copia
    dropzone.style.background = '#f2f2f2';
  }

  // Controlador para el evento de salida del arrastre de la zona de arrastrar y soltar
  function handleDragLeave(event) {
    event.stopPropagation();
    event.preventDefault();
    dropzone.style.background = '#ffffff';
  }

  // Controlador para el evento de soltar un archivo en la zona de arrastrar y soltar
  function handleFileSelect(event) {
    event.stopPropagation();
    event.preventDefault();
    dropzone.style.background = '#ffffff';

    var files = event.dataTransfer.files; // Obtener los archivos soltados

    // Manejar los archivos
    handleFiles(files);
  }

  // Controlador para el evento de selección de archivo
  document.getElementById('fileInput').addEventListener('change', function(event) {
    var files = event.target.files; // Obtener los archivos seleccionados

    // Manejar los archivos
    handleFiles(files);
  });

  // Función para manejar los archivos
  function handleFiles(files) {
    // Recorrer los archivos y realizar las acciones necesarias
    for (var i = 0; i < files.length; i++) {
      var file = files[i];
      // Realizar acciones con el archivo, como mostrar su nombre, tamaño, etc.
      console.log('Archivo seleccionado:', file.name);
    }
  }
</script>

    
  </div>

  <!-- Submit button -->
  <div class="input-box">
    <input type="submit" class="enviar" value="Enviar  ">
  </div>
  
  </form>
</div>


              </form>
            </div>

          </section>


<script src="/residencias_profesionales/lib/content/alumno/view/slider.js"></script>  
<?php include("../view/footer.php"); ?>