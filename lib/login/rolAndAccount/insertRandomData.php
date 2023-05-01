<?php

// Este archivo solo es usado para insertar información random en registros
// Conectar a AmazonRDS
include '../conexion/conectAWS.php';


// INSERTAR CARRERA
    /*$carrera_nom = "ISIC";
    $query = "SELECT insertar_carrera(:carrera_nom)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':carrera_nom', $carrera_nom);
    $stmt->execute();*/

// INSERTAR ALUMNO 
/*$a_nControl = "20390300";
    $a_nom = "Emiliano";
    $a_ape1 = "Reyes";
    $a_ape2 = "Andrade";
    $a_sexo = "H";
    $a_calle = "Delfín";
    $a_numDom = "255";
    $a_ciudad = "Chetumal";
    $a_correo = "L20390494@chetumal.tecnm.mx";
    $a_tel = "9831234567";
    $a_seguroMed = "IMSS";
    $a_NSS = "80808080";
    $a_fk_carrera = "106261";
    $a_num_cre = 5;
    $a_credits =  TRUE;
    $a_materias = TRUE;
    $a_serv_social = TRUE;
    // AQUI FALLA PORQUE NO ESTA BIEN LA FUNCTION
    $a_rol = "1";
    $a_pass = password_hash("123456", PASSWORD_DEFAULT);
    $query = "SELECT insertar_alumno(:a_nControl, :a_nom, :a_ape1, :a_ape2, :a_sexo, :a_calle, :a_numDom, :a_ciudad, :a_correo, :a_tel, :a_seguroMed, :a_NSS, :a_fk_carrera, :a_num_cre, :a_credits, :a_materias, :a_serv_social, :a_rol, :a_pass)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':a_nControl', $a_nControl);
    $stmt->bindParam(':a_nom', $a_nom);
    $stmt->bindParam(':a_ape1', $a_ape1);
    $stmt->bindParam(':a_ape2', $a_ape2);
    $stmt->bindParam(':a_sexo', $a_sexo);
    $stmt->bindParam(':a_calle', $a_calle);
    $stmt->bindParam(':a_numDom', $a_numDom);
    $stmt->bindParam(':a_ciudad', $a_ciudad);
    $stmt->bindParam(':a_correo', $a_correo);
    $stmt->bindParam(':a_tel', $a_tel);
    $stmt->bindParam(':a_seguroMed', $a_seguroMed);
    $stmt->bindParam(':a_NSS', $a_NSS);
    $stmt->bindParam(':a_fk_carrera', $a_fk_carrera);
    $stmt->bindParam(':a_num_cre', $a_num_cre);
    $stmt->bindParam(':a_credits', $a_credits);
    $stmt->bindParam(':a_materias', $a_materias);
    $stmt->bindParam(':a_serv_social', $a_serv_social);
    $stmt->bindParam(':a_rol', $a_rol);
    $stmt->bindParam(':a_pass', $a_pass);
    $stmt->execute();*/
    

// INSERTAR PROFESOR
/*
// Obtener valores 
$prof_nom = "Julio";
$prof_ape1 = "Carrillo";
$prof_ape2 = "Alemán";
$prof_correo = "julio.ca@chetumal.tecnm.mx";
$prof_rol = "2";
$prof_pass = password_hash("123456", PASSWORD_DEFAULT);

// Preparar la consulta SQL
$sql = "SELECT insertar_profesor(:prof_nom, :prof_ape1, :prof_ape2, :prof_correo, :prof_rol, :prof_pass)";
$stmt = $conn->prepare($sql);

// Enlazar valores
$stmt->bindParam(':prof_nom', $prof_nom);
$stmt->bindParam(':prof_ape1', $prof_ape1);
$stmt->bindParam(':prof_ape2', $prof_ape2);
$stmt->bindParam(':prof_correo', $prof_correo);
$stmt->bindParam(':prof_rol', $prof_rol);
$stmt->bindParam(':prof_pass', $prof_pass);

// Ejecutar la consulta
$stmt->execute();

*/

/*
// INSERTAR EMPRESA
$e_nom = "Bimbo";
$e_ramo = "Industrial";
$e_sector = "Privado";
$e_act = "Hacer pan";
$e_calle = "no sé";
$e_numDom = "84";
$e_colonia = "Centro";
$e_ciudad = "Juarez";
$e_rfc = "BM8123456OP1";
$e_nomTitu = "Momichis";
$e_ape1Titu = "Ramires";
$e_ape2Titu = "CORP";
$e_puestoTitu = "CEO";
$e_rol = "3";
$e_pass = password_hash("123456", PASSWORD_DEFAULT);
  
    $query = "SELECT insertar_empresa(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$e_nom, $e_ramo, $e_sector, $e_act, $e_calle, $e_numDom, $e_colonia, $e_ciudad, $e_rfc, $e_nomTitu, $e_ape1Titu, $e_ape2Titu, $e_puestoTitu, $e_rol, $e_pass]);
*/

/*
// Declaración de variables con los valores a insertar
$p_nom = "Proyecto X";
$p_obj = "Mejorar la productividad";
$p_tipo = "Interno";
$p_origen = "Banco de Proyectos";
$p_periodo = "AGO-DIC-2023";
$p_num = "2";
$p_descri = "Este proyecto tiene como objetivo mejorar la productividad en la empresa.";
$p_imp = "Alto";
$p_fk_emp = "910061";
$p_fk_prof = "357930";

// Preparación y ejecución de la consulta
$query = "SELECT insertar_proyecto(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->execute([$p_nom, $p_obj, $p_tipo, $p_origen, $p_periodo, $p_num, $p_descri, $p_imp, $p_fk_emp, $p_fk_prof]);
*/

/*
// Función para eliminar un profesor
function deleteProfesor($conn, $id_profesor) {
    // Preparar la consulta SQL
    $sql = "SELECT delete_profesor(:id_profesor)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_profesor', $id_profesor);
    // Ejecutar la consulta
    $stmt->execute();
}

// Llamar a la función con un valor de entrada
$id_profesor = 477701;
deleteProfesor($conn, $id_profesor);

*/

?>