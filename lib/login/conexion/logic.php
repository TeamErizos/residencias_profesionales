<?php

if (isset($_REQUEST['login'])) {
    // Obtener el usuario y contraseña ingresados en el formulario
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    // Crear instancia de la clase User y llamar a la función login
    $user = new User($conn);
    $result = $user->login($username, $password);

    // Si el resultado es un array asociativo, iniciar sesión y redireccionar al usuario
    if (is_array($result)) {
        $_SESSION['username'] = $result['mail_cuenta'];
        header("Location: lib/content/dashboard/PanelDeControl-Menu.php");
        exit();
    } else {
        // Si el resultado es false, mostrar mensaje de error
        echo "Usuario o contraseña incorrectos.";
    }
}




?>