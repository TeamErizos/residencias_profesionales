<?php

        require_once('conectAWS.php');

        

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $calificaciones = $_POST["cal"];
          $array = serialize($calificaciones);

          // Mostrar los valores del arreglo
          foreach ($calificaciones as $calificacion) {
            echo $calificacion . "<br>";
          }
        }

            $var1 = "148596";
            
        
            // Preparar la consulta SQL para insertar un registro en la tabla "ProyectoXAlumno"
            $sql = "EXECUTE insertar_calif_reporte_asesor_externo(:id, :calificacion)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $var1);
            $stmt->bindParam(':calificacion', $array);
            $stmt->execute()
      
            
        



?>

