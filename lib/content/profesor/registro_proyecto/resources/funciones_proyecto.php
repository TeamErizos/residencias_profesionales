<?php

class Proyecto {
    private $conn;

    function __construct($conexion) {
        $this->conn = $conexion;
    }

    // Insertar un Proyecto a la Base de Datos de forma segura
    function insertarProyecto($p_nom, $p_obj, $p_tipo, $p_origen, $p_num, $p_desc, $p_imp, $p_fk_emp, $p_fk_prof) {
        try {

            // TODO:
            // El formulario igual debe recibir que carreras van a aplicar para este proyecto
            // Es decir, hay que buscar como agregar carreras
            // 

            // Preparar la consulta con parámetros con nombre
            $query = "SELECT insertar_proyecto(:nombre, :objetivo, :tipo, :origen, :periodo, :num, :descri, :importancia, :id_emp, :id_prof)";
            $stmt = $this->conn->prepare($query);

            // Vincular los valores de los parámetros
            $stmt->bindParam(':nombre', $p_nom);
            $stmt->bindParam(':objetivo', $p_obj);
            $stmt->bindParam(':tipo', $p_tipo);
            $stmt->bindParam(':origen', $p_origen);
            // El periodo no contiene valores
            // Borrar
            $p_periodo = '0';
            $stmt->bindParam(':periodo', $p_periodo);
            $stmt->bindParam(':num', $p_num);
            $stmt->bindParam(':descri', $p_desc);
            $stmt->bindParam(':importancia', $p_imp);
            $stmt->bindParam(':id_emp', $p_fk_emp);
            $stmt->bindParam(':id_prof', $p_fk_prof);
    
            // Ejecutar la consulta y obtener el número de filas afectadas
            $rowCount = $stmt->execute();
    
            // Verificar si la consulta se ejecutó correctamente
            if($rowCount > 0) {
                return true; // Se insertó el proyecto correctamente
            } else {
                throw new Exception('Error al insertar proyecto');
            }
    
        } catch (PDOException $e) {
            // Manejar excepciones de PDO
            throw new Exception('Error al insertar proyecto: ' . $e->getMessage());
        } catch (Exception $e) {
            // Manejar otras excepciones
            throw new Exception($e->getMessage());
        }
    }

    // Las siguientes dos funciones reciben como parametro un [ array de claves de carrera ]
    // el cual es obtenido de [SelectAsesor]

    // ----------------------------------------------------------

    // Función que recibe el array de las carreras seleccionadas
    // en FormProyecto y relacionar dichas carreras
    // con el proyecto en la tabla CarrerasXProyecto
    // (Solo puede usarse una vez guardados los datos del proyecto)

    // --------------------------------------------------------

    //  TODO: ¿Cómo recuperamos el id del proyecto una vez capturados los datos?

    function relacionarCarrerasConProyecto($id_proyecto, $carreras_seleccionadas) {
        // Preparar la consulta
        $query = "SELECT insertar_carrera_x_proyecto(?, ?)";
        $stmt = $this->conn->prepare($query);

         // Recorrer cada carrera seleccionada
        foreach ($carreras_seleccionadas as $carrera) {
            // Insertar un registro por la carrera:

            // Ingeniería en Administración : 373436
          if ($carrera == '373436') {
            
            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);

          }

            // Licenciatura en Administración : 407567
          if ($carrera == '407567') {
            
            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);

          }

