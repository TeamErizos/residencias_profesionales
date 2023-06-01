<?php
    class Downloads 
    {
        private $conn;
      
        public function __construct($conn) 
        {
          $this->conn = $conn;
        }

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

        function descargarSolicitud($variabledef) 
        {
            // Preparar la consulta para extraer la carta
            $query = "SELECT solicitud_de_residencia FROM documentos WHERE id_proyecto_activo = :variabledef";
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
                $data = $result['solicitud_de_residencia'];

                // Verificar si los datos existen y son válidos
                if ($data) {
                    // Ruta y nombre del archivo
                    if (!file_exists('docs/')) {
                        mkdir('docs/', 0777, true);
                    }
                    $folder = 'docs/';
                    $fileName = 'solicitud_de_residencia.pdf';
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

        function descargarEval($variabledef) 
        {
            // Preparar la consulta para extraer la carta
            $query = "SELECT evaluacion_y_seguimiento FROM documentos WHERE id_proyecto_activo = :variabledef";
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
                $data = $result['evaluacion_y_seguimiento'];

                // Verificar si los datos existen y son válidos
                if ($data) {
                    // Ruta y nombre del archivo
                    if (!file_exists('docs/')) {
                        mkdir('docs/', 0777, true);
                    }
                    $folder = 'docs/';
                    $fileName = 'evaluacion_y_seguimiento.pdf';
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

        function descargarEvalReporteFinal($variabledef) 
        {
            // Preparar la consulta para extraer la carta
            $query = "SELECT evaluacion_reporte_final FROM documentos WHERE id_proyecto_activo = :variabledef";
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
                $data = $result['evaluacion_reporte_final'];

                // Verificar si los datos existen y son válidos
                if ($data) {
                    // Ruta y nombre del archivo
                    if (!file_exists('docs/')) {
                        mkdir('docs/', 0777, true);
                    }
                    $folder = 'docs/';
                    $fileName = 'evaluacion_reporte_final.pdf';
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

        function descargarAnte($variabledef) 
        {
            // Preparar la consulta para extraer la carta
            $query = "SELECT anteproyecto FROM documentos WHERE id_proyecto_activo = :variabledef";
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
                $data = $result['anteproyecto'];

                // Verificar si los datos existen y son válidos
                if ($data) {
                    // Ruta y nombre del archivo
                    if (!file_exists('docs/')) {
                        mkdir('docs/', 0777, true);
                    }
                    $folder = 'docs/';
                    $fileName = 'anteproyecto.pdf';
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

        function descargarConstancia($variabledef) 
        {
            // Preparar la consulta para extraer la carta
            $query = "SELECT constancia_de_residencia FROM documentos WHERE id_proyecto_activo = :variabledef";
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
                $data = $result['constancia_de_residencia'];

                // Verificar si los datos existen y son válidos
                if ($data) {
                    // Ruta y nombre del archivo
                    if (!file_exists('docs/')) {
                        mkdir('docs/', 0777, true);
                    }
                    $folder = 'docs/';
                    $fileName = 'constancia_de_residencia.pdf';
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

        function descargarReporteFinal($variabledef) 
        {
            // Preparar la consulta para extraer la carta
            $query = "SELECT reporte_final FROM documentos WHERE id_proyecto_activo = :variabledef";
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
                $data = $result['reporte_final'];

                // Verificar si los datos existen y son válidos
                if ($data) {
                    // Ruta y nombre del archivo
                    if (!file_exists('docs/')) {
                        mkdir('docs/', 0777, true);
                    }
                    $folder = 'docs/';
                    $fileName = 'reporte_final.pdf';
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

        // Eliminar archivos word, pdf y .bat
        function deleteFiles($variabledef) 
        {
            // Construye la ruta del archivo .docx correspondiente al número de control
            $docFile = "docs/" . $variabledef . ".pdf";
            
            // Si el archivo .docx existe, lo borra utilizando la función unlink()
            if (file_exists($docFile)) 
            {
            unlink($docFile);
            }
        }
    }
?>