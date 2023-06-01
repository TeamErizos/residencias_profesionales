<?php

include("../../view/header.php");

// Recibir la clave del proyecto que necesita una comisión
// El resto de campos es autocalculado segun el proyecto

// LA CLAVE DEL ASESOR INTERNO (PROFESOR)
// SOLO SERÁ ACTUALIZADA SI SE CAMBIA DE ASESOR, DE NO SER ASÍ
// SE MANTIENE LA MISMA, PERO EL CAMBPO asesor_asignado DEBE
// VOLVERSE TRUE EN AMBOS CASOS

// Crear conexión con la base de datos y la clase
require "../../../../../login/conexion/conectAWS.php";
require "func_comision_asesor.php";

// Instancia de clase Asesor
$asesor = new Asesor($conn);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Acción para solicitudes GET
    if (isset($_GET['id_proyecto'])) {

        // Recuperar id del proyecto
        $id_proyecto = $_GET['id_proyecto'];

        $id_profesor = null;

        // Recuperar el nombre del que será asesor
        $nombre_asesor = $asesor->obtenerAsesorInterno($id_proyecto);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Acción para solicitudes POST
    if (isset($_POST['id_proyecto']) && isset($_POST['profesor'])) {

        // Recuperar el id del proyecto
        $id_proyecto = $_POST['id_proyecto'];

        // Recuperar el id del nuevo asesor
        $id_profesor = $_POST['profesor'];

        // Recuperar el nombre del que será asesor
        $nombre_asesor = $asesor->obtenerProfesor($id_profesor);
    } else {
        echo "no se encontro alguno de los datos";
    }
} else {
    // Acción para otros tipos de solicitudes
    echo "Tipo de solicitud no admitido";
}

// $id_proyecto y $nombre_asesor RECUPERADO

// Recuperar arreglo del proyecto (temporal)
$proyecto = $asesor->buscarProyecto($id_proyecto);

// Recuperar nombre de proyecto y llave foranea de empresa
$nombre_proyecto = $proyecto['nombre_proyecto'];
$fk_id_empresa = $proyecto['fk_id_empresa']; // (temporal)

// Recuperar nombre de la empresa
$nombre_empresa = $asesor->buscarEmpresa($fk_id_empresa);

// Recuperar numeros de control de los alumnos que participan en el proyecto
$no_controles = $asesor->buscarAlumnosDeProyecto($id_proyecto);

// Recuperar los nombres de los alumnos que están en el proyecto
$nombres_alumnos = $asesor->obtenerNombresAlumnos($no_controles);

// Recuperar los nombres de las carreras de los alumnos que participan en el proyecto
$nombres_carreras = $asesor->buscarNombresCarreras($no_controles);

// Recuperar el nombre del Departamento al que pertenece el asesor
$nombre_departamento = $asesor->obtenerNombreSubdireccionAcademica($id_proyecto);

?>

<!-- Form con todos los valores que deben mostrarse en la comision de asesor 
TODO: Este form ya recupera todos los valores requeridos, falta crear el guardado en word y pdf -->

<!-- AQUI PUEDES AGREGAR LO QUE HAGA FALTA PARA EL ESTILO -->
<div class="container-a">
  <div class="formContainer">
    <form class="formulario guardarForm" action="crear_comision_asesor.php" method="POST">
      <input type="hidden" name="id_proyecto" value="<?php echo $id_proyecto; ?>">
      <!-- Este será exclusivo del cambio de asesor -->
      <input type="hidden" name="id_profesor" value="<?php echo $id_profesor; ?>">

      <div class="content">
        <div class="input-box">
          <label>Número de Oficio:</label>
          <input type="text" name="numero_oficio">
        </div>

        <div class="input-box">
          <label for="fecha">Fecha:</label>
          <input type="text" id="fecha" name="fecha" value="<?php echo $asesor->obtenerFechaActual(); ?>" readonly>
        </div>

        <div class="input-box">
          <label for="lugar">Lugar:</label>
          <input type="text" id="lugar" name="lugar" placeholder="Ciudad, Estado">
        </div>
      </div>

      <div class="content">
        <div class="input-box">
          <label>Nombre Departamento:</label>
          <input type="text" name="nombre_departamento" value="<?php echo $nombre_departamento; ?>" readonly>
        </div>

        <div class="input-box">
          <label>Nombre Asesor:</label>
          <input type="text" name="nombre_asesor" value="<?php echo $nombre_asesor; ?>" readonly>
        </div>

        <div class="input-box">
          <label>Nombre Proyecto:</label>
          <input type="text" name="nombre_proyecto" value="<?php echo $nombre_proyecto; ?>" readonly>
        </div>
      </div>

      <div class="content">
        <div class="input-box">
          <label>Nombre Empresa:</label>
          <input type="text" name="nombre_empresa" value="<?php echo $nombre_empresa; ?>" readonly>
        </div>

        <div class="input-box">
          <label>Nombres de Alumnos:</label>
          <input type="text" name="nombres_alumnos" value="<?php echo implode(", ", $nombres_alumnos); ?>" readonly>
        </div>

        <div class="input-box">
          <label>Nombres de Carreras:</label>
          <input type="text" name="nombres_carreras" value="<?php echo implode(", ", $nombres_carreras); ?>" readonly>
        </div>
      </div>

      <div class="button-containerForm">
      <input type="submit" value="Enviar">
      </div>
    </form>
  </div>
</div>

<?php include("../../view/footer.php");
