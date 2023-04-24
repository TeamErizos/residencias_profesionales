<?php
// Conectar a AmazonRDS
include 'conectAWS.php';

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hashear la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar los datos en la tabla de usuarios
    // TO DO: Por mientras, está siendo probada en la tabla "cuenta"
    $stmt = $conn->prepare('INSERT INTO cuenta (mail_cuenta, password_cuenta) VALUES (?, ?)');
    $stmt->execute([$email, $hashed_password]);

    // Verificar si la inserción fue exitosa
    if ($stmt->rowCount() == 1) {
        header('Location: registro_exitoso.php');
        exit();
    } else {
        $error_message = 'Error al insertar el usuario en la base de datos';
    }
}

?>

<!-- Formulario HTML -->
<form method="POST">
    <label for="username">Nombre de usuario:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Registrarse</button>
</form>
