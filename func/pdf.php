<?php
    
    //Crear los PDFs
    function createPDF($variabledef)
    {
      // Definir el folder doc
      $folderPath = 'doc/';

      // Ruta y nombre del archivo
      if (!file_exists('pdf/')) {
        mkdir('pdf/', 0777, true);
      } 
      // Definir el folder pdf
      $folderPathPDF = 'pdf/';

      // Verificar si existe el archivo .docx
      $docx_file = $folderPath . $variabledef . ".docx";
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

      return $folderPathPDF . $variabledef . ".pdf";
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
            // Definir el folder doc
            $folderPath = 'doc/';

            // Check if the folder doc exists
            if (!is_dir($folderPath)) {
                // Folder doesn't exist, create it
                mkdir($folderPath, 0777, true);
                echo 'Folder created.';
            }

            // Ruta y nombre del archivo
            if (!file_exists('docs/')) {
                mkdir('docs/', 0777, true);
            }
            $folder = 'docs/';
            $fileName = 'dictamen_anteproyecto.pdf';
            $filePath = $folder . $fileName;

            // Verificar si existe el archivo .docx
            $docx_file = $folderPath . $variabledef . ".docx";
            if (!file_exists($docx_file)) 
            {
                echo "El archivo .docx no existe.";
                return;
            }

            // Cada archivo (doc, pdf, bat, tendrá el No Control)
            $batchFile = $variabledef . ".bat";

            // El contenido del script creará un pdf único a partir de un word único
            $command = "soffice --headless --convert-to pdf doc/" . $variabledef . ".docx --outdir docs/"; // cada archivo tendrá el No Control del alumno

            // Guardar el archivo 
            file_put_contents($batchFile, $command);
            
            // Ejecutar el código y crear el pdf
            exec($batchFile, $output, $return);
            
            // Verificar si el archivo se guardó correctamente
            if (file_exists($filePath)) 
            {
                // Establecer las cabeceras para descargar el archivo
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                header('Content-Length: ' . filesize($filePath));

                // Salida del contenido del archivo
                readfile($filePath);
            } 
            else 
            {
                echo "No se pudo guardar el archivo.";
            }
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
            if ($result) 
            {
                // Extraer los datos
                $data = $result['carta_de_presentacion'];

                // Verificar si los datos existen y son válidos
                if ($data) {
                    // Ruta y nombre del archivo
                    if (!file_exists('docs/')) {
                        mkdir('docs/', 0777, true);
                    }
                    $folder = 'docs/';
                    $fileName = 'carta_de_presentacion.pdf';
                    $filePath = $folder . $fileName;

                    // Guardar los datos en un archivo PDF
                    file_put_contents($filePath, $data);

                    // Verificar si el archivo se guardó correctamente
                    if (file_exists($filePath)) {
                    // Establecer las cabeceras para descargar el archivo
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . $fileName . '"');
                    header('Content-Length: ' . filesize($filePath));

                    // Salida del contenido del archivo
                    readfile($filePath);
                    } else {
                    echo "No se pudo guardar el archivo.";
                    }
                } else {
                    echo "Los datos no son válidos.";
                }
            } 
            else 
            {
                echo "No se encontraron datos.";
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
          if ($result) 
          {
              // Extraer los datos
              $data = $result['comision_revisor'];

              // Verificar si los datos existen y son válidos
              if ($data) {
                  // Ruta y nombre del archivo
                  if (!file_exists('docs/')) {
                      mkdir('docs/', 0777, true);
                  }
                  $folder = 'docs/';
                  $fileName = 'comision_revisor.pdf';
                  $filePath = $folder . $fileName;

                  // Guardar los datos en un archivo PDF
                  file_put_contents($filePath, $data);

                  // Verificar si el archivo se guardó correctamente
                  if (file_exists($filePath)) {
                  // Establecer las cabeceras para descargar el archivo
                  header('Content-Type: application/octet-stream');
                  header('Content-Disposition: attachment; filename="' . $fileName . '"');
                  header('Content-Length: ' . filesize($filePath));

                  // Salida del contenido del archivo
                  readfile($filePath);
                  } else {
                  echo "No se pudo guardar el archivo.";
                  }
              } else {
                  echo "Los datos no son válidos.";
              }
          } 
          else 
          {
              echo "No se encontraron datos.";
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
          if ($result) 
          {
              // Extraer los datos
              $data = $result['formato_de_convenio'];

              // Verificar si los datos existen y son válidos
              if ($data) {
                  // Ruta y nombre del archivo
                  if (!file_exists('docs/')) {
                      mkdir('docs/', 0777, true);
                  }
                  $folder = 'docs/';
                  $fileName = 'formato_de_convenio.pdf';
                  $filePath = $folder . $fileName;

                  // Guardar los datos en un archivo PDF
                  file_put_contents($filePath, $data);

                  // Verificar si el archivo se guardó correctamente
                  if (file_exists($filePath)) {
                  // Establecer las cabeceras para descargar el archivo
                  header('Content-Type: application/octet-stream');
                  header('Content-Disposition: attachment; filename="' . $fileName . '"');
                  header('Content-Length: ' . filesize($filePath));

                  // Salida del contenido del archivo
                  readfile($filePath);
                  } else {
                  echo "No se pudo guardar el archivo.";
                  }
              } else {
                  echo "Los datos no son válidos.";
              }
          } 
          else 
          {
              echo "No se encontraron datos.";
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

        // Construye la ruta del archivo .pdf correspondiente al número de control
        $pdfFile2 = "docs/" . $variabledef . ".pdf";

        // Construye la ruta del archivo .docx correspondiente al número de control
        $docFile2 = "documents/" . $variabledef . ".docx";
        
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

        // Si el archivo .docx existe, lo borra utilizando la función unlink()
        if (file_exists($docFile2)) 
        {
          unlink($docFile2);
        }
        
        // Si el archivo .pdf existe, lo borra utilizando la función unlink()
        if (file_exists($pdfFile)) 
        {
          unlink($pdfFile);
        }

        // Si el archivo .pdf existe, lo borra utilizando la función unlink()
        if (file_exists($pdfFile2)) 
        {
          unlink($pdfFile2);
        }  
    }
?>