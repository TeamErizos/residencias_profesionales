<?php

class Revision {
    private $conn;

    // Constructor que recibe la conexión $conn
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /* Función para buscar los alumnos que debe revisar el maestro
    * @@@input id_profesor
    * @@@output array_alumnos[] -> (id_p_x_a, id_proyecto y no_control)
    */
        public function buscarRegistrosAlumnoNoRevisado($id_profesor) {
            $registros = array();
        
            // Ejemplo de consulta para buscar registros en la tabla proyecto_x_alumno utilizando PDO
            $query = "SELECT id_p_x_a, id_proyecto, id_alumno FROM proyecto_x_alumno WHERE id_revisador = :id_profesor AND dictamen = false";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_profesor', $id_profesor, PDO::PARAM_INT);
            $stmt->execute();
        
            // Recuperar los resultados y guardar los valores en el array $registros
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $registros[] = array(
                    'id_p_x_a' => $row['id_p_x_a'],
                    'id_proyecto' => $row['id_proyecto'],
                    'id_alumno' => $row['id_alumno']
                );
            }
        
            return $registros;
        }
    

    /* Funcion para recuperar los nombres completos de los alumnos que van a participar
     * input array no_control[]
     * output array nombres_completos[]
    */
        public function obtenerNombresAlumnos($no_control) {
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

    /* Buscar el nombre del proyecto al que está postulando el alumno
    * @@@input array_id_proyecto
    * @@@output array_nombre_proyecto
    */
        public function buscarNombresProyectos($idProyectos) {
            $nombresProyectos = array();

            // Generar los marcadores de posición para los valores del array
            $parametros = implode(',', array_fill(0, count($idProyectos), '?'));

            // Preparar la consulta para buscar los nombres de proyectos en la tabla proyecto
            $query = "SELECT nombre_proyecto FROM proyecto WHERE id_proyecto IN ($parametros)";
            $stmt = $this->conn->prepare($query);

            // Asignar los valores de los parámetros
            $i = 1;
            foreach ($idProyectos as $id) {
                $stmt->bindValue($i++, $id, PDO::PARAM_INT);
            }

            $stmt->execute();

            // Recuperar los nombres de los proyectos y guardarlos en el array $nombresProyectos
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $nombresProyectos[] = $row['nombre_proyecto'];
            }

            return $nombresProyectos;
        }

    // Función para fusionar los arreglos
        function fusionarArreglos($arreglo1, $arreglo2, $arreglo3) {
            // Obtener el número total de registros
            $totalRegistros = count($arreglo1);
        
            // Crear el arreglo fusionado
            $arregloRevision = [];
        
            // Fusionar los arreglos
            for ($i = 0; $i < $totalRegistros; $i++) {
                $fusion = [
                    $arreglo1[$i],
                    $arreglo2[$i],
                    $arreglo3[$i]
                ];
                $arregloRevision[] = $fusion;
            }
        
            return $arregloRevision;
        }

    // Denegar la solicitud eliminando registros
    // @@ input id_p_x_a
    public function denegarSolicitud($id_proyecto_x_alumno) {
        // Eliminar el registro en la tabla proyecto_x_alumno
        $queryProyectoAlumno = "DELETE FROM proyecto_x_alumno WHERE id_p_x_a = :id_p_x_a";
        $stmtProyectoAlumno = $this->conn->prepare($queryProyectoAlumno);
        $stmtProyectoAlumno->bindParam(":id_p_x_a", $id_proyecto_x_alumno);
        $stmtProyectoAlumno->execute();

        // Eliminar el registro en la tabla documentos
        $queryDocumentos = "DELETE FROM documentos WHERE id_proyecto_activo = :id_proyecto_activo";
        $stmtDocumentos = $this->conn->prepare($queryDocumentos);
        $stmtDocumentos->bindParam(":id_proyecto_activo", $id_proyecto_x_alumno);
        $stmtDocumentos->execute();

        // Verificar si se eliminaron los registros correctamente
        if ($stmtProyectoAlumno->rowCount() > 0 && $stmtDocumentos->rowCount() > 0) {
            echo "Solicitud denegada y registros eliminados correctamente.";
        } else {
            echo "No se encontraron registros para eliminar.";
        }
    }

    // Aceptar la solicitud eliminando 
    public function aceptarSolicitud($idSeleccionado) {
        // Preparar la llamada a la función de PostgreSQL
        $query = "SELECT public.update_dictamen(:id)";
        $stmt = $this->conn->prepare($query);

        // Vincular el valor del ID seleccionado
        $stmt->bindParam(":id", $idSeleccionado);

        // Ejecutar la función
        $stmt->execute();

        // Puedes realizar operaciones adicionales después de la ejecución de la función
        // Por ejemplo, mostrar un mensaje de confirmación
        echo "La solicitud con ID $idSeleccionado ha sido aceptada.";

        // Puedes devolver valores adicionales si los necesitas
        // Por ejemplo, puedes devolver el mensaje como una cadena
        // return "La solicitud con ID $idSeleccionado ha sido aceptada.";
    }

    // Eliminar archivos
    // @@ input $clave
    function eliminarArchivosPDF($clave) {
        $carpetas = array('anteproyecto', 'constancia', 'solicitud');
        
        foreach ($carpetas as $carpeta) {
            $archivo = $carpeta . '/' . $clave . '.pdf';
            
            if (file_exists($archivo)) {
                // Verificar si el archivo existe
                // Eliminar el archivo si existe
                unlink($archivo);
            } else {
                // Error message
                echo "No se encontró " . $archivo;

            }
        }
    }
    

}

?>
