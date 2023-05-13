<?php


// Verificar si se recibieron los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $id_proyecto = $_POST['id_proyecto'];
    $nombre_asesor = $_POST['nombre_asesor'];
    $nombre_proyecto = $_POST['nombre_proyecto'];
    $nombre_empresa = $_POST['nombre_empresa'];
    $nombres_alumnos = $_POST['nombres_alumnos'];
    $nombres_carreras = $_POST['nombres_carreras'];
    $nombre_departamento = $_POST['nombre_departamento'];

        // Campo concatenado unico
        $fecha = $_POST['fecha'];
        $lugar = $_POST['lugar'];

    // Concatenar la fecha y el lugar
    $lugar_fecha = $lugar . " al " . $fecha;
    
    // Obtener el número de oficio enviado (el unico capturado)
    $num_oficio = $_POST['numero_oficio'];

    // Verificar si se recibió el valor de id_profesor
    if (isset($_POST['id_profesor']) && !empty($_POST['id_profesor'])) {
        $id_profesor = $_POST['id_profesor'];
    }

    // Datos requerios por el archivo obtenidos, rellenar archivo...

     // Importar Librerias y conexion
     include_once('../../../../../../pdf/tbs_class.php'); 
     include_once('../../../../../../pdf/plugins/tbs_plugin_opentbs.php');
     require "../../../../../login/conexion/conectAWS.php";
     require "func_comision_asesor.php";

     // Instanciar librerias
     $TBS = new clsTinyButStrong; 
     $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); 

     // Instanciar clase Asesor
     $asesor = new Asesor($conn);

     //Cargando template
     $template = 'asignacion_asesor.docx';
     $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

     // Insertar datos en el archivo

        //  departamento
    $TBS->MergeField('form.dep', $nombre_departamento);

        // numero del oficio
    $TBS->MergeField('form.noOficio', $num_oficio);
        
        // lugar y fecha donde se emite el oficio
    $TBS->MergeField('form.lugarFecha', $lugar_fecha);

        // nombre asesor
    $TBS->MergeField('form.nombreProfesorAsesor', $nombre_asesor);

        // nombre de los residentes    
    $TBS->MergeField('form.nombreResidente', $nombres_alumnos);

        // nombre de las carreras
    $TBS->MergeField('form.nombreCarrera', $nombres_carreras);

        // nombre del proyecto
    $TBS->MergeField('form.nombreProyecto', $nombre_proyecto);

        // periodo de realizacion
    $TBS->MergeField('form.periodoProyecto', $asesor->getPeriodo());

        // nombre de la empresa
    $TBS->MergeField('form.empresaProyecto', $nombre_empresa);

/* --------------------------------------------------------------------------------- */

/* DATOS GUARDADOS, CREAR ARCHIVO WORD */

    // Crear nuevo archivo de comision de Asesor
    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
    // Cada archivo tendrá el no de control del alumno
    $output_file_name = $id_proyecto;
    if ($save_as==='') {

        // Se guardará de manera temporal, después se borrará
        $ruta_guardado = 'doc/' . $output_file_name . ".docx";
        $TBS->Show(OPENTBS_FILE, $ruta_guardado);
        
    } else {

        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); 

    }

/* --------------------------------------------------------------------------------- */

/* WORD CREADO, ACTUALIZAR BASE DE DATOS */

    // Determinar si existe la variable id_profesor
    if (isset($id_profesor)) {
        // Si existe, actualizar la tabla asesor_proyecto
        $asesor->actualizarAsesorInterno($id_proyecto, $id_profesor);

    } 

    // Cambiar el valor de asesor_asignado a TRUE
    $asesor->comisionNoRequerida($id_proyecto); // Ya no aparecerá este proyecto en la lista principal


/* --------------------------------------------------------------------------------- */

/* DATOS ACTUALIZADOS, CREAR E INSERTAR PDF */

    // Crear pdf y recuperar la direccion del archivo
    $pdf_address = $asesor->createPDF($id_proyecto);

    // Insertar pdf
    $asesor->insertarComisionAsesor($id_proyecto, $pdf_address);

    // Borrar todos los archivo
    $asesor->deleteFiles($id_proyecto);

    // Redirigir a la pagina de inicio
    $asesor->descargarAnteproyecto($id_proyecto);

    // Si todo el proceso acabo correctamete, regresar al dashboard
    header("Location: ../../PanelDeControlJefeDepartamento-Menu.php");
    exit(); 



} else {
    echo "No se recibieron datos por POST";
}


?>