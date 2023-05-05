<?php

// Estas funciones se encargaran de:
    // 1. Los campos requeridos en cookies ($_SESSION
    // 2. Buscar registros segun un campo "unico"

class Alumno {
    private $conn;
  
    public function __construct($conn) {
      $this->conn = $conn;
    }

    // TODO:
    // Guardar como cookies los datos alumno segun su numero de control
    // y recuperar la [clave de la carrera del alumno]
    public function recuperarDatosAlumno($no_control) {
      // Preparar la consulta SQL para recuperar los datos del alumno con el número de control dado
      $sql = "SELECT nombre_alumno, ape1_alumno, ape2_alumno, calle_principal, num_domicilio, ciudad_alumno, correo_alumno, telefono_alumno, seguro_medico_alumno, num_seguridad_social_alumno, fk_id_carrera FROM alumno WHERE no_control = :no_control";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':no_control', $no_control);
  
      // Ejecutar la consulta
      $stmt->execute();
  
      // Obtener el resultado de la consulta
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
      // Verificar si se obtuvo algún resultado
      if ($result) {
          // Si se obtuvo resultado, crear variables de sesión con los valores obtenidos

          // COMBINAR LOS TRES PARA HACER EL NOMBRE COMPLETO
          $_SESSION['nombre_alumno'] = $result['nombre_alumno'] . " " . $result['ape1_alumno'] . " " . $result['ape2_alumno'];
          // COMBINAR AMBOS PARA HACER EL DOMICILIO
          $_SESSION['domicilio_alumno'] = $result['calle_principal'] . " " . $result['num_domicilio'];
          $_SESSION['ciudad_alumno'] = $result['ciudad_alumno'];
          $_SESSION['correo_alumno'] = $result['correo_alumno'];
          $_SESSION['telefono_alumno'] = $result['telefono_alumno'];
          $_SESSION['seguro_medico_alumno'] = $result['seguro_medico_alumno'];
          $_SESSION['num_seguridad_social_alumno'] = $result['num_seguridad_social_alumno'];
          
          // <-- REVISAR SI ES CORRECTO HACER ESTO -->
          return $result['fk_id_carrera'];
      } else {
          // Si no se obtuvo resultado, retornar false
          return false;
      }
    }

    // Recuperar el nombre de la carrera segun su llave primaria
    public function recuperarNombreCarrera($id_carrera) {
        // Preparar la consulta SQL para recuperar el nombre de la carrera con el ID dado
        $sql = "SELECT nom_carrera FROM carrera WHERE id_carrera = :id_carrera";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_carrera', $id_carrera);
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener el resultado de la consulta
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verificar si se obtuvo algún resultado
        if ($result) {
            // Si se obtuvo resultado, crear variable de sesión con el nombre obtenido
            return $result['nom_carrera'];
        } else {
            // Si no se obtuvo resultado, retornar false
            return false;
        }
    }

    // Recuperar proyecto segun su nombre
    function recuperarDatosProyecto($nombre_proyecto) {
        
        // Preparar la consulta SQL para recuperar los datos del proyecto con el nombre dado
        $sql = "SELECT tipo_proyecto, origen_proyecto, periodo_proyecto, num_residentes, fk_id_profesor FROM proyecto WHERE nombre_proyecto = :nombre_proyecto";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre_proyecto', $nombre_proyecto);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado de la consulta
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar si se obtuvo algún resultado
        if ($result) {
            // Si se obtuvo resultado, crear variables de sesión con los valores obtenidos
            $_SESSION['tipo_proyecto'] = $result['tipo_proyecto'];
            $_SESSION['origen_proyecto'] = $result['origen_proyecto'];
            $_SESSION['periodo_proyecto'] = $result['periodo_proyecto'];
            $_SESSION['num_residentes'] = $result['num_residentes'];
            // Recuperar el nombre del profesor porque igual hay que buscarlo
            return $result['fk_id_profesor'];
        } else {
            // Si no se obtuvo resultado, retornar false
            return false;
        }
    }
    

    // Recuperar nombre de profesor de acuerdo a su id
    function recuperarNombreProfesor($id_profesor) {
        // Preparar la consulta SQL para recuperar el nombre completo del profesor
        $sql = "SELECT nom_profesor, ape1_profesor, ape2_profesor FROM profesor WHERE id_profesor = :id_profesor";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_profesor', $id_profesor);
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener el resultado de la consulta
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verificar si se obtuvo algún resultado
        if ($result) {
            // Si se obtuvo resultado, crear una variable de sesión con el nombre completo del profesor
            $nombre_completo_profesor = $result['nom_profesor'] . " " . $result['ape1_profesor'] . " " . $result['ape2_profesor'];
            return $nombre_completo_profesor;
        } else {
            // Si no se obtuvo resultado, retornar false
            return false;
        }
    }
    
    // Guardar datos de empresa segun proyecto 
    function recuperarDatosEmpresa($nombre_proyecto) {
        // Preparar la consulta SQL para recuperar la clave de la empresa asociada al proyecto con el nombre dado
        $sql = "SELECT fk_id_empresa FROM proyecto WHERE nombre_proyecto = :nombre_proyecto";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre_proyecto', $nombre_proyecto);
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener el resultado de la consulta
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verificar si se obtuvo algún resultado
        if ($result) {
            // Si se obtuvo resultado, obtener la clave de la empresa
            $id_empresa = $result['fk_id_empresa'];
    
            // Preparar la consulta SQL para recuperar los datos de la empresa con la clave dada
            $sql = "SELECT nombre_empresa, ramo_empresa, rfc_empresa, sector_empresa, actividad_principal, calle_principal, num_domicilio, colonia_empresa, ciudad_empresa, nombre_del_titular_de_empresa, ape1_del_titular_de_empresa, ape2_del_titular_de_empresa, puesto_del_titular_de_empresa, codigo_postal, fax, tel_empresa FROM empresa WHERE id_empresa = :id_empresa";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_empresa', $id_empresa);
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener el resultado de la consulta
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Verificar si se obtuvo algún resultado
            if ($result) {
                // Si se obtuvo resultado, crear variables de sesión con los valores obtenidos
                $_SESSION['nombre_empresa'] = $result['nombre_empresa'];
                $_SESSION['ramo_empresa'] = $result['ramo_empresa'];
                $_SESSION['rfc_empresa'] = $result['rfc_empresa'];
                $_SESSION['sector_empresa'] = $result['sector_empresa'];
                $_SESSION['actividad_principal'] = $result['actividad_principal'];
                $_SESSION['domicilio_empresa'] = $result['calle_principal'] . " " . $result['num_domicilio'];
                $_SESSION['ciudad_empresa'] = $result['ciudad_empresa'];
                $_SESSION['colonia_empresa'] = $result['colonia_empresa'];
                $_SESSION['nombre_del_titular_de_empresa'] = $result['nombre_del_titular_de_empresa'] . " " . $result['ape1_del_titular_de_empresa'] . " " . $result['ape2_del_titular_de_empresa'];
                $_SESSION['puesto_titular'] = $result['puesto_del_titular_de_empresa'];
                $_SESSION['codigo_postal'] = $result['codigo_postal'];
                $_SESSION['fax_empresa'] = $result['fax'];
                $_SESSION['tel_empresa'] = $result['tel_empresa'];

            }
        }
    }

    // LA FUNCION PARA INSERTAR LA INFO DENTRO DE LA TABLA [ASESORES POR PROYECTO]
    // SOLO SE HARÁ CON LA [COMISIÓN DE ASESOR] quisiera quitarlo pero es ISO

    // Funcion para guardar y relacionar el proyecto con el alumno
    // TODO: Cuando haya funciones especificas para dicha tabla, actualizar esta función


    
        
        // Función para insertar un registro en la tabla "ProyectoXAlumno"
        public function insertarProyectoXAlumno($id_proyecto, $id_alumno, $periodo_0_sem) {
            // Preparar la consulta SQL para insertar un registro en la tabla "ProyectoXAlumno"
            $sql = "INSERT INTO ProyectoXAlumno (id_proyecto, id_alumno, periodo_0_sem, calif_parcial1_asesor_interno, calif_parcial1_asesor_externo, calif_parcial2_asesor_interno, calif_parcial2_asesor_externo, calif_reporte_asesor_interno, calif_reporte_asesor_externo) VALUES (:id_proyecto, :id_alumno, :periodo_0_sem, '', '', '', '', '', '')";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_proyecto', $id_proyecto);
            $stmt->bindParam(':id_alumno', $id_alumno);
            $stmt->bindParam(':periodo_0_sem', $periodo_0_sem);
            $stmt->bindParam(':calif_parcial1_asesor_interno', 0);
            $stmt->bindParam(':calif_parcial1_asesor_externo', 0);
            $stmt->bindParam(':calif_parcial2_asesor_interno', 0);
            $stmt->bindParam(':calif_parcial2_asesor_externo', 0);
            $stmt->bindParam(':calif_reporte_asesor_interno', 0);
            $stmt->bindParam(':calif_reporte_asesor_externo', 0);
      
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

    // Funcion que calcula el periodo real del proyecto
    // el periodo proyectado es diferente != al periodo real del proyecto
    function getPeriodo() {
        $mesActual = date("n");
        $anioActual = date("Y");
        
        if ($mesActual >= 8) {
          return "ENE-" . "JUN-" . ($anioActual + 1);
        } else if ($mesActual >= 2 && $mesActual < 8 ) {
          return "AGO-" . "DIC-" . $anioActual;
        }
      }


    // TODO: Función para guardar la constancia de residencia y el anteproyecto dentro de la base de datos
    function insertarArchivos($id_alumno){ // Va depender del no control del alumno

        // La inserción es en la tabla Documentos_X_Alumno

    } 
}


?>
