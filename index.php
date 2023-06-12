</body>
<?php

// Iniciar la sesión
session_start();

    // Importar Forma de Conexión
    include "lib/login/conexion/conectAWS.php";
    include "lib/login/conexion/functions.php";
    include "lib/login/conexion/logic.php";

    // Crear instancia de funciones
    $user = new User($conn);
?>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residencias Profesionales</title>
    <link rel="stylesheet" type="text/css" href="lib/Login/login.css">
    <style>
        /* Aquí puedes colocar tus estilos personalizados */
        h1 {
            color: #fff;
            position: absolute;
            top: 65px;
            display: block;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Residencias Profesionales</h1>
    <h2>Iniciar Sesión</h2>

    <div class="container">
        <!-- Resto del código... -->
   
        
            <div class="imgBox">
                <img src="lib/login/logo2.png" alt="Avatar">
            </div>
            <form action="#" method="POST" autocomplete="off">
                <div class="inputBox">
                    <input type="text" name="username" required>
                    <label for="username">Usuario</label>
                </div>
                <div class="inputBox">
                    <input type="password" name="password" required>
                    <label for="password">Contraseña</label>
                </div>
                <div class="inputBox">
                    <input type="submit" value="login" name="login">
                </div>
            </form>
            <div class="bottomBox">
                <a href="#">Olvidé mi contraseña?</a>
            </div>
    </div>


    <!-- Si intenta regresar al login sin haber hecho logout, lo regresa al dashboard -->
    <?php if(!empty($_SESSION['no_control'])){

        // Acción si la sesión 'no_control' tiene un valor

        header("Location: lib/content/alumno/PanelDeControl-Menu.php");
        exit(); 

    }
    elseif(!empty($_SESSION['id_empresa'])){

        // Acción si la sesión 'id_empresa' tiene un valor
        
        header("Location: lib/content/empresa/PanelDeControlAsesorExterno-Menu.php");
        exit(); 
    
    }
    elseif(!empty($_SESSION['id_profesor'])){

        // Acción si la sesión 'id_profesor' tiene un valor

        header("Location: lib/content/profesor/PanelDeControlProfesor-Menu.php");
        exit(); 

    }
    elseif(!empty($_SESSION['id_cuenta'])){
    // Acción si la sesión 'id_cuenta' tiene un valor

    // TODO: Ambos se dirigen al Dashboard de Departamento Academico, revisar por qué

        if($user->searchAccount($_SESSION['id_cuenta']) == 4 ){

            // SI es departamento academico

            header("Location: lib/content/jefe_dep/dep_academico/PanelDeControlJefeDepartamento-Menu.php");
            exit(); 
            
        }elseif ($user->searchAccount($_SESSION['id_cuenta']) == 5){

            // SI es gestión y vinculación
            header("Location: lib/content/jefe_dep/dep_vinculacion/PanelDeControlGestionYVinculacion-Menu.php");
            exit(); 
            
        }
    }
?>

</body>
</html>




