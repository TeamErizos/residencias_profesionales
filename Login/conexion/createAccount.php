<?php

// Conexión a la base de datos
$host = 'localhost';
$dbname = 'test';
$user = 'root';
$password = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hashear la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar los datos en la tabla de usuarios
    $stmt = $conn->prepare('INSERT INTO user (username, password) VALUES (?, ?)');
    $stmt->execute([$username, $hashed_password]);

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
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Registrarse</button>
</form>
