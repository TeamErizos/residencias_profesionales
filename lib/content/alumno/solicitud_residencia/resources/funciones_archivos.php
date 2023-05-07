<?php

// el id de la tabla documentos es llave foranea de id_p_x_a de Proyecto_X_Alumno

class Documentos {
    private $conn;
  
    function __construct($db_conn) {
      $this->conn = $db_conn;
    }
  
    // Insercion de constancia
    function insertarConstanciaDeResidencia($proyecto_act_id, $constancia_file) {
      // Obtener el contenido del archivo
      $constancia = file_get_contents($constancia_file);

      try {
        // Preparar la consulta SQL para insertar la constancia de residencia
        $sql = "SELECT insertar_constancia_de_residencia(:proyecto_act_id, :constancia)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':proyecto_act_id', $proyecto_act_id, PDO::PARAM_INT);
        $stmt->bindParam(':constancia', $constancia, PDO::PARAM_LOB);
        $stmt->execute();
      } catch (PDOException $e) {
        echo "Error al insertar la constancia de residencia: " . $e->getMessage();
      }
    }

    // Insercion de anteproyecto
    function insertarAnteproyecto($proyecto_act_id, $anteproyecto_file) {
      // Obtener el contenido del archivo
      $anteproyecto = file_get_contents($anteproyecto_file);

      try {
        // Preparar la consulta SQL para insertar el anteproyecto
        $sql = "SELECT insertar_anteproyecto(:proyecto_act_id, :anteproyecto)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':proyecto_act_id', $proyecto_act_id, PDO::PARAM_INT);
        $stmt->bindParam(':anteproyecto', $anteproyecto, PDO::PARAM_LOB);
        $stmt->execute();
      } catch (PDOException $e) {
        echo "Error al insertar el anteproyecto: " . $e->getMessage();
      }
    }

    // Funcion para cambiar .docx a .pdf
    function createPDF($no_control) {
      // Verificar si existe el archivo .docx
      $docx_file = "doc/" . $no_control . ".docx";
      if (!file_exists($docx_file)) {
          echo "El archivo .docx no existe.";
          return;
      }
  
      // Cada archivo (doc, pdf, bat, tendrá el No Control)
      $batchFile = $no_control . ".bat";
  
      // El contenido del script creará un pdf único a partir de un word único
      $command = "soffice --headless --convert-to pdf doc/" . $no_control . ".docx --outdir pdf/"; // cada archivo tendrá el No Control del alumno
      
      // Guardar el archivo 
      file_put_contents($batchFile, $command);
      
      // Ejecutar el código y crear el pdf
      exec($batchFile, $output, $return);
      
      if ($return == 0) {
        echo "Command ran successfully";
      } else {
        echo "Command failed";
      }
  
      return "pdf/" . $no_control . ".pdf";
  }
  

  // Eliminar archivos del estudiante, el word, el pdf y el .bat
  function deleteFiles($no_control) {
      // Construye la ruta del archivo .bat correspondiente al número de control
      $batchFile = $no_control . ".bat";
      
      // Construye la ruta del archivo .docx correspondiente al número de control
      $docFile = "doc/" . $no_control . ".docx";
      
      // Construye la ruta del archivo .pdf correspondiente al número de control
      $pdfFile = "pdf/" . $no_control . ".pdf";
      
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

      // -- Borrar los archivos cargados por el alumno
      $addressAnteproyecto = "project/" . $no_control . "a.pdf";
      if (file_exists($addressAnteproyecto)) {
        unlink($addressAnteproyecto);
      }

      $addressConstancia = "project/" . $no_control . "c.pdf";
      if (file_exists($addressConstancia)) {
        unlink($addressConstancia);
      }

    }
    
    function getIdProyectoActivo($no_control) {
      // Obtener el id del proyecto activo de acuerdo al alumno
      $query = "SELECT id_p_x_a FROM proyecto_x_alumno WHERE id_alumno = :no_control";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(":no_control", $no_control);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['id_p_x_a'];
  }

  
    // --------------------------------------------------------
    // Estas funciones de descargar son para probar si se subieron los archivos
      

