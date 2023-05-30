<?php
    include_once('pdf.php'); 
    include_once('../pdf/tbs_class.php'); 
    include_once('../pdf/plugins/tbs_plugin_opentbs.php');
    require "../lib/login/conexion/conectAWS.php";

    // TODO: CAMBIAR RUTAS DEL HEADER ->

    //Cookie para direccion del Word
    $template_path = $_COOKIE['path'];
    //Cookie para data generica
    $data = $_COOKIE['data'];

    //Cookie para data generica
    setcookie('data', '', time() - 60, '/');

    //Cookie para direccion del Word
    setcookie('path', '', time() - 60, '/');

    $deserialized_data = json_decode($data, true);

    $Template = new \clsTinyButStrong;
    $Template->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

    $Template->LoadTemplate($template_path);

    // Merge the data into the template
    $Template->MergeBlock('block1', $deserialized_data);

    //Proceso para dictamen
    if(isset($_COOKIE['num_dic'])) 
    {
        // Instanciar clase Asesor
        $dicta = new Dictamen($conn);

        //Cookie especifica para dictamen
        $num = $_COOKIE['num_dic'];

        setcookie('num_dic', '', time() - 60, '/');

        $numero = json_decode($num, true);

        $Template->MergeBlock('block2', $numero);

        // Crear nuevo archivo
        $Template->PlugIn(OPENTBS_DELETE_COMMENTS);

        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        // Cada archivo tendrá el no de proyecto x alumno
        $output_file_name = 'dictamen_anteproyecto';
        if ($save_as==='') 
        {
            // Se guardará de manera temporal, después se borrará
            $ruta_guardado = 'doc/' . $output_file_name . ".docx";
            $Template->Show(OPENTBS_FILE, $ruta_guardado);
        } 
        else 
        {
            $Template->Show(OPENTBS_DOWNLOAD, $output_file_name); 
        }

        // Crear pdf y recuperar la direccion del archivo
        $pdf_address = $dicta -> createPDFDict('dictamen_anteproyecto');

        // Borrar todos los archivo
        deleteFiles('dictamen_anteproyecto');
        
        // Si todo el proceso acabo correctamete, regresar al dashboard
        header("Location: ../index.php");
        exit(); 
    }

    //Proceso para carta de presentacion
    if(isset($_COOKIE['carta'])) 
    {
        // Instanciar clase Asesor
        $carta = new Carta($conn);

        //Cookie especifica para dictamen
        $car = $_COOKIE['carta'];

        setcookie('carta', '', time() - 60, '/');

        // Crear nuevo archivo
        $Template->PlugIn(OPENTBS_DELETE_COMMENTS);

        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        // Cada archivo tendrá el no de proyecto x alumno
        $output_file_name = $car;
        if ($save_as==='') 
        {
            // Se guardará de manera temporal, después se borrará
            $ruta_guardado = 'doc/' . $output_file_name . ".docx";
            $Template->Show(OPENTBS_FILE, $ruta_guardado);
        } 
        else 
        {
            $Template->Show(OPENTBS_DOWNLOAD, $output_file_name); 
        }
        
        // Crear pdf y recuperar la direccion del archivo
        $pdf_address = createPDF($car);

        // Insertar pdf
        $carta->insertarCarta($car, $pdf_address);

        // Borrar todos los archivo
        deleteFiles($car);

        // Redirigir a la pagina de inicio
        $carta->descargarCarta($car);
     
        // Si todo el proceso acabo correctamete, regresar al dashboard
        header("Location: ../index.php");
        exit(); 
    }

    //Proceso para comision de revisor
    if(isset($_COOKIE['com_rev'])) 
    {
        // Instanciar clase Asesor
        $comi = new Com_Rev($conn);

        //Cookie especifica para dictamen
        $com_rev = $_COOKIE['com_rev'];

        setcookie('com_rev', '', time() - 60, '/');

        // Crear nuevo archivo
        $Template->PlugIn(OPENTBS_DELETE_COMMENTS);

        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        // Cada archivo tendrá el no de proyecto x alumno
        $output_file_name = $com_rev;
        if ($save_as==='') 
        {
            // Se guardará de manera temporal, después se borrará
            $ruta_guardado = 'doc/' . $output_file_name . ".docx";
            $Template->Show(OPENTBS_FILE, $ruta_guardado);
        } 
        else 
        {
            $Template->Show(OPENTBS_DOWNLOAD, $output_file_name); 
        }
        
        // Crear pdf y recuperar la direccion del archivo
        $pdf_address = createPDF($com_rev);

        // Insertar pdf
        $comi->insertarComRev($com_rev, $pdf_address);

        // Borrar todos los archivo
        deleteFiles($com_rev);

        // Redirigir a la pagina de inicio
        $comi->descargarComRev($com_rev);

        
        // Si todo el proceso acabo correctamete, regresar al dashboard
        header("Location: ../index.php");
        exit(); 
    }

    //Proceso para carta de convenio
    if(isset($_COOKIE['conv'])) 
    {
        // Instanciar clase Asesor
        $conve = new Conv($conn);

        //Cookie especifica para dictamen
        $car_con = $_COOKIE['conv'];

        setcookie('conv', '', time() - 60, '/');

        // Crear nuevo archivo
        $Template->PlugIn(OPENTBS_DELETE_COMMENTS);

        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        // Cada archivo tendrá el no de proyecto x alumno
        $output_file_name = $car_con;
        if ($save_as==='') 
        {
            // Se guardará de manera temporal, después se borrará
            $ruta_guardado = 'doc/' . $output_file_name . ".docx";
            $Template->Show(OPENTBS_FILE, $ruta_guardado);
        } 
        else 
        {
            $Template->Show(OPENTBS_DOWNLOAD, $output_file_name); 
        }
        
        // Crear pdf y recuperar la direccion del archivo
        $pdf_address = createPDF($car_con);

        // Insertar pdf
        $conve->insertarConvenio($car_con, $pdf_address);

        // Borrar todos los archivo
        deleteFiles($car_con);

        // Redirigir a la pagina de inicio
        $conve->descargarConvenio($car_con);

        
        // Si todo el proceso acabo correctamete, regresar al dashboard
        header("Location: ../index.php");
        exit(); 
    }
?>