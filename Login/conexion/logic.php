<?php

if(isset($_REQUEST['login'])){
    // Obtener el usuario y contraseña ingresados en el formulario
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    // Crear consulta para recuperar registro del usuario en la base de datos
    $sql = "SELECT * FROM user WHERE username = '$username'";

    // Ejecutar la consulta utilizando la conexión PDO
    $stmt = $conn->query($sql);

    // Obtener el resultado como un array asociativo
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar la contraseña hasheada con la ingresada por el usuario
    $pwd_check = password_verify($password, $result['password']);

    // Si la contraseña coincide, iniciar sesión y redireccionar al usuario
    if($pwd_check){
        $_SESSION['username'] = $result['username'];
        header("Location: index.php");
        exit();
    } else {
        // Si la contraseña no coincide, mostrar mensaje de error
        echo "Usuario o contraseña incorrectos.";
    }
}

if(isset($_REQUEST['logout'])){
    // Destruir la sesión y redireccionar al usuario
    session_destroy();
    header("Location: index.php");
    exit();
}


?>