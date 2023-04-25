</body>
<?php

// Iniciar la sesión
session_start();

    // Importar Forma de Conexión
    include "lib/login/conexion/conectAWS.php";
    include "lib/login/conexion/functions.php";
    include "lib/login/conexion/logic.php";
?>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Glassmorphism</title>
    <link rel="stylesheet" type="text/css" href="lib/Login/login.css">
</head>

<?php 
    // Visible si no está logeado
    if(empty($_SESSION['username'])){?>
<body>
  <h1>Iniciar Sesión </h1>
    <div class="container">
        <div class="imgBox">
            <img src="lib/login/logo2.png" alt="Avatar">
        </div>
        <form action="#" method="POST">
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
    <?php }?>

    <!-- Visible solo SI esta loggeado -->
    <?php if(!empty($_SESSION['username'])){?>
        <div class="container text-center my-5">
            <h1>Hello <?php echo $_SESSION['username'];?></h1>
        </div>

        <form method="POST" class="text-center">
            <button class="btn btn-danger" name="logout">Logout</button>
        </form>
    <?php }?>
</body>
</html>





