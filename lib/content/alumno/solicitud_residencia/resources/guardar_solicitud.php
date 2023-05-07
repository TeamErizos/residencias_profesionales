<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recibir los archivos
        $anteproyecto = $_FILES['anteproyecto'];
        $constancia = $_FILES['constancia'];
      
        $anteproyecto_extension = pathinfo($anteproyecto['name'], PATHINFO_EXTENSION);
        $constancia_extension = pathinfo($constancia['name'], PATHINFO_EXTENSION);
      
        // Validar si son extensión pdf

        if($anteproyecto_extension != "pdf" || $constancia_extension != "pdf"){
          echo "Solo se permiten archivos en formato PDF";
        }else{

                // Procesar los datos del POST y las cookies

                // Importar Librerias
                include_once('../../../../../pdf/tbs_class.php'); 
                include_once('../../../../../pdf/plugins/tbs_plugin_opentbs.php');
                require "../../../../login/conexion/conectAWS.php";
                
                // Funciones de archivos
                require "funciones_archivos.php";
                require "funciones_solicitud.php";

                // Instanciar la clase documentos
                $documentos = new Documentos($conn);
                $alumno = new Alumno($conn);

                // Iniciar la sesión
                session_start();

                // PARAMETROS

                // Mover los archivos a una ubicación precisa
                move_uploaded_file($anteproyecto['tmp_name'], 'project/' . $_SESSION['no_control'] . "a.pdf");
                move_uploaded_file($constancia['tmp_name'], 'project/' . $_SESSION['no_control'] . "c.pdf");
          
                // firmante del convenio
                $agreement_signer = $_POST['agreement_signer'];
                // puesto del firmente
                $agreement_signer_position = $_POST['agreement_signer_position'];
                // semestre del alumno
                $semester = $_POST['semester'];

                
                // Instanciar librerias
                $TBS = new clsTinyButStrong; 
                $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); 

                /*
                // Estas son las variables de sesión recuperadas del anterior archivo
                ------------------------------
                    

                $_SESSION['nombre_alumno']
                $_SESSION['no_control']
                $_SESSION['nombre_carrera']
                $_SESSION['domicilio_alumno']
                $_SESSION['ciudad_alumno']
                $_SESSION['correo_alumno']
                $_SESSION['telefono_alumno']
                $_SESSION['seguro_medico_alumno']
                $_SESSION['num_seguridad_social_alumno']

                 $_SESSION['id_proyecto']
                $_SESSION['nombre_proyecto']
                $_SESSION['tipo_proyecto']
                $_SESSION['origen_proyecto']
                $_SESSION['periodo_proyecto']
                $_SESSION['num_residentes']
                $_SESSION['nombre_profe']

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
                
                */

                // Recuperar los datos de la solicitud y generar el Formato de Solicitud

                //Cargando template
                $template = 'solicitud_residencia.docx';
                $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
                
                //Escribir Nuevos campos

                // Encabezado
                /*$TBS->MergeField('soli.fecha', );
                $TBS->MergeField('soli.coordinador', );
                $TBS->MergeField('soli.jefeDivEstudiosProfesionales', );
                $TBS->MergeField('soli.carreraCoordi', );*/

                // Encabezado
                
                // Proyecto
                $TBS->MergeField('soli.nombreProyecto', $_SESSION['nombre_proyecto']);
                getSolicitudType($_SESSION['tipo_proyecto'], $TBS);
                getProposalCode($_SESSION['origen_proyecto'], $TBS);
                $TBS->MergeField('soli.periodoProyectado', $alumno->getPeriodo());
                $TBS->MergeField('soli.asesorInterno', $_SESSION['nombre_profe']);
                $TBS->MergeField('soli.nr', $_SESSION['num_residentes']);

                // Empresa
                $TBS->MergeField('soli.nombreEmpresa', $_SESSION['nombre_empresa']);
                getCompanyBranch($_SESSION['ramo_empresa'], $TBS);
                $TBS->MergeField('soli.rfc', $_SESSION['rfc_empresa']);
                getCompanySector($_SESSION['sector_empresa'], $TBS);
                $TBS->MergeField('soli.actividadEmpresa', $_SESSION['actividad_principal']);
                $TBS->MergeField('soli.domicilioEmpresa', $_SESSION['domicilio_empresa']);
                $TBS->MergeField('soli.Colonia', $_SESSION['colonia_empresa']);
                $TBS->MergeField('soli.cp', $_SESSION['codigo_postal']);
                $TBS->MergeField('soli.fax', $_SESSION['fax_empresa']);
                $TBS->MergeField('soli.Ciudad', $_SESSION['ciudad_empresa']);
                $TBS->MergeField('soli.telefono', $_SESSION['tel_empresa']);
                $TBS->MergeField('soli.titularEmpresa', $_SESSION['nombre_del_titular_de_empresa']);
                $TBS->MergeField('soli.puestoTitular', $_SESSION['puesto_titular']);
                $TBS->MergeField('soli.asesorExterno', $_SESSION['nombre_asesor_externo']);
                $TBS->MergeField('soli.puestoAsesor', $_SESSION['puesto_asesor_externo']);
                $TBS->MergeField('soli.nombreFirmante', $agreement_signer);
                $TBS->MergeField('soli.puestoFirmante', $agreement_signer_position);

                // Residente
                $TBS->MergeField('soli.nombreAlumno', $_SESSION['nombre_alumno']);
                $TBS->MergeField('soli.carrera', $_SESSION['nombre_carrera']);
                $TBS->MergeField('soli.nocon', $_SESSION['no_control']);
                $TBS->MergeField('soli.sem', $semester);
                $TBS->MergeField('soli.domicilio', $_SESSION['domicilio_alumno']);
                $TBS->MergeField('soli.email', $_SESSION['correo_alumno']);
                getStudentInsurance($_SESSION['seguro_medico_alumno'], $TBS);
                $TBS->MergeField('soli.nss', $_SESSION['num_seguridad_social_alumno']);
                $TBS->MergeField('soli.ciudad', $_SESSION['ciudad_alumno']);
                $TBS->MergeField('soli.telefonoAlumno', $_SESSION['telefono_alumno']);

                // Firma del estudiante

            
                // Crear nuevo archivo de Solicitud de Residencia
                $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

                $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
                // Cada archivo tendrá el no de control del alumno
                $output_file_name = $_SESSION['no_control'];
                if ($save_as==='') {

                    // Se guardará de manera temporal, después se borrará
                    $ruta_guardado = 'doc/' . $output_file_name . ".docx";
                    $TBS->Show(OPENTBS_FILE, $ruta_guardado);
                    
                } else {

                    $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); 

                }

                // Una vez creado el archivo, insertar registro de este alumno en proyecto_alumno
                $alumno->insertarProyectoXAlumno($_SESSION['id_proyecto'], $_SESSION['no_control'], $alumno->getPeriodo());

                // Ahora, con el id alumno crear un registro del mismo en documentos_alumno
                $alumno->insertarDocumentosPorAlumno($_SESSION['no_control']);

                // Convertir a pdf - recibe el No de Control
                $pdf_address = $documentos->createPDF($_SESSION['no_control']); // recuperar la direccion del pdf

                // Buscar el proyecto_activo segun el no_control del alumno
                $id_proyecto_activo = $documentos->getIdProyectoActivo($_SESSION['no_control']);

                // subir solicitud a la base de datos
                $documentos->insertarSolicitudDeResidencia($id_proyecto_activo, $pdf_address);

                // Crear direcciones para los pdfs de [A]nteproyecto y [C]onstancia 
                $addressAnteproyecto = "project/" . $_SESSION['no_control'] . "a.pdf";
                $addressConstancia = "project/" . $_SESSION['no_control'] . "c.pdf";

                // subir la constancia y el anteproyecto
                $documentos->insertarAnteproyecto($id_proyecto_activo, $addressAnteproyecto);
                $documentos->insertarConstanciaDeResidencia($id_proyecto_activo, $addressConstancia);

                // eliminar todos los archivos temporales segun la clave del alumno
                $documentos->deleteFiles($_SESSION['no_control']);


                //------------------------------------------------------------------------------------------------------------
                // Después de crear el archivo:
                // x 1. Convertirlo a pdf  
                // x 2. Subirlo a la base de datos
                // x 3. Si la subida fue exitosa. borrar ambos archivos
                // ? 4. Subir los datos prudentes a la tabla (ProyectosXAlumno)
                // ? 5. con el id de ProyectosXAlumno, crear el registro de Documentos (en al solicitud se hace eso, una funcion que cree una row en DocXAlumno)
                // x 6. En documentos, subir la constancia y el anteproyecto


            
            
        }

    } else{
        echo "Error: Falta información para procesar la solicitud";
    }


    // Función para marcar el tipo de solicitud 
            // Y limpiar las opciones rechazadas
            function getSolicitudType($type, $TBS) {
                // Usamos un switch para comparar el valor de $tipo
                switch ($type) {
                    // Si $tipo es "Interno", marcamos "soli.int"
                    case "Interno":
                        $TBS->MergeField('soli.int','X');

                        // Limpiar las opciones no seleccionadas
                        $TBS->MergeField('soli.ext', ' ');
                        $TBS->MergeField('soli.dual', ' ');
                        $TBS->MergeField('soli.ciie', ' ');                                
                        break;
                    
                    // Si $tipo es "Externo", marcamos "soli.ext"
                    case "Externo":
                        $TBS->MergeField('soli.ext', 'X');

                        // Limpiar las opciones no seleccionadas
                        $TBS->MergeField('soli.int', ' ');
                        $TBS->MergeField('soli.dual', ' ');
                        $TBS->MergeField('soli.ciie', ' ');   

                        break;
                    
                    // Si $tipo es "Dual", marcamos "soli.dual"
                    case "Dual":
                        $TBS->MergeField('soli.dual', 'X');

                        // Limpiar las opciones no seleccionadas
                        $TBS->MergeField('soli.int', ' ');
                        $TBS->MergeField('soli.ext', ' ');
                        $TBS->MergeField('soli.ciie', ' ');  
                        break;
                    
                    // Si $tipo es "CIIE", marcamos "soli.ciie"
                    case "CIIE":
                        $TBS->MergeField('soli.ciie', 'X');

                        // Limpiar las opciones no seleccionadas
                        $TBS->MergeField('soli.int', ' ');
                        $TBS->MergeField('soli.ext', ' ');
                        $TBS->MergeField('soli.dual', ' ');  
                        break;
                    
                    // Si $tipo no coincide con ningún caso, devolvemos una cadena vacía
                    default:
                        return "";
                        break;
                }
            }
            

                // Funcion para marcar el tipo de propuesta
                // Y limpiar las opciones rechazadas
                function getProposalCode($proposal, $TBS) {
                    // Verificamos el tipo de propuesta que se está proporcionando
                    switch ($proposal) {
                        case "Propuesta propia":
                            // Si es Propuesta propia, marcamos el código "pp"
                            $TBS->MergeField('pp', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('pt', ' ');
                            $TBS->MergeField('bp', ' ');
                            break;
                            
                        case "Trabajador":
                            // Si es Trabajador, marcamos el código "pt"
                            $TBS->MergeField('pt', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('pp', ' ');
                            $TBS->MergeField('bp', ' ');
                            break;
                            
                        case "Banco de Proyectos":
                            // Si es Banco de Proyectos, marcamos el código "bp"
                            $TBS->MergeField('bp', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('pp', ' ');
                            $TBS->MergeField('pt', ' ');
                            break;
                            
                        default:
                            // Si no es ninguno de los tres tipos mencionados, regresamos un string vacío
                            return "";
                            break;
                    }
                }
                

                // Funcion para marcar el ramo de la Empresa
                // Y limpiar las opciones rechazadas
                function getCompanyBranch($branch, $TBS) {
                    // Verificamos el tipo de propuesta que se está proporcionando
                    switch ($branch) {
                        case "Industrial":
                            // Si es Industrial, marcar el codigo "soli.ind"
                            $TBS->MergeField('soli.ind', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('soli.ser', ' ');
                            $TBS->MergeField('soli.otro', ' ');
                            break;
                            
                        case "Servicios":
                            // Si es Servicios, marcar el codigo "soli.ser"
                            $TBS->MergeField('soli.ser', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('soli.ind', ' ');
                            $TBS->MergeField('soli.otro', ' ');
                            break;
                            
                        case "Otro":
                            // Si es Industrial, marcar el codigo "soli.ind"
                            $TBS->MergeField('soli.otro', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('soli.ind', ' ');
                            $TBS->MergeField('soli.ser', ' ');
                            break;
                            
                        default:
                            // Si no es ninguno de los tres tipos mencionados, regresamos un string vacío
                            return "";
                            break;
                    }
                }

                // Funcion para marcar el sector de la Empresa
                // Y limpiar las opciones rechazadas
                function getCompanySector($sector, $TBS) {
                    // Verificamos el tipo de propuesta que se está proporcionando
                    switch ($sector) {
                        case "Publico":
                            // Si es Público, marcar el codigo "soli.publico"
                            $TBS->MergeField('soli.publico', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('soli.privado', ' ');
                            break;
                            
                        case "Privado":
                            // Si es Privado, marcar el codigo "soli.privado"
                            $TBS->MergeField('soli.privado', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('soli.publico', ' ');
                            break;
                            
                        default:
                            // Si no es ninguno de los dos tipos mencionados, regresamos un string vacío
                            return "";
                            break;
                    }
                }

                // Funcion para marcar el ramo de la Empresa
                // Y limpiar las opciones rechazadas
                function getStudentInsurance($insurance, $TBS) {
                    // Verificamos el tipo de propuesta que se está proporcionando
                    switch ($insurance) {
                        case "IMSS":
                            // Si es IMSS, marcar el codigo "s.1"
                            $TBS->MergeField('s.1', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('s.2', ' ');
                            $TBS->MergeField('s.3', ' ');
                            break;
                            
                        case "ISSSTE":
                            // Si es ISSSTE, marcar el codigo "s.2"
                            $TBS->MergeField('s.2', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('s.1', ' ');
                            $TBS->MergeField('s.3', ' ');
                            break;
                            
                        case "OTROS":
                            // Si es OTROS, marcar el codigo "s.3"
                            $TBS->MergeField('s.3', 'X');
                            
                            // Limpiamos las opciones NO escogidas
                            $TBS->MergeField('s.1', ' ');
                            $TBS->MergeField('s.2', ' ');
                            break;
                            
                        default:
                            // Si no es ninguno de los tres tipos mencionados, regresamos un string vacío
                            return "";
                            break;
                    }

                }

    
    
?>