<?php
// Incluir archivo de conexión a la base de datos
include '../conexion/conectAWS.php';

// Si se ha enviado el formulario de registro
if (isset($_POST['submit'])) {
    // Obtener los valores ingresados en el formulario
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol_id = $_POST['rol_id'];

    // Hashear la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la llamada a la función insertar_cuenta
    $sql = "SELECT insertar_cuenta(:cuenta_mail, :cuenta_pass, :cuenta_rol)";
    $stmt = $conn->prepare($sql);

    // Asignar valores a los parámetros de la función
    $stmt->bindValue(':cuenta_mail', $email, PDO::PARAM_STR);
    $stmt->bindValue(':cuenta_pass', $hashed_password, PDO::PARAM_STR);
    $stmt->bindValue(':cuenta_rol', $rol_id, PDO::PARAM_INT);

    // Ejecutar la función insertar_cuenta
    $stmt->execute();

    // Mostrar mensaje de éxito
    echo "Cuenta creada exitosamente.";
}

?>


<!-- Formulario de registro de cuenta -->
<form method="POST">
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="rol_id">ID de rol:</label>
    <input type="number" id="rol_id" name="rol_id" required>
    <br>
    <button type="submit" name="submit">Registrar cuenta</button>
</form>
