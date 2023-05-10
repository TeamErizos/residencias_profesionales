<?php

class Empresa {
    private $conn;

    function __construct($conexion) {
        $this->conn = $conexion;
    }

    // Funcion que guarda la empresa
    function insertarEmpresa($nombre, $ramo, $sector, $actividad, $calle, $numDom, $colonia, $ciudad, $rfc, $nomTitu, $ape1Titu, $ape2Titu, $puestoTitu, $cod_p, $fax, $tel) {
        // Preparar la consulta
        $query = "SELECT insertar_empresa(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
      
        // Ligar los parámetros con los valores recibidos como argumentos
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $ramo);
        $stmt->bindParam(3, $sector);
        $stmt->bindParam(4, $actividad);
        $stmt->bindParam(5, $calle);
        $stmt->bindParam(6, $numDom);
        $stmt->bindParam(7, $colonia);
        $stmt->bindParam(8, $ciudad);
        $stmt->bindParam(9, $rfc);
        $stmt->bindParam(10, $nomTitu);
        $stmt->bindParam(11, $ape1Titu);
        $stmt->bindParam(12, $ape2Titu);
        $stmt->bindParam(13, $puestoTitu);

        // La clave de empresa siempre
        // será la numero 3 (tipo: empresa)
        $rol = '3';
        $stmt->bindParam(14, $rol);
        $stmt->bindParam(15, $cod_p);
        $stmt->bindParam(16, $fax);
        $stmt->bindParam(17, $tel);
        
        // El password por defecto siempre será 123456
        // Para que funcione, necesitamos un modulo
        // Que permita modificar contraseñas 
        $pass = '123456';
        $stmt->bindParam(18, $pass);
      
        // Ejecutar la consulta
        $stmt->execute();
      }
    
}