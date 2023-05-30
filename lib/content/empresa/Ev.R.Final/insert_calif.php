<?php

class Calificaciones
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Función para insertar calificación parcial 1 del asesor interno
    public function insertarCalifParcial1AsesorInterno($p_x_a_id, $calif_par1_inter)
    {
        $stmt = $this->conn->prepare("SELECT insertar_calif_parcial1_asesor_interno(:p_x_a_id, :calif_par1_inter)");
        $stmt->bindParam(':p_x_a_id', $p_x_a_id);
        $stmt->bindParam(':calif_par1_inter', $calif_par1_inter, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);

        // Ejecutar la consulta
        $stmt->execute();
    }

    // Función para insertar calificación parcial 1 del asesor externo
    public function insertarCalifParcial1AsesorExterno($p_x_a_id, $calif_par1_exter)
    {
        $stmt = $this->conn->prepare("SELECT insertar_calif_parcial1_asesor_externo(:p_x_a_id, :calif_par1_exter)");
        $stmt->bindParam(':p_x_a_id', $p_x_a_id);
        $stmt->bindParam(':calif_par1_exter', $calif_par1_exter, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();
    }

    // Función para insertar calificación parcial 2 del asesor interno
    public function insertarCalifParcial2AsesorInterno($p_x_a_id, $calif_par2_inter)
    {
        $stmt = $this->conn->prepare("SELECT insertar_calif_parcial2_asesor_interno(:p_x_a_id, :calif_par2_inter)");
        $stmt->bindParam(':p_x_a_id', $p_x_a_id);
        $stmt->bindParam(':calif_par2_inter', $calif_par2_inter, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();
    }

    // Función para insertar calificación parcial 2 del asesor externo
    public function insertarCalifParcial2AsesorExterno($p_x_a_id, $calif_par2_exter)
    {
        $stmt = $this->conn->prepare("SELECT insertar_calif_parcial2_asesor_externo(:p_x_a_id, :calif_par2_exter)");
        $stmt->bindParam(':p_x_a_id', $p_x_a_id);
        $stmt->bindParam(':calif_par2_exter', $calif_par2_exter, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();
    }

    // Función para insertar calificación final del asesor interno
    public function insertarCalifReporteFinAsesorInterno($p_x_a_id, $calif_final_inter)
    {
        $stmt = $this->conn->prepare("SELECT insertar_calif_reporte_asesor_interno(:p_x_a_id, :calif_final_inter)");
        $stmt->bindParam(':p_x_a_id', $p_x_a_id);
        $stmt->bindParam(':calif_final_inter', $calif_final_inter, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();
    }

    // Función para insertar calificación final del asesor externo
    public function insertarCalifReporteFinAsesorExterno($p_x_a_id, $calif_final_exter)
    {
        $stmt = $this->conn->prepare("SELECT insertar_calif_reporte_asesor_externo(:p_x_a_id, :calif_final_exter)");
        $stmt->bindParam(':p_x_a_id', $p_x_a_id);
        $stmt->bindParam(':calif_final_exter', $calif_final_exter, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();
    }

    public function obtenerPromedioCalificaciones($p_x_a_id)
    {
        // Preparar consulta para obtener los campos de la tabla
        $stmt = $this->conn->prepare("SELECT calif_reporte_asesor_interno, calif_reporte_asesor_externo FROM Proyecto_X_Alumno WHERE id_p_x_a = :p_x_a_id");
        $stmt->bindParam(':p_x_a_id', $p_x_a_id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el registro
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si ambos campos tienen valores
        if (isset($registro['calif_reporte_asesor_interno']) && isset($registro['calif_reporte_asesor_externo'])) {

            // Decodificar los campos a arreglos
            $calif_reporte_asesor_interno = str_getcsv(trim($registro['calif_reporte_asesor_interno'], '{}'));
            $calif_reporte_asesor_externo = str_getcsv(trim($registro['calif_reporte_asesor_externo'], '{}'));

            // Obtener los últimos elementos de los arreglos
            $calif_inter = end($calif_reporte_asesor_interno);
            $calif_exter = end($calif_reporte_asesor_externo);

            // Calcular el promedio
            $promedio = ($calif_inter + $calif_exter) / 2;

            return array(
                'calif_reporte_asesor_interno' => $calif_reporte_asesor_interno,
                'calif_reporte_asesor_externo' => $calif_reporte_asesor_externo,
                'promedio' => $promedio,
                'sumaInterno' => $calif_inter,
                'sumaExterno' => $calif_exter
            );
        } else {
            // Si uno o ambos campos están vacíos, devuelve un arreglo asociativo con valores nulos
            return array(
                'calif_reporte_asesor_interno' => null,
                'calif_reporte_asesor_externo' => null,
                'promedio' => null,
                'sumaInterno' => null,
                'sumaExterno' => null
            );
        }
    }


    public function obtenerDatosAlumnos($p_x_a_id)
    {
        try {
            $query = "SELECT Proyecto_X_Alumno.id_p_x_a, Alumno.no_control, Alumno.nombre_alumno, Alumno.ape1_alumno, Alumno.ape2_alumno, Proyecto.nombre_proyecto
                  FROM Alumno
                  INNER JOIN Proyecto_X_Alumno ON Alumno.no_control = Proyecto_X_Alumno.id_alumno
                  INNER JOIN Proyecto ON Proyecto_X_Alumno.id_proyecto = Proyecto.id_proyecto
                  WHERE Proyecto_X_Alumno.id_p_x_a = :p_x_a_id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':p_x_a_id', $p_x_a_id, PDO::PARAM_INT);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerIDProyectoXAlumno()
    {
        try {
            $query = "SELECT id_p_x_a FROM Proyecto_X_Alumno";
            $stmt = $this->conn->query($query);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultados;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function existeCalificacionRepExt($p_x_a_id)
    {
        try {
            // Preparar la consulta
            $stmt = $this->conn->prepare("SELECT * FROM Proyecto_X_Alumno WHERE id_p_x_a = :id_p_x_a AND calif_reporte_asesor_externo IS NOT NULL");

            // Ejecutar la consulta
            $stmt->execute([':id_p_x_a' => $p_x_a_id]);

            // Verificar si la consulta devolvió algún resultado
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Mostrar mensaje de error si algo sale mal
            echo "Error: " . $e->getMessage();
            die();
        }
    }

    public function existeCalificacionRepInt($p_x_a_id)
    {
        try {
            // Preparar la consulta
            $stmt = $this->conn->prepare("SELECT * FROM Proyecto_X_Alumno WHERE id_p_x_a = :id_p_x_a AND calif_reporte_asesor_interno IS NOT NULL");

            // Ejecutar la consulta
            $stmt->execute([':id_p_x_a' => $p_x_a_id]);

            // Verificar si la consulta devolvió algún resultado
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Mostrar mensaje de error si algo sale mal
            echo "Error: " . $e->getMessage();
            die();
        }
    }

    public function existeCalificacionPar1Ext($p_x_a_id)
    {
        try {
            // Preparar la consulta
            $stmt = $this->conn->prepare("SELECT * FROM Proyecto_X_Alumno WHERE id_p_x_a = :id_p_x_a AND calif_parcial1_asesor_externo IS NOT NULL");

            // Ejecutar la consulta
            $stmt->execute([':id_p_x_a' => $p_x_a_id]);

            // Verificar si la consulta devolvió algún resultado
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Mostrar mensaje de error si algo sale mal
            echo "Error: " . $e->getMessage();
            die();
        }
    }

    public function existeCalificacionPar2Ext($p_x_a_id)
    {
        try {
            // Preparar la consulta
            $stmt = $this->conn->prepare("SELECT * FROM Proyecto_X_Alumno WHERE id_p_x_a = :id_p_x_a AND calif_parcial2_asesor_externo IS NOT NULL");

            // Ejecutar la consulta
            $stmt->execute([':id_p_x_a' => $p_x_a_id]);

            // Verificar si la consulta devolvió algún resultado
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Mostrar mensaje de error si algo sale mal
            echo "Error: " . $e->getMessage();
            die();
        }
    }

    public function existeCalificacionPar1Int($p_x_a_id)
    {
        try {
            // Preparar la consulta
            $stmt = $this->conn->prepare("SELECT * FROM Proyecto_X_Alumno WHERE id_p_x_a = :id_p_x_a AND calif_parcial1_asesor_interno IS NOT NULL");

            // Ejecutar la consulta
            $stmt->execute([':id_p_x_a' => $p_x_a_id]);

            // Verificar si la consulta devolvió algún resultado
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Mostrar mensaje de error si algo sale mal
            echo "Error: " . $e->getMessage();
            die();
        }
    }

    public function existeCalificacionPar2Int($p_x_a_id)
    {
        try {
            // Preparar la consulta
            $stmt = $this->conn->prepare("SELECT * FROM Proyecto_X_Alumno WHERE id_p_x_a = :id_p_x_a AND calif_parcial2_asesor_interno IS NOT NULL");

            // Ejecutar la consulta
            $stmt->execute([':id_p_x_a' => $p_x_a_id]);

            // Verificar si la consulta devolvió algún resultado
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Mostrar mensaje de error si algo sale mal
            echo "Error: " . $e->getMessage();
            die();
        }
    }

    public function obtenerDatosTodo($id_p_x_a)
    {
        $query = "SELECT Alumno.nombre_alumno, Alumno.no_control, Proyecto.nombre_proyecto, Carrera.nom_carrera, Proyecto_X_Alumno.periodo_0_sem,
              Asesor_X_Proyecto.nom_asesor_externo, Asesor_X_Proyecto.ape1_asesor_externo, Asesor_X_Proyecto.ape2_asesor_externo,
              Profesor.nom_profesor, Profesor.ape1_profesor, Profesor.ape2_profesor
              FROM Alumno
              INNER JOIN Proyecto_X_Alumno ON Alumno.no_control = Proyecto_X_Alumno.id_alumno
              INNER JOIN Proyecto ON Proyecto_X_Alumno.id_proyecto = Proyecto.id_proyecto
              INNER JOIN Carrera ON Alumno.fk_id_carrera = Carrera.id_carrera
              LEFT JOIN Asesor_X_Proyecto ON Proyecto.id_proyecto = Asesor_X_Proyecto.id_proyecto
              LEFT JOIN Profesor ON Asesor_X_Proyecto.id_asesor_interno = Profesor.id_profesor
              WHERE Proyecto_X_Alumno.id_p_x_a = :id_p_x_a";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_p_x_a', $id_p_x_a, PDO::PARAM_INT);
        $stmt->execute();

        $resultados = $stmt->fetch(PDO::FETCH_ASSOC);

        // Comprobar si la consulta devolvió algún resultado
        if (!$resultados) {
            throw new Exception("obtenerDatosAlumno no devolvió resultados");
        }

        return $resultados;
    }


    function createPDF($id_p_x_a)
    {
        // Verificar si existe el archivo .docx
        $docx_file = "Docs/" . $id_p_x_a . ".docx";
        if (!file_exists($docx_file)) {
            echo "El archivo .docx no existe.";
            return;
        }

        // Cada archivo (doc, pdf, bat, tendrá la id)
        $batchFile = $id_p_x_a . ".bat";

        // El contenido del script creará un pdf único a partir de un word único
        $command = "soffice --headless --convert-to pdf Docs/" . $id_p_x_a . ".docx --outdir Pdfs/"; // cada archivo tendrá el No Control del alumno
        //$command = "soffice --version";
        //echo $command;

        print_r($command);
        // Guardar el archivo 
        file_put_contents($batchFile, $command);

        // Ejecutar el código y crear el pdf
        exec($batchFile, $output, $return);

        if ($return == 0) {
            echo "Command ran successfully";
        } else {
            echo "Command failed";
        }

        return "Pdfs/" . $id_p_x_a . ".pdf";
    }


    // Eliminar archivos, el word, el pdf y el .bat
    function deleteFiles($id_p_x_a)
    {
        // Construye la ruta del archivo .bat correspondiente al id
        $batchFile = $id_p_x_a . ".bat";

        // Construye la ruta del archivo .docx correspondiente al id
        $docFile = "Docs/" . $id_p_x_a . ".docx";

        // Construye la ruta del archivo .pdf correspondiente al id
        $pdfFile = "Pdfs/" . $id_p_x_a . ".pdf";

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


    // Insercion de constancia
    function insertarEvaRepoFinal($id_p_x_a, $ReporteFinal_file)
    {
        // Obtener el contenido del archivo
        $Reporte = file_get_contents($ReporteFinal_file);

        try {
            // Preparar la consulta SQL para insertar la constancia de residencia
            $sql = "SELECT insertar_evaluacion_reporte_final(:id_p_x_a, :ReporteFinal_file)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_p_x_a', $id_p_x_a, PDO::PARAM_INT);
            $stmt->bindParam(':ReporteFinal_file', $Reporte, PDO::PARAM_LOB);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al insertar el reporte de residencia: " . $e->getMessage();
        }
    }

    // Descargar la comision en el asesor (en el servidor)
    function descargarReporteFinal($id_p_x_a)
    {

        // Preparar la consulta para extraer el anteproyecto
        $query = "SELECT evaluacion_reporte_final FROM documentos WHERE id_proyecto_activo = :id_p_x_a";
        $stmt = $this->conn->prepare($query);

        // Vincular el valor del identificador del proyecto activo
        $stmt->bindParam(":id_p_x_a", $id_p_x_a);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);



        // Verificar si se obtuvo un resultado
        if ($result) {
            // Extraer el reporte
            $ArchivoReporte = $result['evaluacion_reporte_final'];

            // Verificar si el reporte se extrajo correctamente
            if ($ArchivoReporte) {

                // Ruta del pdf
                $file = "Docs/" . $id_p_x_a . "_Reporte_Final.pdf";

                // Guardar el reporte en un archivo
                file_put_contents($file, $ArchivoReporte);

                // Verificar si el archivo se guardó correctamente
                if (file_exists($id_p_x_a . "_Reporte_Final.pdf")) {
                    echo "El archivo se extrajo y guardó correctamente.";
                    return $file;
                } else {
                    echo "No se pudo guardar el archivo.";
                }
            } else {
                echo "No se pudo extraer el reporte.";
            }
        } else {
            echo "No se encontró el reporte.";
        }

        return false;
    }


    public function obtenerCalificaciones($id_p_x_a)
    {
        try {
            $query = "SELECT calif_reporte_asesor_externo, calif_reporte_asesor_interno
              FROM Proyecto_X_Alumno
              WHERE id_p_x_a = :id_p_x_a";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_p_x_a', $id_p_x_a, PDO::PARAM_INT);
            $stmt->execute();

            $resultados = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultados) {
                $calificaciones_externo = str_replace(array('{', '}'), '', $resultados['calif_reporte_asesor_externo']);
                $calificaciones_externo_array = explode(',', $calificaciones_externo);

                $calificaciones_interno = str_replace(array('{', '}'), '', $resultados['calif_reporte_asesor_interno']);
                $calificaciones_interno_array = explode(',', $calificaciones_interno);

                return array(
                    'calificaciones_externo' => $calificaciones_externo_array,
                    'calificaciones_interno' => $calificaciones_interno_array
                );
            } else {
                echo "No se encontraron calificaciones para el id proporcionado.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}
