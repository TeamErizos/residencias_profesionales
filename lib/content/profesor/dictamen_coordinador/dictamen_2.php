<?php
include("../view/header.php");

// Establish a connection to the PostgreSQL database
require "../../../login/conexion/conectAWS.php";

// Get the id_carrera and date from the user input
$id_carrera = $_POST['id_carrera'];
$date = date('d-m-Y');

// Query the database for the relevant information
$query = "
    SELECT DISTINCT
    al.no_control,
    CONCAT(al.nombre_alumno, ' ', al.ape1_alumno, ' ', al.ape2_alumno) AS nombre,
    al.sexo_alumno,
    pro.nombre_proyecto,
    e.nombre_empresa,
    CONCAT(pr.nom_profesor, ' ', pr.ape1_profesor, ' ', pr.ape2_profesor) AS interno,
    CONCAT(ap.nom_asesor_externo, ' ', ap.ape1_asesor_externo, ' ', ap.ape2_asesor_externo) AS externo,
    CASE WHEN pa.id_proyecto IS NOT NULL THEN 'Aprobado' ELSE 'No Aprobado' END AS dictamen,
    pa.id_p_x_a,
    :date AS fecha
    FROM carrera_x_proyecto cp
    JOIN proyecto pro ON pro.id_proyecto = cp.id_proyecto
    JOIN empresa e ON e.id_empresa = pro.fk_id_empresa
    JOIN asesor_x_proyecto ap ON ap.id_proyecto = pro.id_proyecto
    JOIN profesor pr ON pr.id_profesor = ap.id_asesor_interno
    JOIN proyecto_x_alumno pa ON pa.id_proyecto = cp.id_proyecto
    JOIN alumno al ON al.no_control = pa.id_alumno
    WHERE al.fk_id_carrera = :id_carrera
";

$stmt = $conn->prepare($query);
$stmt->bindParam(':id_carrera', $id_carrera);
$stmt->bindParam(':date', $date);
$stmt->execute();

// Check if the query returned any rows
if ($stmt->rowCount() == 0) {
    echo "No data found.";
    // Redirect to another page
    header("Location: dictamen.php");
    exit();
}

// Set up the data for TBS to merge into the template
$data = array();
$display_num = array();
$count = 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
    $counter_array[] = array("num" => $count);
    $display_num[] = $count;
    $count++;
}

setcookie('path', '../pdf/templates/dictamen_anteproyecto.docx', time() + 60, '/');

$serialized_data = json_encode($data);

setcookie('data', $serialized_data, time() + 60, '/');

$num = json_encode($counter_array);

setcookie('num_dic', $num, time() + 60, '/');

// Close the database connection
$conn = null;

?>

<!-- Display the query results in a table -->
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>No. Control</th>
            <th>Nombre</th>
            <th>Sexo</th>
            <th>Proyecto</th>
            <th>Empresa</th>
            <th>Asesor Interno</th>
            <th>Asesor Externo</th>
            <th>Dictamen</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $index => $row): ?>
        <tr>
            <td><?php echo $display_num[$index] ; ?></td>
            <td><?php echo $row['no_control']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['sexo_alumno']; ?></td>
            <td><?php echo $row['nombre_proyecto']; ?></td>
            <td><?php echo $row['nombre_empresa']; ?></td>
            <td><?php echo $row['interno']; ?></td>
            <td><?php echo $row['externo']; ?></td>
            <td><?php echo $row['dictamen']; ?></td>
            <td><?php echo $row['fecha']; ?></td>
            <td><?php echo $row['id_p_x_a']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<button id="open_button">Save Document</button>

    <script>
    $(document).ready(function() {
        $('#open_button').click(function() {
            window.location.href = '../../../../func/download.php';
        });
    });
</script>

<?php include("../view/footer.php"); ?>