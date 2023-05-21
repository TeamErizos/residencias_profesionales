<?php

class Files {
    private $id_p_x_a;
    private $conn;

    // Constructor que recibe los parámetros id_p_x_a y $conn
    public function __construct($id_p_x_a, $conn) {
        $this->id_p_x_a = $id_p_x_a;
        $this->conn = $conn;
    }

    // Descargar el anteproyecto del alumno
    function descargarConstanciaResidencia() {
      
        // Preparar la consulta para extraer el anteproyecto
        $query = "SELECT constancia_de_residencia FROM documentos WHERE id_proyecto_activo = :proyecto_id";
        $stmt = $this->conn->prepare($query);
      
        // Vincular el valor del identificador del proyecto activo
        $stmt->bindParam(":proyecto_id", $this->id_p_x_a);
      
        // Ejecutar la consulta
        $stmt->execute();
      
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
        // Verificar si se obtuvo un resultado
        if ($result) {
          // Extraer el anteproyecto
          $constancia = $result['constancia_de_residencia'];
      
          // Verificar si el anteproyecto se extrajo correctamente
          if ($constancia) {
      
            // Ruta del pdf
            $file = "constancia/". $this->id_p_x_a . ".pdf";
      
            // Guardar el anteproyecto en un archivo
            file_put_contents($file, $constancia);
      
            // Verificar si el archivo se guardó correctamente
            if (file_exists($file)) {
              return $file;
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
      
    // Descargar el anteproyecto del alumno
      public function descargarAnteproyecto() {
        // Preparar la consulta para extraer el anteproyecto
        $query = "SELECT anteproyecto FROM documentos WHERE id_proyecto_activo = :proyecto_id";
        $stmt = $this->conn->prepare($query);
      
        // Vincular el valor del identificador del proyecto activo
        $stmt->bindParam(":proyecto_id", $this->id_p_x_a);
      
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
                // Ruta del archivo PDF
                $file = "anteproyecto/" . $this->id_p_x_a . ".pdf";
      
                // Guardar el anteproyecto en un archivo
                file_put_contents($file, $anteproyecto);
      
                // Verificar si el archivo se guardó correctamente
                if (file_exists($file)) {
                    return $file;
                } else {
                    echo "No se pudo guardar el archivo del anteproyecto.";
                }
            } else {
                echo "No se pudo extraer el anteproyecto.";
            }
        } else {
            echo "No se encontró el anteproyecto.";
        }
    }

    // Descargar la solicitud de residencia del alumno
    public function descargarSolicitudResidencia() {
        // Preparar la consulta para extraer la solicitud de residencia
        $query = "SELECT solicitud_de_residencia FROM documentos WHERE id_proyecto_activo = :proyecto_id";
        $stmt = $this->conn->prepare($query);
      
        // Vincular el valor del identificador del proyecto activo
        $stmt->bindParam(":proyecto_id", $this->id_p_x_a);
      
        // Ejecutar la consulta
        $stmt->execute();
      
        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
        // Verificar si se obtuvo un resultado
        if ($result) {
            // Extraer la solicitud de residencia
            $solicitudResidencia = $result['solicitud_de_residencia'];
      
            // Verificar si la solicitud de residencia se extrajo correctamente
            if ($solicitudResidencia) {
                // Ruta del archivo PDF
                $file = "solicitud/" . $this->id_p_x_a . ".pdf";
      
                // Guardar la solicitud de residencia en un archivo
                file_put_contents($file, $solicitudResidencia);
      
                // Verificar si el archivo se guardó correctamente
                if (file_exists($file)) {
                    return $file;
                } else {
                    echo "No se pudo guardar el archivo de la solicitud de residencia.";
                }
            } else {
                echo "No se pudo extraer la solicitud de residencia.";
            }
        } else {
            echo "No se encontró la solicitud de residencia.";
        }
    }
    
}