            // Arquitectura : 906829
          if ($carrera == '906829') {
            
            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);

          }

            // Licenciatura en Biologia : 902922
          if ($carrera == '902922') {
            
            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);

          }

            // Ingeniería Civil : 897879
          if ($carrera == '897879') {

            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);
          
          }

           // Contador Publico : 696443
          if ($carrera == '696443') {
            
            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);

          }

            // Ingenieria Electrica : 297376
          if ($carrera == '297376') {
            
            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);

          }

            // Ingeniería en Gestion Empresarial : 279083
          if ($carrera == '279083') {

            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);
          
          }

            // Ingeniería en Sistemas Computacionales : 106261
          if ($carrera == '106261') {
            
            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);

          }

            // Ingeniería en Tecnologías de la Información y Comunicación : 174429
          if ($carrera == '174429') {
            
            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);

          }

            // Licenciatura en Turismo : 743202
          if ($carrera == '743202') {

            // Ejecutar la consulta si seleccionaron esta carrera
            $stmt->execute([$id_proyecto, $carrera]);

          }

        }
      }

      // Función que busca los profesores de una carrera
      // Según un [array con las claves de la carrera]

      function buscarProfesoresPorCarrera($carrera_ids) {
        // Convertir el array de IDs en una cadena separada por comas
        $carrera_ids_str = implode(',', $carrera_ids);
      
        // Crear la consulta SQL
        // Recibir el id y el nombre del profesor
          $query = "SELECT Profesor.id_profesor, CONCAT(Profesor.nom_profesor, ' ', Profesor.ape1_profesor, ' ', Profesor.ape2_profesor) AS nombre_completo
          FROM Profesor
          INNER JOIN Carrera_X_Profesor
          ON Profesor.id_profesor = Carrera_X_Profesor.id_profesor
          WHERE Carrera_X_Profesor.id_carrera IN ($carrera_ids_str)";

      
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
      
        // Ejecutar la consulta
        $stmt->execute();
      
        // Obtener los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Eliminar duplicados y mantener solo la primera ocurrencia de cada profesor
        $profesores_unicos = array_map("unserialize", array_unique(array_map("serialize", $resultados)));

        // Devolver los resultados sin duplicados
        return $profesores_unicos;
        
      }

      
      // Función que recupera todas las empresas
      // Y las ordenas en orden alfabetico
      function obtenerEmpresas() {
        // Se obtiene la conexión global a la base de datos
        global $conn;
    
        // Se prepara la consulta que selecciona todos los id y nombres de las empresas
        // ordenados primero por id y luego por nombre
        $query = "SELECT id_empresa, nombre_empresa FROM Empresa ORDER BY id_empresa, nombre_empresa";
    
        // Se prepara la consulta
        $stmt = $this->conn-> prepare($query);
    
        // Se ejecuta la consulta
        $stmt->execute();
    
        // Se retornan todos los resultados de la consulta
        return $stmt->fetchAll();
    }

    // Función para buscar el nombre del profesor segun su clave
    function obtenerNombreProfesor($id_profesor) {
      // Crear la consulta SQL
      $query = "SELECT CONCAT(Profesor.nom_profesor, ' ', Profesor.ape1_profesor, ' ', Profesor.ape2_profesor) AS nombre_completo
                FROM Profesor
                WHERE Profesor.id_profesor = :id_profesor";
  
      // Preparar la consulta
      $stmt = $this->conn->prepare($query);
  
      // Vincular los valores
      $stmt->bindParam(':id_profesor', $id_profesor);
  
      // Ejecutar la consulta
      $stmt->execute();
  
      // Obtener el resultado
      $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
  
      // Devolver el nombre completo
      return $resultado['nombre_completo'];
  }

  
  // Función para obtener la clave del proyecto segun
  // el nombre del Proyecto

  function obtenerIdProyectoPorNombre($nombre_proyecto) {
    // Crear la consulta SQL
    $query = "SELECT id_proyecto FROM proyecto WHERE nombre_proyecto = :nombre_proyecto";
  
    // Preparar la consulta
    $stmt = $this->conn->prepare($query);
    
    // Vincular los parámetros
    $stmt->bindParam(':nombre_proyecto', $nombre_proyecto, PDO::PARAM_STR);
  
    // Ejecutar la consulta
    $stmt->execute();
  
    // Obtener el resultado
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // Devolver el id del proyecto
    return $resultado['id_proyecto'];
  }

      // Funcion para insertar un registro en la tabla AsesoresXProyecto
      // con la clave del proyecto, del asesor interno y los datos del externo
      function insertarAsesoresEnProyecto($proyecto_id, $asesor_id, $a_x_p_nom, $a_x_p_ape1, $a_x_p_ape2, $a_x_p_puesto) {
        // Preparar la consulta
        $query = "SELECT insertar_asesor_x_proyecto(:proyecto_id, :asesor_id, :a_x_p_nom, :a_x_p_ape1, :a_x_p_ape2, :a_x_p_puesto)";
        $stmt = $this->conn->prepare($query);

        // Vincular los valores
        $stmt->bindParam(":proyecto_id", $proyecto_id);
        $stmt->bindParam(":asesor_id", $asesor_id);
        $stmt->bindParam(":a_x_p_nom", $a_x_p_nom);
        $stmt->bindParam(":a_x_p_ape1", $a_x_p_ape1);
        $stmt->bindParam(":a_x_p_ape2", $a_x_p_ape2);
        $stmt->bindParam(":a_x_p_puesto", $a_x_p_puesto);

        // Ejecutar la consulta
        $stmt->execute();
      }


    // Por el momento, no es necesaria esta función
    /*
    function obtenerNombreCarrera($claves) {
      // Inicializa un arreglo vacío para almacenar los nombres de las carreras
      $nombres = array();
      
      // Crea una consulta que seleccione los nombres de las carreras con las claves especificadas
      $query = "SELECT nom_carrera FROM carrera WHERE id_carrera IN (" . implode(',', $claves) . ")";
      
      // Ejecuta la consulta
      $result = $this->conn->query($query);
      
      // Recorre cada fila de resultados y agrega el nombre de la carrera al arreglo $nombres
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $nombres[] = $row['nom_carrera'];
      }
      
      // Retorna el arreglo de nombres
      return $nombres;
  }*/
  


}

  

?>