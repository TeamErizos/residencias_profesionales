<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include("../conexion/conectAWS.php");

    // Obtener los valores enviados desde el formulario
    $no_control = $_POST["no_control"];
    $passwordSinHash = $_POST["password"];

        // Hashear la contraseña utilizando la función password_hash de PHP
        $hashedPassword = password_hash($passwordSinHash, PASSWORD_DEFAULT);

            // Actualizar el campo "password_alumno" en la tabla "alumno"
        $sqlUpdate = "UPDATE alumno SET password_alumno = :password WHERE no_control = :no_control";

        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':no_control', $no_control, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Contraseña actualizada correctamente.";
        } else {
            echo "Error al actualizar la contraseña: " . $stmt->errorInfo()[2];
        }


}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Actualización de Contraseña</title>
</head>
<body>
    <h2>Formulario de Actualización de Contraseña</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="no_control">No. de Control:</label>
        <input type="text" name="no_control" id="no_control" required><br><br>

        <label for="password">Nueva Contraseña:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Actualizar Contraseña">
    </form>
</body>
</html>
