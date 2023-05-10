<?php

// Conectar con la base de datos
require "../../../../login/conexion/conectAWS.php";

require "funciones_empresa.php";

// Instancia de la clase Empresa
$empresa = new Empresa($conn);

// Verificar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Recuperar los valores del formulario
  $nombre_empresa = $_POST['NombreEmpresa'];
  
  $ramo = $_POST['Ramo'];
  
  $sector = $_POST['Sector'];
  
  $actividad_principal = $_POST['ActividadPrincipal'];
  
  $calle = $_POST['Calle'];
  
  $numero = $_POST['Numero'];
  
  $colonia = $_POST['Colonia'];
  
  $cod_p = $_POST['cp'];
  
  $ciudad = $_POST['Ciudad'];
  
  $tel = $_POST['tel'];
  
  $fax = $_POST['fax'];
  
  $rfc = $_POST['RFC'];
  
  $nomTitu= $_POST['NombreRepresentante'];

  $ape1Titu = $_POST['Ape1Representante'];
  
  $ape2Titu = $_POST['Ape2Representante'];
  
  $puestoTitu = $_POST['Puesto'];

  // Realizar la inserción de la empresa en la base de datos
  $empresa->insertarEmpresa($nombre_empresa, $ramo, $sector, $actividad_principal, $calle, $numero, $colonia, $ciudad, $rfc, $nomTitu, $ape1Titu, $ape2Titu, $puestoTitu, $cod_p, $fax, $tel);

  // Redirigir a otra página
  header('Location: ../form_proyecto.php');
  exit();

  // TODO: un mensaje que avise que ya se insertó
  

}

?>