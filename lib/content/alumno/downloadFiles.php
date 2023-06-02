<?php
    include_once('pdfDownloads.php'); 
    require "../../login/conexion/conectAWS.php";

    $descarga = new Downloads($conn);

    //Proceso para Carta de Residencia
    if(isset($_COOKIE['cart'])) 
    {
        //Cookie especifica para Carta de Residencia
        $doc = $_COOKIE['cart'];

        setcookie('cart', '', time() - 60, '/');

        $descarga->descargarCarta($doc);

        $descarga->deleteFiles('carta_de_presentacion');
    }

    //Proceso para Solicitud de Residencia
    if(isset($_COOKIE['soli'])) 
    {
        //Cookie especifica para Solicitud de Residencia
        $doc = $_COOKIE['soli'];

        setcookie('soli', '', time() - 60, '/');

        $descarga->descargarSolicitud($doc);

        $descarga->deleteFiles('solicitud_de_residencia');
    }

    //Proceso para Formato de Convenio
    if(isset($_COOKIE['conv'])) 
    {
        //Cookie especifica para Formato de Convenio
        $doc = $_COOKIE['conv'];

        setcookie('conv', '', time() - 60, '/');

        $descarga->descargarConvenio($doc);

        $descarga->deleteFiles('formato_de_convenio');
    }

    //Proceso para Evaluación y seguimiento
    if(isset($_COOKIE['seg'])) 
    {
        //Cookie especifica para Evaluación y seguimiento
        $doc = $_COOKIE['seg'];

        setcookie('seg', '', time() - 60, '/');

        $descarga->descargarEval($doc);

        $descarga->deleteFiles('evaluacion_y_seguimiento');
    }

    //Proceso para Evaluación Reporte Final
    if(isset($_COOKIE['fin'])) 
    {
        //Cookie especifica para Evaluación Reporte Final
        $doc = $_COOKIE['fin'];

        setcookie('fin', '', time() - 60, '/');

        $descarga->descargarEvalReporteFinal($doc);

        $descarga->deleteFiles('evaluacion_reporte_final');
    }

    //Proceso para Anteproyecto
    if(isset($_COOKIE['ante'])) 
    {
        //Cookie especifica para Anteproyecto
        $doc = $_COOKIE['ante'];

        setcookie('ante', '', time() - 60, '/');

        $descarga->descargarAnte($doc);

        $descarga->deleteFiles('anteproyecto');
    }

    //Proceso para Constancia de Residencia
    if(isset($_COOKIE['cons'])) 
    {
        //Cookie especifica para Constancia de Residencia
        $doc = $_COOKIE['cons'];

        setcookie('cons', '', time() - 60, '/');

        $descarga->descargarConstancia($doc);

        $descarga->deleteFiles('constancia_de_residencia');
    }

    //Proceso para Reporte Final
    if(isset($_COOKIE['reporFin'])) 
    {
        //Cookie especifica para Reporte Final
        $doc = $_COOKIE['reporFin'];

        setcookie('reporFin', '', time() - 60, '/');

        $descarga->descargarReporteFinal($doc);

        $descarga->deleteFiles('reporte_final');
    }

    // Si todo el proceso acabo correctamete, regresar al dashboard
    header("Location: PanelDeControl-Seguimiento.php");
    exit();
?>