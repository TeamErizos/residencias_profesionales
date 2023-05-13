<?php

// Funciones para crear un arreglo con los nombres de los proyectos
// y el asesor interno agregado, siempre y cuando el campo asesor_asignado
// Sea nulo

class Proyecto {
    private $conn;
  
    public function __construct($conn) {
      $this->conn = $conn;
    }

    // Funcion para recuperar todos los registros de asesorXproyecto mientras el campo
    // asesor_asignado sea falso (@@output arreglo[])
    function obtenerProyectosSinAsesor() {
      // Array para almacenar los resultados
      $proyectos = array();
  
      try {
          // Consulta SQL para obtener los proyectos sin asesor asignado
          $query = "SELECT DISTINCT ap.id_proyecto, ap.id_asesor_interno 
                    FROM asesor_x_proyecto ap
                    INNER JOIN proyecto_x_alumno pa ON ap.id_proyecto = pa.id_proyecto
                    WHERE ap.asesor_asignado = false";
  
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
  
          // Obtener los resultados en un arreglo asociativo
          $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
          // Recorrer los resultados y agregarlos al arreglo de proyectos
          foreach ($resultados as $resultado) {
              $proyecto = array(
                  'id_proyecto' => $resultado['id_proyecto'],
                  'id_asesor_interno' => $resultado['id_asesor_interno']
              );
              $proyectos[] = $proyecto;
          }
      } catch (PDOException $e) {
          // Manejo de excepciones
          echo "Error: " . $e->getMessage();
      }
  
      // Devolver el arreglo de proyectos
      return $proyectos;
  }
  
  
  
    /* Función para buscar el nombre del proyecto
    ** input proyectos[]
    ** output nombre_proyectos[]
    */
    function obtenerNombreProyectos($proyectos) {
        // Array para almacenar los resultados
        $nombresProyectos = array();
      
        try {
      
          // Preparar la consulta para obtener el nombre del proyecto
          $query = "SELECT nombre_proyecto FROM proyecto WHERE id_proyecto = :id_proyecto";
          $stmt = $this->conn->prepare($query);
          
          // Recorrer el arreglo de proyectos
          foreach ($proyectos as $proyecto) {
            // Vincular el parámetro de id_proyecto en la consulta
            $stmt->bindParam(":id_proyecto", $proyecto['id_proyecto']);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener el resultado
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Agregar el nombre del proyecto al arreglo
            $nombresProyectos[] = $resultado['nombre_proyecto'];
          }
        } catch (PDOException $e) {
          // Manejo de excepciones
          echo "Error: " . $e->getMessage();
        }
      
        // Devolver el arreglo de nombres de proyectos
        return $nombresProyectos;
      }
      

    /* Función para buscar el nombre completo de los asesores
    ** input proyectos[]
    ** output nombre_asesores[]
    */
      function obtenerNombreCompletoAsesores($proyectos) {
        // Array para almacenar los resultados
        $nombresAsesores = array();
      
        try {
          // Preparar la consulta para obtener el nombre completo del asesor
          $query = "SELECT nom_profesor, ape1_profesor, ape2_profesor FROM profesor WHERE id_profesor = :id_profesor";
          $stmt = $this->conn->prepare($query);
          
          // Recorrer el arreglo de proyectos
          foreach ($proyectos as $proyecto) {
            // Vincular el parámetro de id_asesor_interno en la consulta
            $stmt->bindParam(":id_profesor", $proyecto['id_asesor_interno']);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener el resultado
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Construir el nombre completo del asesor
            $nombreCompleto = $resultado['nom_profesor'] . " " . $resultado['ape1_profesor'] . " " . $resultado['ape2_profesor'];
            
            // Agregar el nombre completo del asesor al arreglo
            $nombresAsesores[] = $nombreCompleto;
          }
        } catch (PDOException $e) {
          // Manejo de excepciones
          echo "Error: " . $e->getMessage();
        }
      
        // Devolver el arreglo de nombres completos de asesores
        return $nombresAsesores;
      }

      /* Función para obtener los nombres de los profesores que pueden ser 
      * el nuevo asesor del proyecto
      * input id_proyecto
      * output nombres_profes[]
      */ 
      function obtenerProfesoresDisponibles($idProyecto) {
        $profesores = array();
    
        try {
            // Consulta SQL para obtener las claves únicas de profesores disponibles
            $query = "SELECT DISTINCT p.id_profesor, p.nom_profesor, p.ape1_profesor, p.ape2_profesor
                      FROM profesor p
                      INNER JOIN carrera_x_profesor cp ON p.id_profesor = cp.id_profesor
                      INNER JOIN carrera_x_proyecto cpj ON cp.id_carrera = cpj.id_carrera
                      WHERE cpj.id_proyecto = :id_proyecto";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id_proyecto", $idProyecto);
            $stmt->execute();
    
            // Obtener los resultados en un arreglo asociativo
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Construir el arreglo de profesores con su ID y nombre completo
            foreach ($resultados as $resultado) {
                $profesor = array(
                    'id_profesor' => $resultado['id_profesor'],
                    'nombre_completo' => $resultado['nom_profesor'] . " " . $resultado['ape1_profesor'] . " " . $resultado['ape2_profesor']
                );
                $profesores[] = $profesor;
            }
        } catch (PDOException $e) {
            // Manejo de excepciones
            echo "Error: " . $e->getMessage();
        }
    
        // Devolver el arreglo de profesores con su ID y nombre completo
        return $profesores;
    }

}


?>