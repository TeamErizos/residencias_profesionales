<?php

    // Establish a connection to the PostgreSQL database
    require "../../../../login/conexion/conectAWS.php";

    // Get the user input data
    /*
    $id_p_x_a = $_POST['id_p_x_a'];
    $numOficio = $_POST['numOficio'];*/
    $id_p_x_a = $_POST['id_p_x_a'];
    $numOficio = $_POST['numOficio'];
    $date = date('d-m-Y');

    // Update the data in the database
    $stmt = $conn->prepare("SELECT update_carta(:id_p_x_a)");
    $stmt->bindParam(':id_p_x_a', $id_p_x_a);
    $stmt->execute();

    $query = "
        SELECT 
        CONCAT(al.nombre_alumno, ' ', al.ape1_alumno, ' ', al.ape2_alumno) AS nombreEstudiante,
        al.no_control,
        al.seguro_medico_alumno,
        al.num_seguridad_social_alumno,
        ca.nom_carrera,
        pro.nombre_proyecto,
        e.nombre_empresa,
        CONCAT(e.nombre_del_titular_de_empresa, ' ', e.ape1_del_titular_de_empresa, ' ', e.ape2_del_titular_de_empresa) AS nombreTitularEmpresa,
        e.puesto_del_titular_de_empresa,
        :date AS lugar_y_fecha,
        :numOficio AS numOficio
        FROM proyecto_x_alumno pa
        JOIN proyecto pro ON pro.id_proyecto = pa.id_proyecto
        JOIN empresa e ON e.id_empresa = pro.fk_id_empresa
        JOIN alumno al ON al.no_control = pa.id_alumno
        JOIN carrera ca ON ca.id_carrera = al.fk_id_carrera
        WHERE pa.id_p_x_a = :id_p_x_a
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_p_x_a', $id_p_x_a);
    $stmt->bindParam(':numOficio', $numOficio);
    $stmt->bindParam(':date', $date);
    $stmt->execute();

    // Set up the data for TBS to merge into the template
    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    setcookie('path', '../pdf/templates/carta_presentacion.docx', time() + 5, '/');

    $serialized_data = json_encode($data);

    setcookie('data', $serialized_data, time() + 5, '/');

    setcookie('carta', $id_p_x_a, time() + 5, '/');
    
    $conn = null;

    // Redirect to download.php to download the word
    header("Location: ../../../../../func/download.php");
    exit; // Make sure to exit after redirecting

?>