<?php

include("../view/header.php");

// Establish a connection to the PostgreSQL database
require "../../../../login/conexion/conectAWS.php";

// Get the id_p_x_a from user input
$id_p_x_a = $_POST['id_p_x_a'];

// Query the database to get id_proyecto values from carrera_x_proyecto table
$query1 = "
    SELECT id_carrera
    FROM carrera_x_proyecto
    WHERE id_proyecto IN (
        SELECT id_proyecto
        FROM proyecto_x_alumno
        WHERE id_p_x_a = :id_p_x_a
    )
";

$stmt1 = $conn->prepare($query1);
$stmt1->bindParam(':id_p_x_a', $id_p_x_a);
$stmt1->execute();

// Create an array to hold the results of the query
$id_carreras = array();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $id_carreras[] = $row['id_carrera'];
}

// Query the database to get id_carrera values from carrera_x_profesor table
$query2 = "
    SELECT id_profesor
    FROM carrera_x_profesor
    WHERE id_carrera IN (" . implode(',', $id_carreras) . ")
";

$stmt2 = $conn->prepare($query2);
$stmt2->execute();

// Create an array to hold the results of the query
$id_profesores = array();
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $id_profesores[] = $row['id_profesor'];
}

// Query the database to get the profesor data and create the select menu
$query3 = "
    SELECT id_profesor, CONCAT(nom_profesor, ' ', ape1_profesor, ' ', ape2_profesor) AS nombre_completo
    FROM profesor
    WHERE id_profesor IN (" . implode(',', $id_profesores) . ")
";

$stmt3 = $conn->prepare($query3);
$stmt3->execute();

// Create an array to hold the results of the query
$profesores = array();
while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    $profesores[] = $row;
}

// Close the database connection
$conn = null;

?>

    <!-- Display the select menu and send the selected value to the second PHP code -->
    <form action="comision_revisor_3.php" method="post">
        <label for="id_profesor">Selecciona un profesor:</label>
        <select id="id_profesor" name="id_profesor">
            <?php foreach ($profesores as $profesor): ?>
                <option value="<?php echo $profesor['id_profesor']; ?>"><?php echo $profesor['nombre_completo']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="id_p_x_a" value="<?php echo $id_p_x_a; ?>">
        <input type="submit" value="Enviar">
    </form>

<?php  include("../view/footer.php"); ?>