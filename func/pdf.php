<?php
    
    //Crear los PDFs
    function createPDF($variabledef)
    {
        // Verificar si existe el archivo .docx
        $docx_file = "doc/" . $variabledef . ".docx";
        if (!file_exists($docx_file)) 
        {
            echo "El archivo .docx no existe.";
            return;
        }

        // Cada archivo (doc, pdf, bat, tendrá el No Control)
        $batchFile = $variabledef . ".bat";

        // El contenido del script creará un pdf único a partir de un word único
        $command = "soffice --headless --convert-to pdf doc/" . $variabledef . ".docx --outdir pdf/"; // cada archivo tendrá el No Control del alumno

        // Guardar el archivo 
        file_put_contents($batchFile, $command);
        
        // Ejecutar el código y crear el pdf
        exec($batchFile, $output, $return);
        
        if ($return == 0) 
        {
        echo "Command ran successfully";
        } 
        else 
        {
        echo "Command failed";
        }

        return "pdf/" . $variabledef . ".pdf";
    }



    class Dictamen 
    {
        private $conn;
      
        public function __construct($conn) 
        {
          $this->conn = $conn;
        }
        
        function createPDFDict($variabledef)
        {
            // Verificar si existe el archivo .docx
            $docx_file = "doc/" . $variabledef . ".docx";
            if (!file_exists($docx_file)) 
            {
                echo "El archivo .docx no existe.";
                return;
            }

            // Cada archivo (doc, pdf, bat, tendrá el No Control)
            $batchFile = $variabledef . ".bat";

            // El contenido del script creará un pdf único a partir de un word único
            $command = "soffice --headless --convert-to pdf doc/" . $variabledef . ".docx --outdir documents/"; // cada archivo tendrá el No Control del alumno

            // Guardar el archivo 
            file_put_contents($batchFile, $command);
            
            // Ejecutar el código y crear el pdf
            exec($batchFile, $output, $return);
            
            if ($return == 0) 
            {
            echo "Command ran successfully";
            } 
            else 
            {
            echo "Command failed";
            }

            return "dictamen.pdf";
        }
    }

    class Carta 
    {
        private $conn;
      
        public function __construct($conn) 
        {
          $this->conn = $conn;
        }

        // Insercion de la carta de presentacion
        function insertarCarta($variabledef, $comision_file) {
        // Obtener el contenido del archivo
        $carta = file_get_contents($comision_file);
    
        try {
            // Preparar la consulta SQL para insertar el dictamen de anteproyecto
            $sql = "SELECT insertar_carta_de_presentacion(:variabledef, :comision)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':variabledef', $variabledef, PDO::PARAM_INT);
            $stmt->bindParam(':comision', $carta, PDO::PARAM_LOB);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al insertar la carta de presentacion: " . $e->getMessage();
        }
        }
    
        // Descargar el archivo
        function descargarCarta($variabledef) 
        {
            // Preparar la consulta para extraer la carta
            $query = "SELECT carta_de_presentacion FROM documentos WHERE id_proyecto_activo = :variabledef";
            $stmt = $this->conn->prepare($query);
          
            // Vincular el valor del identificador del proyecto activo
            $stmt->bindParam(":variabledef", $variabledef);
          
            // Ejecutar la consulta
            $stmt->execute();
          
            // Obtener el resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
          
            // Verificar si se obtuvo un resultado
            if ($result) {
              // Extraer la carta
              $cartapres = $result['carta_de_presentacion'];
          
              // Verificar si la carta se extrajo correctamente
              if ($cartapres) {
          
                // Ruta del pdf
                $file = "documents/carta_de_presentacion.pdf";
          
                // Guardar la carta en un archivo
                file_put_contents($file, $cartapres);
          
                // Verificar si el archivo se guardó correctamente
                if (file_exists("carta_de_presentacion.pdf")) {
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

    class Com_Rev 
    {
        private $conn;
      
        public function __construct($conn) 
        {
          $this->conn = $conn;
        }

        // Insercion de la carta de presentacion
        function insertarComRev($variabledef, $comision_file) 
        {
          // Obtener el contenido del archivo
          $com_rev = file_get_contents($comision_file);
      
          try {
              // Preparar la consulta SQL para insertar la comision de revisor
              $sql = "SELECT insertar_comision_revisor(:variabledef, :comision)";
              $stmt = $this->conn->prepare($sql);
              $stmt->bindParam(':variabledef', $variabledef, PDO::PARAM_INT);
              $stmt->bindParam(':comision', $com_rev, PDO::PARAM_LOB);
              $stmt->execute();
          } catch (PDOException $e) {
              echo "Error al insertar la comision de revisor: " . $e->getMessage();
          }
        }
    
        // Descargar el archivo
        function descargarComRev($variabledef) 
        {
          // Preparar la consulta para extraer la carta
          $query = "SELECT comision_revisor FROM documentos WHERE id_proyecto_activo = :variabledef";
          $stmt = $this->conn->prepare($query);
        
          // Vincular el valor del identificador del proyecto activo
          $stmt->bindParam(":variabledef", $variabledef);
        
          // Ejecutar la consulta
          $stmt->execute();
        
          // Obtener el resultado
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
          // Verificar si se obtuvo un resultado
          if ($result) {
            // Extraer la carta
            $comRev = $result['comision_revisor'];
        
            // Verificar si la carta se extrajo correctamente
            if ($comRev) {
        
              // Ruta del pdf
              $file = "documents/comision_revisor.pdf";
        
              // Guardar la carta en un archivo
              file_put_contents($file, $comRev);
        
              // Verificar si el archivo se guardó correctamente
              if (file_exists("comision_revisor.pdf")) {
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

    class Conv 
    {
        private $conn;
      
        public function __construct($conn) 
        {
          $this->conn = $conn;
        }

        // Insercion de la carta de presentacion
        function insertarConvenio($variabledef, $comision_file) 
        {
          // Obtener el contenido del archivo
          $conv = file_get_contents($comision_file);
      
          try {
              // Preparar la consulta SQL para insertar el formato de convenio
              $sql = "SELECT insertar_formato_de_convenio(:variabledef, :comision)";
              $stmt = $this->conn->prepare($sql);
              $stmt->bindParam(':variabledef', $variabledef, PDO::PARAM_INT);
              $stmt->bindParam(':comision', $conv, PDO::PARAM_LOB);
              $stmt->execute();
          } catch (PDOException $e) {
              echo "Error al insertar el formato de convenio: " . $e->getMessage();
          }
        }
    
        // Descargar el archivo
        function descargarConvenio($variabledef) 
        {
          // Preparar la consulta para extraer la carta
          $query = "SELECT formato_de_convenio FROM documentos WHERE id_proyecto_activo = :variabledef";
          $stmt = $this->conn->prepare($query);
        
          // Vincular el valor del identificador del proyecto activo
          $stmt->bindParam(":variabledef", $variabledef);
        
          // Ejecutar la consulta
          $stmt->execute();
        
          // Obtener el resultado
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
          // Verificar si se obtuvo un resultado
          if ($result) {
            // Extraer la carta
            $convenio = $result['formato_de_convenio'];
        
            // Verificar si la carta se extrajo correctamente
            if ($convenio) {
        
              // Ruta del pdf
              $file = "documents/formato_de_convenio.pdf";
        
              // Guardar la carta en un archivo
              file_put_contents($file, $convenio);
        
              // Verificar si el archivo se guardó correctamente
              if (file_exists("formato_de_convenio.pdf")) {
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

    // Eliminar archivos word, pdf y .bat
    function deleteFiles($variabledef) 
    {
        // Construye la ruta del archivo .bat correspondiente al número de control
        $batchFile = $variabledef . ".bat";
        
        // Construye la ruta del archivo .docx correspondiente al número de control
        $docFile = "doc/" . $variabledef . ".docx";
        
        // Construye la ruta del archivo .pdf correspondiente al número de control
        $pdfFile = "pdf/" . $variabledef . ".pdf";
        
        // Si el archivo .bat existe, lo borra utilizando la función unlink()
        if (file_exists($batchFile)) 
        {
          unlink($batchFile);
        }
        
        // Si el archivo .docx existe, lo borra utilizando la función unlink()
        if (file_exists($docFile)) 
        {
          unlink($docFile);
        }
        
        // Si el archivo .pdf existe, lo borra utilizando la función unlink()
        if (file_exists($pdfFile)) 
        {
          unlink($pdfFile);
        }  
    }
?>