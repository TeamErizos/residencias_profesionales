<?php

// Funciones para la comision de asesor

// A recuperar:
// segun el id de un proyecto:
// - el nombre del proyecto (CHECK)
// - los nombres de los residentes (uno o varios) CHECK
// - las carreras de los residentes (una o varias)  CHECK
// - periodo de realizacion (calculado con una función) CHECK
// - nombre de la empresa (CHECK)
// - nombre del asesor 
// - departamento del asesor

class Asesor {
    private $conn;
  
    public function __construct($conn) {
      $this->conn = $conn;
    }

    /**
     * Funcion para obtener el nombre del proyecto segun el id del proyecto 
     * y recupera un arreglo con id_empresa y nombre_proyecto
     * @param $id_proyecto Clave del proyecto a buscar
     */
    function buscarProyecto($id_proyecto) {
      try {
          // Preparar la consulta para buscar el nombre del proyecto y el fk_id_empresa
          $query = "SELECT nombre_proyecto, fk_id_empresa FROM proyecto WHERE id_proyecto = :id_proyecto";
          $stmt = $this->conn->prepare($query);
  
          // Vincular los valores de los parámetros
          $stmt->bindParam(":id_proyecto", $id_proyecto);
  
          // Ejecutar la consulta
          $stmt->execute();
  
          // Obtener el resultado de la consulta
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
          // Verificar si se obtuvo un resultado
          if ($result) {
              // Retornar el arreglo con el fk_id_empresa y el nombre_proyecto
              return array(
                  
                  'nombre_proyecto' => $result['nombre_proyecto'],
                  'fk_id_empresa' => $result['fk_id_empresa']
                  
              );
          } else {
              throw new Exception("No se encontró el proyecto con la clave proporcionada");
          }
      } catch (Exception $e) {
          // Manejar la excepción mostrando un mensaje de error
          echo "Error al buscar proyecto: " . $e->getMessage();
      }
  }

