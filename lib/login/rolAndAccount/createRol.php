<?php
// Conectar a AmazonRDS
include '../conexion/conectAWS.php';

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rol_id = $_POST['rol_id'];
    $rol_nom = $_POST['rol_nom'];
    $rol_desc = $_POST['rol_desc'];

    // Hashear la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar los datos en la tabla de usuarios
    // TO DO: Por mientras, está siendo probada en la tabla "cuenta"
    try {
        // Preparar la llamada a la función
        // Estos datos no se tienen que llamar como en la base de datos, si no como en la Function
        $stmt = $conn->prepare("SELECT insertar_rol(:rol_id, :rol_nom, :rol_desc)");

        // Asignar valores a los parámetros de la función
        $stmt->bindParam(':rol_id', $rol_id);
        $stmt->bindParam(':rol_nom', $rol_nom);
        $stmt->bindParam(':rol_desc', $rol_desc);

        // Ejecutar la llamada a la función
        $stmt->execute();

        // Imprimir mensaje de éxito
        echo "La función insertar_rol se ejecutó correctamente.";

    } catch (PDOException $e) {
        // Imprimir mensaje de error
        echo "Error al ejecutar la función insertar_rol: " . $e->getMessage();
    }

}

?>

<!-- Formulario HTML -->
<form method="POST">
    <label for="rol_id">ID del rol:</label>
    <input type="number" id="rol_id" name="rol_id" required>
    <br>
    <label for="rol_nom">Nombre del rol:</label>
    <input type="text" id="rol_nom" name="rol_nom" required>
    <br>
    <label for="rol_desc">Descripción del rol:</label>
    <input type="text" id="rol_desc" name="rol_desc" required>
    <br>
    <button type="submit">Registrarse</button>
</form>

