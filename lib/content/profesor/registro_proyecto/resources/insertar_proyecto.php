<?php

// Incluir el archivo que contiene la clase Proyecto & conexión
require 'funciones_proyecto.php';
require "../../../../login/conexion/conectAWS.php";


// Crear una instancia de la clase Proyecto
$proyecto = new Proyecto($conn);

    // Verifica si se han enviado los datos del formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Almacena los valores en variables
        $NombreProyecto = $_POST['NombreProyecto'];

        $ObjetivoGeneral = $_POST['ObjetivoGeneral'];
        
        $DescripcionProyecto = $_POST['DescripcionProyecto'];
        
        $ImpactoProyecto = $_POST['ImpactoProyecto'];
        
        $TipoProyecto = $_POST['TipoProyecto'];
        
        $OpcionProyecto = $_POST['OpcionProyecto'];
        
        $NumResidentes = $_POST['NumResidentes'];
        
        $id_empresa = $_POST['empresa_seleccionada'];

        $nombreExterno = $_POST["nombreExterno"];
        
        $ape1Externo = $_POST["ape1Externo"];
        
        $ape2Externo = $_POST["ape2Externo"];
        
        $puestoExterno = $_POST["puestoExterno"];

        // Verifica si la cookie "nombre_seleccionado" existe
        if (isset($_COOKIE["id_carreras"]) && isset($_COOKIE["clave_profesor"])) {
        
            // Almacena el valor de la cookie en una variable
            $id_profesor = $_COOKIE["clave_profesor"];

            // Deserializar el array de nombres de carreras
            $id_carreras = unserialize($_COOKIE['id_carreras']);

        }

        // Insertar el Proyecto
        // function insertarProyecto($p_nom, $p_obj, $p_tipo, $p_origen, $p_num, $p_desc, $p_imp, $p_fk_emp, $p_fk_prof) {
        $proyecto->insertarProyecto($NombreProyecto, $ObjetivoGeneral, $TipoProyecto, $OpcionProyecto, $NumResidentes, $DescripcionProyecto, $ImpactoProyecto, $id_empresa, $id_profesor);

        // Recuperar la clave del Proyecto insertado
        $id_proyecto = $proyecto->obtenerIdProyectoPorNombre($NombreProyecto);

        // Insertar registros en la tabla ProyectosXCarrera
        $proyecto->relacionarCarrerasConProyecto($id_proyecto, $id_carreras);

        // Insertar asesores en AsesoresXProyecto
        $proyecto->insertarAsesoresEnProyecto($id_proyecto, $id_profesor, $nombreExterno, $ape1Externo, $ape2Externo, $puestoExterno);

    }

?>