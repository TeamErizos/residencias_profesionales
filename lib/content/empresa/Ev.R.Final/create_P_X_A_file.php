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
    include_once('../../../../pdf/tbs_class.php');
    include_once('../../../../pdf/plugins/tbs_plugin_opentbs.php');
    require "../../../login/conexion/conectAWS.php";
    include_once 'insert_calif.php';

    // Instanciar clase 
    $calificaciones = new Calificaciones($conn);


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

    $fechaHoyE = date('Y-m-d');
    $fechaHoyI = date('Y-m-d');

    // Instanciar librerias
    $TBS = new clsTinyButStrong;
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

    // Obtener el promedio de las calificaciones
    $resultados = $calificaciones->obtenerPromedioCalificaciones($id_p_x_a);

    //Cargando template
    $template = '../../../../pdf/templates/Evaluación_Reporte_Final.docx';


    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

    // Insertar datos en el archivo
    $TBS->MergeField('evaf.nombreResidente', $nombre_alumno);
    $TBS->MergeField('evaf.apeRe1', $ape1_alumno);
    $TBS->MergeField('evaf.apeRe2', $ape2_alumno);
    $TBS->MergeField('evaf.noCon', $no_control);
    $TBS->MergeField('evaf.nombreProyecto', $nombre_proyecto);
    $TBS->MergeField('evaf.programaEducativo', $nom_carrera);
    $TBS->MergeField('evaf.periodoResidencia', $periodo_0_sem);

    $TBS->MergeField('evaf.nomAsesorE', $nom_asesor_ext);
    $TBS->MergeField('evaf.ape1AseE', $ape1_asesor_ex);
    $TBS->MergeField('evaf.ape2AseE', $ape2_asesor_ex);

    $TBS->MergeField('evaf.nomAsesorI', $nom_asesor_int);
    $TBS->MergeField('evaf.ape1AseI', $ape1_asesor_in);
    $TBS->MergeField('evaf.ape2AseI', $ape2_asesor_in);

  
    $TBS->MergeField('evaf.fechaE', $fechaHoyE);
    $TBS->MergeField('evaf.fechaI', $fechaHoyI);

    $calif_inter = $resultados['sumaInterno'];
    $TBS->MergeField('evaf.sumI', $calif_inter);

    $calif_exter = $resultados['sumaExterno'];
    $TBS->MergeField('evaf.sumE', $calif_exter);


    $resultado = $calificaciones->obtenerCalificaciones($id_p_x_a);

    $array_externo = $resultado['calificaciones_externo']; // Guardar el array del asesor externo
    $array_interno = $resultado['calificaciones_interno']; // Guardar el array del asesor interno

    // calificaciones asesor externo
    for ($i = 0; $i < count($array_externo); $i++) {
        $campo = 'evaf.e' . ($i + 1);
        $TBS->MergeField($campo, $array_externo[$i]);
    }


    // calificaciones asesor interno
    for ($i = 0; $i < count($array_interno); $i++) {
        $campo = 'evaf.i' . ($i + 1);
        $TBS->MergeField($campo, $array_interno[$i]);
    }



    // Verificar si el promedio fue calculado correctamente
    if (isset($resultados['promedio'])) {
        // El promedio
        $promedio = $resultados['promedio'];

        // Reemplazar el campo en el documento con el promedio
        $TBS->MergeField('evaf.promedio', $promedio);
    } else {
        // Campo en el documento a un valor predeterminado
        $TBS->MergeField('evaf.promedio', 'N/A');
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
