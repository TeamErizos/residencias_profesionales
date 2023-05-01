<?php

if (isset($_REQUEST['login'])) {
    // Obtener el usuario y contraseña ingresados en el formulario
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    // Crear instancia de la clase User y llamar a la función login
    $user = new User($conn);

    // Determinar el tipo de usuario
    $variable = determinarTipoUsuario($username);

    // hacer el login dependiendo del tipo de usuario
    switch ($variable) {
        case 'empresa':
            // Buscar cuenta de empresa
            $result = $user->loginEmpresa($username, $password);
            // Guardar el username
            $temporal_username = $result['rfc_empresa'];
            break;

        case 'profesor':
            // Buscar cuenta de profesor
            $result = $user->loginProfesor($username, $password);
            // Guardar el username
            $temporal_username = $result['correo_profesor'];
            break;

        case 'alumno':
            // Buscar cuenta de alumno
            $result = $user->loginAlumno($username, $password);
            // Guardar el username
            $temporal_username = $result['no_control'];
            break;

        case 'normal':
            // Buscar cuenta [normal] (cualquier otro menos los anteriores)
            $result = $user->login($username, $password);
            // Guardar el username
            $temporal_username = $result['mail_cuenta'];
            break;

        case 'desconocido':
            // Buscar cuenta inexistente
            // NO se hace nada y solicita nuevas credenciales
            $result = null;
            $temporal_username = null;
            break;
    }


    // Si el resultado es un array asociativo, iniciar sesión y redireccionar al usuario
    if (is_array($result)) {
        // TO DO: Qué datos necesitamos tener por cada registro

        // Recuperar el valor dependiendo del tipo de login
        $_SESSION['username'] = $temporal_username;
        header("Location: lib/content/dashboard/PanelDeControl-Menu.php");
        exit();
    } else {
        // Si el resultado es false, mostrar mensaje de error
        echo "Usuario o contraseña incorrectos.";
    }
}

// Funcion para determinar el tipo de usuario dependiendo el input
function determinarTipoUsuario($username) {
    // Patrón para RFC de empresa: 3 caracteres alfanuméricos, 6 números, 3 caracteres alfanuméricos
    $rfcPattern = "/^[a-zA-Z0-9]{3}[0-9]{6}[a-zA-Z0-9]{3}$/";
    
    // Patrón para profesores: nombre e iniciales (opcional) separadas por un punto, seguido del dominio @chetumal.tecnm.mx
    $profesorPattern = "/^[a-zA-Z]+(\.[a-zA-Z]+)?@chetumal\.tecnm\.mx$/";
    
    // Patrón para usuarios normales: formato de correo electrónico genérico, incluidos dominios como Gmail y Hotmail
    $normalPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    
    // Patrón para alumnos: 0, 1 o 2 letras, seguidas de 8 números y el dominio @chetumal.tecnm.mx
    $alumnoPattern = "/^[a-zA-Z]{0,2}[0-9]{8}$/";

    // Comprueba si el username coincide con el patrón de RFC de empresa
    if (preg_match($rfcPattern, $username)) {
        return "empresa";
    }
    // Comprueba si el username coincide con el patrón de profesor
    elseif (preg_match($profesorPattern, $username)) {
        return "profesor";
    }
    // Comprueba si el username coincide con el patrón de usuario normal
    elseif (preg_match($normalPattern, $username)) {
        return "normal";
    }
    // Comprueba si el username coincide con el patrón de alumno
    elseif (preg_match($alumnoPattern, $username)) {
        return "alumno";
    }
    // Si no coincide con ningún patrón, retorna "desconocido"
    else {
        return "desconocido";
    }
}


?>