    /**
     * Funcion para obtener el nombre de la empresa segun el fk_id_empresa
     * @param $fk_id_empresa
     */
    function buscarEmpresa($fk_id_empresa) {
      try {
          // Preparar la consulta para buscar el nombre de la empresa
          $query = "SELECT nombre_empresa FROM empresa WHERE id_empresa = :id_empresa";
          $stmt = $this->conn->prepare($query);
  
          // Vincular los valores de los parámetros
          $stmt->bindParam(":id_empresa", $fk_id_empresa);
  
          // Ejecutar la consulta
          $stmt->execute();
  
          // Obtener el resultado de la consulta
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
          // Verificar si se obtuvo un resultado
          if ($result) {
              // Retornar el nombre de la empresa
              return $result['nombre_empresa'];
          } else {
              throw new Exception("No se encontró la empresa correspondiente a la clave de proyecto proporcionada");
          }
      } catch (Exception $e) {
          // Manejar la excepción mostrando un mensaje de error
          echo "Error al buscar empresa: " . $e->getMessage();
      }
  }
  
  
        /* Función para recuperar un arreglo con los alumnos que están relacionado a un proyecto
        * @param $id_proyecto El id del proyecto a buscar
        * @return un array con los id de los alumnos relacionados con el proyecto
        */
        function buscarAlumnosDeProyecto($id_proyecto) {
          try {
              // Preparar la consulta SQL para buscar los id de los alumnos relacionados con el proyecto
              $query = "SELECT id_alumno FROM proyecto_x_alumno WHERE id_proyecto = :id_proyecto";
              $stmt = $this->conn->prepare($query);
              
              // Vincular el valor del id del proyecto
              $stmt->bindParam(":id_proyecto", $id_proyecto);
              
              // Ejecutar la consulta
              $stmt->execute();
              
              // Obtener los resultados y guardarlos en un array
              $alumnos = array();
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $alumnos[] = $row['id_alumno'];
              }
              
              // Devolver el array con los id de los alumnos relacionados con el proyecto
              return $alumnos;
          } catch (PDOException $e) {
              // Manejar la excepción si ocurre un error al ejecutar la consulta
              echo "Error al buscar los alumnos del proyecto: " . $e->getMessage();
              return null;
          }
      }
      

    /* Funcion para recuperar los nombres completos de los alumnos que van a participar
     * input array no_control
     * output arrar nombres_completos
    */
    function obtenerNombresAlumnos($no_control) {
      $nombres_completos = array();
      
      // Verificar si $no_control está vacío o no es un arreglo
      if (empty($no_control) || !is_array($no_control)) {
          return $nombres_completos; // Devolver un arreglo vacío si $no_control está vacío o no es un arreglo
      }
      
      // Generar los marcadores de posición para los valores del array
      $placeholders = implode(',', array_fill(0, count($no_control), '?'));
  
      // Construir la consulta para obtener los nombres de los alumnos
      $query = "SELECT nombre_alumno, ape1_alumno, ape2_alumno FROM ALUMNO WHERE no_control IN ($placeholders)";
      
      try {
          // Preparar la consulta
          $stmt = $this->conn->prepare($query);
          
          // Vincular cada valor del array como un parámetro individual
          foreach ($no_control as $key => $value) {
              $stmt->bindValue(($key + 1), $value);
          }
          
          // Ejecutar la consulta
          $stmt->execute();
      
          // Recuperar los resultados
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              // Concatenar los nombres del alumno
              $nombre_completo = $row['nombre_alumno'] . " " . $row['ape1_alumno'] . " " . $row['ape2_alumno'];
      
              // Agregar el nombre completo al arreglo
              $nombres_completos[] = $nombre_completo;
          }
      } catch(PDOException $e) {
          // Manejo de excepciones
          echo "Error al obtener nombres de alumnos: " . $e->getMessage();
      }
      
      // Devolver el arreglo con los nombres completos de los alumnos
      return $nombres_completos;
  }
  
  

      /* Funcion para recuperar los nombres de las carreras de acuerdo a los
      * no_control de los alumnos participantes
      * input array de no_control
      * output array de nom_carrera
      */
      function buscarNombresCarreras($no_controles) {
        try {
            // Convertir el arreglo de no_controles en una cadena separada por comas para utilizar en la cláusula IN de la consulta SQL
            $placeholders = implode(',', array_fill(0, count($no_controles), '?'));
    
            // Construir la consulta SQL para buscar las claves de carrera de los alumnos en la tabla ALUMNO
            $query = "SELECT DISTINCT FK_ID_CARRERA FROM ALUMNO WHERE CAST(NO_CONTROL AS character varying) IN ($placeholders)";
            $stmt = $this->conn->prepare($query);
    
            // Vincular los valores del arreglo como parámetros individuales
            foreach ($no_controles as $key => $value) {
                $stmt->bindValue(($key + 1), strval($value));
            }
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener los resultados en un arreglo
            $resultados = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
            // Inicializar un arreglo vacío para guardar los nombres de las carreras
            $nombres_carreras = [];
    
            // Iterar por cada clave de carrera obtenida en los resultados
            foreach ($resultados as $clave_carrera) {
                // Preparar la consulta SQL para buscar el nombre de la carrera en la tabla CARRERAS
                $query_carrera = "SELECT NOM_CARRERA FROM CARRERA WHERE ID_CARRERA = :clave_carrera";
                $stmt_carrera = $this->conn->prepare($query_carrera);
    
                // Vincular el valor de la clave de carrera
                $stmt_carrera->bindParam(":clave_carrera", $clave_carrera);
    
                // Ejecutar la consulta
                $stmt_carrera->execute();
    
                // Obtener el resultado
                $resultado_carrera = $stmt_carrera->fetch(PDO::FETCH_ASSOC);
    
                // Verificar si se obtuvo un resultado
                if ($resultado_carrera) {
                   //print_r($resultado_carrera);
                   
                    // Obtener el nombre de la carrera
                    $nombre_carrera = $resultado_carrera['nom_carrera'];
    
                    // Agregar el nombre de la carrera al arreglo de nombres de carreras
                    $nombres_carreras[] = $nombre_carrera;
                }
            }
    
            // Eliminar las claves de carrera repetidas en el arreglo de nombres de carreras
            $nombres_carreras = array_unique($nombres_carreras);
    
            // Regresar el arreglo de nombres de carreras
            return $nombres_carreras;
        } catch (PDOException $e) {
            // Manejar cualquier excepción que se genere durante la ejecución de la consulta SQL
            echo "Error al buscar nombres de carreras: " . $e->getMessage();
            return [];
        }
    }
    
    

    // Funcion que calcula el periodo real del proyecto
    function getPeriodo() {
      $mesActual = date("n");
      $anioActual = date("Y");
      
      if ($mesActual >= 8) {
        return "ENE-" . "JUN-" . ($anioActual + 1);
      } else if ($mesActual >= 2 && $mesActual < 8 ) {
        return "AGO-" . "DIC-" . $anioActual;
      }
    }

    // Funcion que calcula el dia actual
    function obtenerFechaActual() {
        date_default_timezone_set('America/Mexico_City'); // Establecer la zona horaria de México
    
        $fecha_actual = date('d/m/Y'); // Formato: día/mes/año
    
        return $fecha_actual;
    }
    

    /* Funcion para buscar el nombre del profesor que será comisionado como Asesor
    *  Input $id_proyecto
    *  output nombre_profesor
      */
      function obtenerAsesorInterno($id_proyecto) {
        try {
            // Preparar consulta para obtener el ID del profesor asesor interno del proyecto
            $query = "SELECT id_asesor_interno FROM asesor_x_proyecto WHERE id_proyecto = :id_proyecto";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_proyecto", $id_proyecto);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Verificar si se obtuvo un resultado
            if ($result) {
                $id_profesor = $result['id_asesor_interno'];
    
                // Preparar consulta para obtener el nombre completo del profesor a partir de su ID
                $query = "SELECT nom_profesor, ape1_profesor, ape2_profesor FROM profesor WHERE id_profesor = :id_profesor";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id_profesor", $id_profesor);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
                // Verificar si se obtuvo un resultado
                if ($result) {
                    // Retornar el nombre completo del profesor
                    return $result['nom_profesor'] . " " . $result['ape1_profesor'] . " " . $result['ape2_profesor'];
                } else {
                    return "No se encontró el profesor con ID: " . $id_profesor;
                }
            } else {
                return "No se encontró el proyecto con ID: " . $id_proyecto;
            }
        } catch (PDOException $e) {
            echo "Error al obtener el nombre del profesor asesor interno: " . $e->getMessage();
        }
    }    

      
      /* Funcion para recuperar el nombre del departamento academico al que pertenece
      * este proyecto
      * input id_proyecto
      * output nombre del departamento academico
      */
      function obtenerNombreSubdireccionAcademica($id_proyecto) {
        try {
          // Paso 1: Obtener el id_carrera en carrera_x_proyecto (solo el primer valor)
          $query1 = "SELECT id_carrera FROM carrera_x_proyecto WHERE id_proyecto = :id_proyecto LIMIT 1";
          $stmt1 = $this->conn->prepare($query1);
          $stmt1->bindParam(':id_proyecto', $id_proyecto, PDO::PARAM_INT);
          $stmt1->execute();
          $id_carrera = $stmt1->fetchColumn();
      
          // Paso 2: Obtener la clave en subdireccion_x_carrera
          $query2 = "SELECT fk_id_sub_aca FROM subdireccion_x_carrera WHERE fk_id_carrera = :id_carrera";
          $stmt2 = $this->conn->prepare($query2);
          $stmt2->bindParam(':id_carrera', $id_carrera, PDO::PARAM_INT);
          $stmt2->execute();
          $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
          $clave_sub_aca = $result2['fk_id_sub_aca'];
      
          // Paso 3: Obtener el nombre en subdireccion_academica
          $query3 = "SELECT sub_aca_nombre FROM subdireccion_academica WHERE id_sub_aca = :clave_sub_aca";
          $stmt3 = $this->conn->prepare($query3);
          $stmt3->bindParam(':clave_sub_aca', $clave_sub_aca, PDO::PARAM_INT);
          $stmt3->execute();
          $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
          $nombre_sub_aca = $result3['sub_aca_nombre'];
      
          // Retornar el nombre de la subdirección académica
          return $nombre_sub_aca;
        } catch (PDOException $e) {
          // Manejo de excepciones
          echo "Error: " . $e->getMessage();
        }
      }

      /* Funcion para buscar el nombre de un profesor que será asesor interno
      * segun su clave de profesor
      * input id_profesor
      * output nombre completo del profesor
      */ 
      function obtenerProfesor($id_profesor) {
        try {
            // Preparar consulta para obtener el nombre completo del profesor a partir de su ID
            $query = "SELECT nom_profesor, ape1_profesor, ape2_profesor FROM profesor WHERE id_profesor = :id_profesor";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_profesor", $id_profesor);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Verificar si se obtuvo un resultado
            if ($result) {
                // Retornar el nombre completo del profesor
                return $result['nom_profesor'] . " " . $result['ape1_profesor'] . " " . $result['ape2_profesor'];
            } else {
                return "No se encontró el profesor con ID: " . $id_profesor;
            }
        } catch (PDOException $e) {
            echo "Error al obtener el nombre completo del profesor: " . $e->getMessage();
        }
    }

    /* Funcion para actualizar el asesor de un proyecto
    * input @@@id_proyecto y @@@id_profesor
    */
    function actualizarAsesorInterno($id_proyecto, $id_profesor) {
        try {

          // Preparar la consulta SQL para actualizar el campo is_asesor_interno
          $query = "UPDATE asesor_x_proyecto SET id_asesor_interno = :id_profesor WHERE id_proyecto = :id_proyecto";
          $stmt = $this->conn->prepare($query);
          
          // Vincular los valores de los parámetros
          $stmt->bindParam(':id_profesor', $id_profesor);
          $stmt->bindParam(':id_proyecto', $id_proyecto);
          
          // Ejecutar la consulta
          $stmt->execute();
          
          // Cerrar la conexión
          $conn = null;
          
          // Retornar true si la actualización fue exitosa
          return true;
        } catch (PDOException $e) {
          // Manejar cualquier excepción que se genere durante la ejecución de la consulta SQL
          echo "Error al actualizar el asesor interno: " . $e->getMessage();
          
          // Retornar false en caso de error
          return false;
        }
      }
      
    // Actualizar el estado del registro asesor_x_proyecto para que no aparezca
    // En la lista principal
      function comisionNoRequerida($id_proyecto) {
        try {
          // Sentencia SQL para llamar a la función
          $sql = "SELECT update_asesor_asignado(:id_proyecto)";
      
          // Preparar la consulta
          $stmt = $this->conn->prepare($sql);
      
          // Vincular el valor del parámetro
          $stmt->bindParam(':id_proyecto', $id_proyecto);
      
          // Ejecutar la consulta
          $stmt->execute();
      
          echo "Función ejecutada correctamente";
        } catch (PDOException $e) {
          echo "Error al ejecutar la función: " . $e->getMessage();
        }
      }

    // Funcion para cambiar .docx a .pdf
    // @@input $id_proyecto
    function createPDF($id_proyecto) {
        // Verificar si existe el archivo .docx
        $docx_file = "doc/" . $id_proyecto . ".docx";
        if (!file_exists($docx_file)) {
            echo "El archivo .docx no existe.";
            return;
        }
    
        // Cada archivo (doc, pdf, bat, tendrá el No Control)
        $batchFile = $id_proyecto . ".bat";
    
        // El contenido del script creará un pdf único a partir de un word único
        $command = "soffice --headless --convert-to pdf doc/" . $id_proyecto . ".docx --outdir pdf/"; // cada archivo tendrá el No Control del alumno
        
        // Guardar el archivo 
        file_put_contents($batchFile, $command);
        
        // Ejecutar el código y crear el pdf
        exec($batchFile, $output, $return);
        
        if ($return == 0) {
          echo "Command ran successfully";
        } else {
          echo "Command failed";
        }
    
        return "pdf/" . $id_proyecto . ".pdf";
    }
    
  
    // Eliminar archivos del estudiante, el word, el pdf y el .bat
    function deleteFiles($id_proyecto) {
        // Construye la ruta del archivo .bat correspondiente al número de control
        $batchFile = $id_proyecto . ".bat";
        
        // Construye la ruta del archivo .docx correspondiente al número de control
        $docFile = "doc/" . $id_proyecto . ".docx";
        
        // Construye la ruta del archivo .pdf correspondiente al número de control
        $pdfFile = "pdf/" . $id_proyecto . ".pdf";
        
        // Si el archivo .bat existe, lo borra utilizando la función unlink()
        if (file_exists($batchFile)) {
          unlink($batchFile);
        }
        
        // Si el archivo .docx existe, lo borra utilizando la función unlink()
        if (file_exists($docFile)) {
          unlink($docFile);
        }
        
        // Si el archivo .pdf existe, lo borra utilizando la función unlink()
        if (file_exists($pdfFile)) {
          unlink($pdfFile);
        }  
      }

      // Insertar comision en pdf dentro de la base de datos
      //@@@input id_proyecto y ruta del pdf
      
      // Insercion de constancia
    function insertarComisionAsesor($proyecto_id, $comision_file) {
      // Obtener el contenido del archivo
      $constancia = file_get_contents($comision_file);

      try {
        // Preparar la consulta SQL para insertar la constancia de residencia
        $sql = "SELECT insertar_archivo_asesor(:proyecto_act_id, :comision)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':proyecto_act_id', $proyecto_id, PDO::PARAM_INT);
        $stmt->bindParam(':comision', $constancia, PDO::PARAM_LOB);
        $stmt->execute();
      } catch (PDOException $e) {
        echo "Error al insertar la constancia de residencia: " . $e->getMessage();
      }
    }

      // Descargar la comision en el asesor (en el servidor)
      function descargarComisionAsesor($id_proyecto) {
      
        // Preparar la consulta para extraer el anteproyecto
        $query = "SELECT file_asesor FROM asesor_x_proyecto WHERE id_proyecto = :proyecto_id";
        $stmt = $this->conn->prepare($query);
      
        // Vincular el valor del identificador del proyecto activo
        $stmt->bindParam(":proyecto_id", $id_proyecto);
      
        // Ejecutar la consulta
        $stmt->execute();
      
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
        // Verificar si se obtuvo un resultado
        if ($result) {
          // Extraer el anteproyecto
          $anteproyecto = $result['file_asesor'];
      
          // Verificar si el anteproyecto se extrajo correctamente
          if ($anteproyecto) {
      
            // Ruta del pdf
            $file = "comision_asesor.pdf";
      
            // Guardar el anteproyecto en un archivo
            file_put_contents($file, $anteproyecto);
      
            // Verificar si el archivo se guardó correctamente
            if (file_exists("comision_asesor.pdf")) {
              echo "El archivo se extrajo y guardó correctamente.";
            } else {
              echo "No se pudo guardar el archivo.";
            }
          } else {
            echo "No se pudo extraer el anteproyecto.";
          }
        } else {
          echo "No se encontró el anteproyecto.";
        }
      }
    
  }
  

?>