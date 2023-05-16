<?php

session_start();

require "conectAWS.php";
require "insert_calif.php";

// Instanciar la clase Calificaciones
$calificaciones = new Calificaciones($conn);

// ID del registro Alumno_Proyecto
$p_x_a_id = $_SESSION['p_x_a_id'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>Calificaciones</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Ubuntu', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #287bff;
            overflow: hidden;
        }

        #text {
            position: relative;
            color: #fff;
            font-weight: 700;
            font-size: 12em;
            line-height: 0.9em;
            letter-spacing: 2px;
            text-align: center;
            transform: rotate(-10deg) skew(25deg);
            user-select: none;
        }

        #text::before {
            content: attr(data-text);
            position: absolute;
            top: 30px;
            left: -30px;
            color: rgba(0, 0, 0, 0.3);
            text-shadow: none;
            filter: blur(8px);
            z-index: -1;
        }

        section .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url(wave.png);
            background-size: 1000px 100px;
        }

        section .wave.wave1 {
            animation: animate 30s linear infinite;

            opacity: 1;
            animation-delay: 0s;
            bottom: 0;
        }

        section .wave.wave2 {
            animation: animate2 15s linear infinite;

            opacity: 0.5;
            animation-delay: -5s;
            bottom: 10px;
        }

        section .wave.wave3 {
            animation: animate 30s linear infinite;

            opacity: 0.2;
            animation-delay: -2s;
            bottom: 15;
        }

        section .wave.wave4 {
            animation: animate2 25s linear infinite;

            opacity: 0.7;
            animation-delay: -5s;
            bottom: 20px;
        }


        @keyframes animate {
            0% {
                background-position-x: 0;
            }

            100% {
                background-position-x: 1000px;
            }
        }

        @keyframes animate2 {
            0% {
                background-position-x: 0;
            }

            100% {
                background-position-x: -1000px;
            }
        }

        .container {

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Ubuntu', sans-serif;
        }

        .btn {
            position: absolute;
            top: 2%;
            left: 2%;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: white;
            color: #287bff;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            font-weight: bold;

        }

        button:hover {

            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>

<body>



    <div class="container">

        <section class="bg">
            <div class="wave wave1"></div>
            <div class="wave wave2"></div>
            <div class="wave wave3"></div>
            <div class="wave wave4"></div>

        </section>



        <div id="text" data-text="Gracias por enviar">Gracias <br> por enviar</div>

    </div>
    <div class="btn">
        <?php
        try {
            // Llamar a la función insertarCalifReporteFinAsesorInterno
            $resultados = $calificaciones->obtenerPromedioCalificaciones($p_x_a_id);


            if (isset($resultados['calif_parcial1_asesor_interno'])) {
                //Arreglo del asesor interno
                implode(", ", $resultados['calif_parcial1_asesor_interno']);
            } else {
                // echo "Faltan las calificaiones del otro asesor";
            }

            if (isset($resultados['calif_parcial1_asesor_externo'])) {
                //Arreglo del asesor externo
                implode(", ", $resultados['calif_parcial1_asesor_externo']);
            } else {
                // echo "Faltan las calificaiones del otro asesor";
            }

            if (isset($resultados['calif_parcial2_asesor_interno'])) {
                //Arreglo del asesor interno
                implode(", ", $resultados['calif_parcial2_asesor_interno']);
            } else {
                // echo "Faltan las calificaiones del otro asesor";
            }

            if (isset($resultados['calif_parcial2_asesor_externo'])) {
                //Arreglo del asesor externo
                implode(", ", $resultados['calif_parcial2_asesor_externo']);
            } else {
                // echo "Faltan las calificaiones del otro asesor";
            }

            //Mostrar promedio
            $resultados['promedio'];

            echo "<form action=\"ListaP2Ext.php\" method=\"post\">";
            echo "<button>Cerrar</button>";
            echo "</form>";
        } catch (PDOException $e) {
            // En caso de error, se muestra el mensaje y se termina el programa
            echo "Error: " . $e->getMessage();
            die();
        }
        ?>

    </div>

    <!--Script del texto de fondo-->

    <script type="text/javascript">
        var text = document.getElementById('text')
        var shadow = '';

        for (var i = 0; i < 30; i++) {
            shadow += (shadow ? ',' : '') + -i * 1 + 'px ' + i * 1 + 'px 0 #d9d9d9';

        }

        text.style.textShadow = shadow;
    </script>

</body>

</html>