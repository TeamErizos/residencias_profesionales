<?php
include("../view/header.php");

    // Establish a connection to the PostgreSQL database
    require "../../../../login/conexion/conectAWS.php";

    // Get the data from the previous page
    if (isset($_POST['id_p_x_a']) && isset($_POST['id_profesor'])) {
        $id_p_x_a = $_POST['id_p_x_a'];
        $id_profesor = $_POST['id_profesor'];
    }

    // Get nombre_completo
    $stmt = $conn->prepare("SELECT CONCAT(nom_profesor, ' ', ape1_profesor, ' ', ape2_profesor) AS nombre_completo FROM profesor WHERE id_profesor = :id_profesor");
    $stmt->bindParam(':id_profesor', $id_profesor);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Access the value of the 'nombre_completo' column in the fetched row
    $nombre_completo = $row['nombre_completo'];

    // Update the data in the database
    $stmt = $conn->prepare("SELECT update_revisador(:id_p_x_a, :id_profesor)");
    $stmt->bindParam(':id_p_x_a', $id_p_x_a);
    $stmt->bindParam(':id_profesor', $id_profesor);
    $stmt->execute();

    // Query the database for the relevant information
    $query = "
        SELECT CONCAT(pf.nom_profesor, ' ', pf.ape1_profesor, ' ', pf.ape2_profesor) AS nombre_completo, CONCAT(al.nombre_alumno, ' ', al.ape1_alumno, ' ', al.ape2_alumno) as nombreResidente, ca.nom_carrera, pro.nombre_proyecto
        FROM proyecto_x_alumno pa
        JOIN proyecto pro ON pro.id_proyecto = pa.id_proyecto
        JOIN alumno al ON al.no_control = pa.id_alumno
        JOIN carrera ca ON ca.id_carrera = al.fk_id_carrera
        JOIN profesor pf ON pf.id_profesor = :id_profesor
        WHERE pa.id_p_x_a = :id_p_x_a
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_p_x_a', $id_p_x_a);
    $stmt->bindParam(':id_profesor', $id_profesor);
    $stmt->execute();

    // Set up the data for TBS to merge into the template
    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    setcookie('path', '../pdf/templates/asignacion_revisor.docx', time() + 60, '/');

    $serialized_data = json_encode($data);

    setcookie('data', $serialized_data, time() + 60, '/');

    setcookie('com_rev', $id_p_x_a, time() + 60, '/');

    $conn = null;
?>

<table>
    <thead>
        <tr>
            <th>Profesor</th>
            <th>Residente</th>
            <th>Carrera</th>
            <th>Proyecto</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?php echo $row['nombre_completo']; ?></td>
            <td><?php echo $row['nombreresidente']; ?></td>
            <td><?php echo $row['nom_carrera']; ?></td>
            <td><?php echo $row['nombre_proyecto']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Add a button to save the document -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <button id="open_button">Save Document</button>

    <script>
    $(document).ready(function() {
        $('#open_button').click(function() {
            window.location.href = '../../../../../func/download.php';
        });
    });
    </script>

<?php include("../view/footer.php"); ?>
