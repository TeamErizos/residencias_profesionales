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
        $stmt = $this->conn->prepare("SELECT calif_parcial1_asesor_externo, calif_parcial1_asesor_interno, calif_parcial2_asesor_interno, calif_parcial2_asesor_externo FROM Proyecto_X_Alumno WHERE id_p_x_a = :p_x_a_id");
        $stmt->bindParam(':p_x_a_id', $p_x_a_id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el registro
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si ambos campos tienen valores
        if (isset($registro['calif_parcial1_asesor_interno'], $registro['calif_parcial1_asesor_externo'], $registro['calif_parcial2_asesor_interno'], $registro['calif_parcial2_asesor_externo'])) {

            // Decodificar los campos a arreglos
            $calif_parcial1_asesor_interno = str_getcsv(trim($registro['calif_parcial1_asesor_interno'], '{}'));
            $calif_parcial1_asesor_externo = str_getcsv(trim($registro['calif_parcial1_asesor_externo'], '{}'));
            $calif_parcial2_asesor_interno = str_getcsv(trim($registro['calif_parcial2_asesor_interno'], '{}'));
            $calif_parcial2_asesor_externo = str_getcsv(trim($registro['calif_parcial2_asesor_externo'], '{}'));


            // Obtener los últimos elementos de los arreglos
            $calif_inter_p1 = end($calif_parcial1_asesor_interno);
            $calif_exter_p1 = end($calif_parcial1_asesor_externo);
            $calif_inter_p2 = end($calif_parcial2_asesor_interno);
            $calif_exter_p2 = end($calif_parcial2_asesor_externo);

            // Calcular el promedio
            $promedio = ($calif_inter_p1 + $calif_exter_p1 + $calif_inter_p2 + $calif_exter_p2) / 4;

            return array(
                'calif_parcial1_asesor_interno' => $calif_parcial1_asesor_interno,
                'calif_parcial1_asesor_externo' => $calif_parcial1_asesor_externo,
                'calif_parcial2_asesor_interno' => $calif_parcial2_asesor_interno,
                'calif_parcial2_asesor_externo' => $calif_parcial2_asesor_externo,
                'promedio' => $promedio
            );
        } else {
            // Si uno o ambos campos están vacíos, devuelve un arreglo asociativo con valores nulos
            return array(
                'calif_parcial1_asesor_interno' => null,
                'calif_parcial1_asesor_externo' => null,
                'calif_parcial2_asesor_interno' => null,
                'calif_parcial2_asesor_externo' => null,

                'promedio' => null
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
        $query = "SELECT Alumno.nombre_alumno, Alumno.no_control, Proyecto.nombre_proyecto, Carrera.nom_carrera, Proyecto_X_Alumno.periodo_0_sem
        FROM Alumno
        INNER JOIN Proyecto_X_Alumno ON Alumno.no_control = Proyecto_X_Alumno.id_alumno
        INNER JOIN Proyecto ON Proyecto_X_Alumno.id_proyecto = Proyecto.id_proyecto
        INNER JOIN Carrera ON Alumno.fk_id_carrera = Carrera.id_carrera
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
}
