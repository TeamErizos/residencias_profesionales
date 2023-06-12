<?php
// espera 5 segundos antes de redireccionar a la página "Lista.php"
//header("Refresh: 2; url=Lista.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Verificar si se recibieron los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el índice 'p_x_a_id' existe en el array $_POST antes de acceder a él.
    if (isset($_POST['p_x_a_id'])) {
        $id_p_x_a = $_POST['p_x_a_id'];
    } else {
        echo "No se recibió el valor 'p_x_a_id' por POST";
        exit;
    }

    // $id_p_x_a = $_POST['p_x_a_id'];
    $_SESSION['p_x_a_id'] = $id_p_x_a;


    // Importar Librerias y conexion
    include_once('../../../../../pdf/tbs_class.php');
    include_once('../../../../../pdf/plugins/tbs_plugin_opentbs.php');
    require "../../../../login/conexion/conectAWS.php";
    include_once 'insert_calif.php';

    // Instanciar clase 
    $calificaciones = new Calificaciones($conn);

    // Crear carpetas que no existen
    createFoldersIfNotExist();

    // Obtener los datos del alumno
    $datos_alumnos = $calificaciones->obtenerDatosAlumnos($id_p_x_a);
    if ($datos_alumnos === false) {
        echo "obtenerDatosAlumnos no devolvió resultados";
        exit;
    }
    // Obtener los datos individuales del array de datos del alumno
    $nombre_alumno = $datos_alumnos[0]['nombre_alumno'];
    $ape1_alumno = $datos_alumnos[0]['ape1_alumno'];
    $ape2_alumno = $datos_alumnos[0]['ape2_alumno'];
    $no_control = $datos_alumnos[0]['no_control'];
    $nombre_proyecto = $datos_alumnos[0]['nombre_proyecto'];


    $datos_todo = $calificaciones->obtenerDatosTodo($id_p_x_a);
    if ($datos_todo === false) {
        echo "obtenerDatosTodo no devolvió resultados";
        exit;
    }

    $nom_carrera = $datos_todo['nom_carrera'];
    $periodo_0_sem = $datos_todo['periodo_0_sem'];

    //asesor externo
    $nom_asesor_ext = $datos_todo['nom_asesor_externo'];
    $ape1_asesor_ex = $datos_todo['ape1_asesor_externo'];
    $ape2_asesor_ex = $datos_todo['ape2_asesor_externo'];
    //asesor interno
    $nom_asesor_int = $datos_todo['nom_profesor'];
    $ape1_asesor_in = $datos_todo['ape1_profesor'];
    $ape2_asesor_in = $datos_todo['ape2_profesor'];

    $fechaHoyEp1 = date('Y-m-d');
    $fechaHoyIp1 = date('Y-m-d');
    $fechaHoyEp2 = date('Y-m-d');
    $fechaHoyIp2 = date('Y-m-d');

    // Instanciar librerias
    $TBS = new clsTinyButStrong;
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

    // Obtener el promedio de las calificaciones
    $resultados = $calificaciones->obtenerPromedioCalificaciones($id_p_x_a);

    //Cargando template
    $template = '../../../../../pdf/templates/Evaluacion_Seguimiento.docx';


    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

    // Insertar datos en el archivo
    $TBS->MergeField('eva.nombreResidente', $nombre_alumno);
    $TBS->MergeField('eva.apeRe1', $ape1_alumno);
    $TBS->MergeField('eva.apeRe2', $ape2_alumno);
    $TBS->MergeField('eva.noControl', $no_control);
    $TBS->MergeField('eva.nombreProyecto', $nombre_proyecto);
    $TBS->MergeField('eva.programaEducativo', $nom_carrera);
    $TBS->MergeField('eva.periodoResidencia', $periodo_0_sem);

    $TBS->MergeField('eva.nomAsesorE', $nom_asesor_ext);
    $TBS->MergeField('eva.ape1AseE', $ape1_asesor_ex);
    $TBS->MergeField('eva.ape2AseE', $ape2_asesor_ex);

    $TBS->MergeField('eva.nomAsesorI', $nom_asesor_int);
    $TBS->MergeField('eva.ape1AseI', $ape1_asesor_in);
    $TBS->MergeField('eva.ape2AseI', $ape2_asesor_in);

  
    $TBS->MergeField('eva.fechaE1P', $fechaHoyEp1);
    $TBS->MergeField('eva.fechaE2P', $fechaHoyEp2);
    $TBS->MergeField('eva.fechaI1P', $fechaHoyIp1);
    $TBS->MergeField('eva.fechaI2P', $fechaHoyIp2);

    $calif_inter_p1 = $resultados['sumaInterno_p1'];
    $TBS->MergeField('eva.I1PF', $calif_inter_p1);

    $calif_exter_p1 = $resultados['sumaExterno_p1'];
    $TBS->MergeField('eva.E1PF', $calif_exter_p1);
    
    $calif_inter_p2 = $resultados['sumaInterno_p2'];
    $TBS->MergeField('eva.I2PF', $calif_inter_p2);

    $calif_exter_p2 = $resultados['sumaExterno_p2'];
    $TBS->MergeField('eva.E2PF', $calif_exter_p2);

    $resultado = $calificaciones->obtenerCalificaciones($id_p_x_a);

    $array_externo_p1 = $resultado['calificaciones_externo_p1']; // Guardar el array del asesor externo p1
    $array_interno_p1 = $resultado['calificaciones_interno_p1']; // Guardar el array del asesor interno p1
    $array_externo_p2 = $resultado['calificaciones_externo_p2']; // Guardar el array del asesor externo p2
    $array_interno_p2 = $resultado['calificaciones_interno_p2']; // Guardar el array del asesor interno p2

    // calificaciones asesor externo p1
    for ($i = 0; $i < count($array_externo_p1); $i++) {
        $campo = 'eva.E1P' . ($i + 1);
        $TBS->MergeField($campo, $array_externo_p1[$i]);
    }
    // calificaciones asesor interno p1
    for ($i = 0; $i < count($array_interno_p1); $i++) {
        $campo = 'eva.I1P' . ($i + 1);
        $TBS->MergeField($campo, $array_interno_p1[$i]);
    }

     // calificaciones asesor externo
     for ($i = 0; $i < count($array_externo_p2); $i++) {
        $campo = 'eva.E2P' . ($i + 1);
        $TBS->MergeField($campo, $array_externo_p2[$i]);
    }
    // calificaciones asesor interno
    for ($i = 0; $i < count($array_interno_p2); $i++) {
        $campo = 'eva.I2P' . ($i + 1);
        $TBS->MergeField($campo, $array_interno_p2[$i]);
    }


    // Verificar si el promedio fue calculado correctamente  //p1
    if (isset($resultados['promedio_p1'])) {
        // El promedio
        $promedio_p1 = $resultados['promedio_p1'];

        // Reemplazar el campo en el documento con el promedio
        $TBS->MergeField('eva.promP1', $promedio_p1);
    } else {
        // Campo en el documento a un valor predeterminado
        $TBS->MergeField('eva.promP1', 'N/A');
    }



    // Verificar si el promedio fue calculado correctamente     //p2
    if (isset($resultados['promedio_p2'])) {
        // El promedio
        $promedio_p2 = $resultados['promedio_p2'];

        // Reemplazar el campo en el documento con el promedio
        $TBS->MergeField('eva.promP2', $promedio_p2);
    } else {
        // Campo en el documento a un valor predeterminado
        $TBS->MergeField('eva.promP2', 'N/A');
    }


    // Verificar si el promedio fue calculado correctamente
    if (isset($resultados['promedio'])) {
        // El promedio
        $promedio = $resultados['promedio'];

        // Reemplazar el campo en el documento con el promedio
        $TBS->MergeField('eva.promedioFinal', $promedio);
    } else {
        // Campo en el documento a un valor predeterminado
        $TBS->MergeField('eva.promedioFinal', 'N/A');
    }


    /* --------------------------------------------------------------------------------- */

    /* DATOS GUARDADOS, CREAR ARCHIVO WORD */

    // Crear nuevo archivo 
    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as']) !== '') && ($_SERVER['SERVER_NAME'] == 'localhost')) ? trim($_POST['save_as']) : '';
    // Cada archivo tendrá el no de control 
    $output_file_name = $id_p_x_a;
    if ($save_as === '') {

        // Se guardará de manera temporal, después se borrará
        $ruta_guardado = 'Docs/' . $output_file_name . ".docx";
        $TBS->Show(OPENTBS_FILE, $ruta_guardado);
    } else {

        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
    }


    /* DATOS ACTUALIZADOS, CREAR E INSERTAR PDF */

    // Crear pdf y recuperar la direccion del archivo
    $pdf_address = $calificaciones->createPDF($id_p_x_a);
    //echo $pdf_address;

    // Insertar pdf
        $calificaciones->insertarEvaRepoFinal($id_p_x_a, $pdf_address);

    // Borrar todos los archivo
    $calificaciones->deleteFiles($id_p_x_a);

    // Redirigir a la pagina de inicio
    $calificaciones->descargarReporteFinal($id_p_x_a);

    // Si todo el proceso acabo correctamete, regresar al dashboard
    header("Location: http://localhost/residencias_profesionales");
    exit();
} else {
    echo "No se recibieron datos por POST";
}

        // Crear las carpetas si no existen
        function createFoldersIfNotExist() {
            $folders = ['Pdfs', 'Docs'];

            foreach ($folders as $folder) {
                if (!is_dir($folder)) {
                    mkdir($folder);
                }
            }
        }
