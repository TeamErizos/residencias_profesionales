<?php
include ("../view/header.php");
// Establish a connection to the PostgreSQL database
require "../../../login/conexion/conectAWS.php";

// Query the database to get the profesor data and create the select menu
$query = "
    SELECT DISTINCT ca.id_carrera, ca.nom_carrera
    FROM carrera ca
    JOIN alumno al ON al.fk_id_carrera = ca.id_carrera
    JOIN proyecto_x_alumno pa ON pa.id_alumno = al.no_control
    WHERE pa.dictamen = FALSE
";

$stmt = $conn->prepare($query);
$stmt->execute();

// Create an array to hold the results of the query
$carreras = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $carreras[] = $row;
}

// Close the database connection
$conn = null;

?>
    <!-- Display the select menu and send the selected value to the second PHP code -->
    <form action="dictamen_2.php" method="post">
        <label for="id_carrera">Selecciona una carrera:</label>
        <select id="id_carrera" name="id_carrera">
            <?php foreach ($carreras as $carrera): ?>
                <option value="<?php echo $carrera['id_carrera']; ?>"><?php echo $carrera['nom_carrera']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Enviar">
    </form>

<?php include ("../view/footer.php"); ?>