  // Insertar la solicitud
  function insertarSolicitudDeResidencia($id_proyecto_activo, $file) {
    
    // Obtener el contenido del archivo
    $solicitud_de_residencia = file_get_contents($file);
  
    // Preparar la llamada a la función de inserción
    $query = "SELECT insertar_solicitud_de_residencia(:proyecto_act_id, :sol)";
    $stmt = $this->conn->prepare($query);
  
    // Vincular los valores
    $stmt->bindParam(":proyecto_act_id", $id_proyecto_activo);
    $stmt->bindParam(":sol", $solicitud_de_residencia, PDO::PARAM_LOB);
  
    // Ejecutar la consulta
    if ($stmt->execute()) {
      echo "La solicitud de residencia se guardó correctamente en la base de datos.";
    } else {
      echo "Hubo un error al guardar la solicitud de residencia en la base de datos.";
    }
  }
  
  // Descargar la solicitud (en el servidor)
  function descargarSolicitudDeResidencia($id_proyecto_activo) {
  
    // Preparar la consulta para extraer la solicitud de residencia
    $query = "SELECT solicitud_de_residencia FROM DOCUMENTOS WHERE id_proyecto_activo = :proyecto_act_id";
    $stmt = $this->conn->prepare($query);
  
    // Vincular el valor del identificador del proyecto activo
    $stmt->bindParam(":proyecto_act_id", $id_proyecto_activo);
  
    // Ejecutar la consulta
    $stmt->execute();
  
    // Obtener el resultado
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // Verificar si se obtuvo un resultado
    if ($result) {
      // Extraer la solicitud de residencia
      $solicitud_de_residencia = $result['solicitud_de_residencia'];
  
      // Verificar si la solicitud de residencia se extrajo correctamente
      if ($solicitud_de_residencia) {
  
        // Ruta del pdf
        $file = "solicitud_de_residencia.pdf";
  
        // Guardar la solicitud de residencia en un archivo
        file_put_contents($file, $solicitud_de_residencia);
  
        // Verificar si el archivo se guardó correctamente
        if (file_exists("solicitud_de_residencia.pdf")) {
          echo "El archivo se extrajo y guardó correctamente.";
        } else {
          echo "No se pudo guardar el archivo.";
        }
      } else {
        echo "No se pudo extraer la solicitud de residencia.";
      }
    } else {
      echo "No se encontró la solicitud de residencia.";
    }
  }

      // Descargar el anteproyecto (en el servidor)
      function descargarAnteproyecto($id_proyecto_activo) {
      
        // Preparar la consulta para extraer el anteproyecto
        $query = "SELECT anteproyecto FROM DOCUMENTOS WHERE id_proyecto_activo = :proyecto_act_id";
        $stmt = $this->conn->prepare($query);
      
        // Vincular el valor del identificador del proyecto activo
        $stmt->bindParam(":proyecto_act_id", $id_proyecto_activo);
      
        // Ejecutar la consulta
        $stmt->execute();
      
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
        // Verificar si se obtuvo un resultado
        if ($result) {
          // Extraer el anteproyecto
          $anteproyecto = $result['anteproyecto'];
      
          // Verificar si el anteproyecto se extrajo correctamente
          if ($anteproyecto) {
      
            // Ruta del pdf
            $file = "anteproyecto.pdf";
      
            // Guardar el anteproyecto en un archivo
            file_put_contents($file, $anteproyecto);
      
            // Verificar si el archivo se guardó correctamente
            if (file_exists("anteproyecto.pdf")) {
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

    // Descargar la constancia de residencia (en el servidor)
    function descargarConstanciaDeResidencia($id_proyecto_activo) {

      // Preparar la consulta para extraer la constancia de residencia
      $query = "SELECT constancia_de_residencia FROM DOCUMENTOS WHERE id_proyecto_activo = :proyecto_act_id";
      $stmt = $this->conn->prepare($query);

      // Vincular el valor del identificador del proyecto activo
      $stmt->bindParam(":proyecto_act_id", $id_proyecto_activo);

      // Ejecutar la consulta
      $stmt->execute();

      // Obtener el resultado
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      // Verificar si se obtuvo un resultado
      if ($result) {
        // Extraer la constancia de residencia
        $constancia_de_residencia = $result['constancia_de_residencia'];

        // Verificar si la constancia de residencia se extrajo correctamente
        if ($constancia_de_residencia) {

          // Ruta del pdf
          $file = "constancia_de_residencia.pdf";

          // Guardar la constancia de residencia en un archivo
          file_put_contents($file, $constancia_de_residencia);

          // Verificar si el archivo se guardó correctamente
          if (file_exists("constancia_de_residencia.pdf")) {
            echo "El archivo se extrajo y guardó correctamente.";
          } else {
            echo "No se pudo guardar el archivo.";
          }
        } else {
          echo "No se pudo extraer la constancia de residencia.";
        }
      } else {
        echo "No se encontró la constancia de residencia.";
      }
    }
}

  
?>