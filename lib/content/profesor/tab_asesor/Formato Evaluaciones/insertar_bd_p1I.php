<?php
// espera 5 segundos antes de redireccionar a la página "Promedio.php"
header("Refresh: 2; url=PromedioP1Int.php");
?>

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../../../../login/conexion/conectAWS.php";
require_once "insert_calif.php";

// Instanciar la clase Calificaciones
$calificaciones = new Calificaciones($conn);

// ID del registro Alumno_Proyecto
$id = $_POST["p_x_a_id"];

// Guarda la ID en una variable de sesión
$_SESSION['p_x_a_id'] = $id;

// Arreglo -- > El arreglo de calificaciones
$array = $_POST["cal"];

// Calcular la suma del arreglo
$suma = array_sum($array);

// Agregar la suma al arreglo
array_push($array, $suma);

// Antes de insertar el array, debe convertirse en un formato valido
$array_string = '{' . implode(',', $array) . '}';

try {

    // Llamar a la función insertarCalifParcial1AsesorExterno
    $calificaciones->insertarCalifParcial1AsesorInterno($id, $array_string);
    
} catch (PDOException $e) {
    // En caso de error, se muestra el mensaje y se termina el programa
    echo "Error: " . $e->getMessage();
    die();
}



?>

<!DOCTYPE html>
<html>

<head>
    <title>Loading..</title>
    <style>
        .book {
            --color: #fff;
            --duration: 6.8s;
            width: 32px;
            height: 12px;
            position: relative;
            margin: 32px 0 0 0;
            zoom: 1.5;
        }

        .book .inner {
            width: 32px;
            height: 12px;
            position: relative;
            transform-origin: 2px 2px;
            transform: rotateZ(-90deg);
            -webkit-animation: book var(--duration) ease infinite;
            animation: book var(--duration) ease infinite;
        }

        .book .inner .left,
        .book .inner .right {
            width: 60px;
            height: 4px;
            top: 0;
            border-radius: 2px;
            background: var(--color);
            position: absolute;
        }

        .book .inner .left:before,
        .book .inner .right:before {
            content: "";
            width: 48px;
            height: 4px;
            border-radius: 2px;
            background: inherit;
            position: absolute;
            top: -10px;
            left: 6px;
        }

        .book .inner .left {
            right: 28px;
            transform-origin: 58px 2px;
            transform: rotateZ(90deg);
            -webkit-animation: left var(--duration) ease infinite;
            animation: left var(--duration) ease infinite;
        }

        .book .inner .right {
            left: 28px;
            transform-origin: 2px 2px;
            transform: rotateZ(-90deg);
            -webkit-animation: right var(--duration) ease infinite;
            animation: right var(--duration) ease infinite;
        }

        .book .inner .middle {
            width: 32px;
            height: 12px;
            border: 4px solid var(--color);
            border-top: 0;
            border-radius: 0 0 9px 9px;
            transform: translateY(2px);
        }

        .book ul {
            margin: 0;
            padding: 0;
            list-style: none;
            position: absolute;
            left: 50%;
            top: 0;
        }

        .book ul li {
            height: 4px;
            border-radius: 2px;
            transform-origin: 100% 2px;
            width: 48px;
            right: 0;
            top: -10px;
            position: absolute;
            background: var(--color);
            transform: rotateZ(0deg) translateX(-18px);
            -webkit-animation-duration: var(--duration);
            animation-duration: var(--duration);
            -webkit-animation-timing-function: ease;
            animation-timing-function: ease;
            -webkit-animation-iteration-count: infinite;
            animation-iteration-count: infinite;
        }

        .book ul li:nth-child(0) {
            -webkit-animation-name: page-0;
            animation-name: page-0;
        }

        .book ul li:nth-child(1) {
            -webkit-animation-name: page-1;
            animation-name: page-1;
        }

        .book ul li:nth-child(2) {
            -webkit-animation-name: page-2;
            animation-name: page-2;
        }

        .book ul li:nth-child(3) {
            -webkit-animation-name: page-3;
            animation-name: page-3;
        }

        .book ul li:nth-child(4) {
            -webkit-animation-name: page-4;
            animation-name: page-4;
        }

        .book ul li:nth-child(5) {
            -webkit-animation-name: page-5;
            animation-name: page-5;
        }

        .book ul li:nth-child(6) {
            -webkit-animation-name: page-6;
            animation-name: page-6;
        }

        .book ul li:nth-child(7) {
            -webkit-animation-name: page-7;
            animation-name: page-7;
        }

        .book ul li:nth-child(8) {
            -webkit-animation-name: page-8;
            animation-name: page-8;
        }

        .book ul li:nth-child(9) {
            -webkit-animation-name: page-9;
            animation-name: page-9;
        }

        .book ul li:nth-child(10) {
            -webkit-animation-name: page-10;
            animation-name: page-10;
        }

        .book ul li:nth-child(11) {
            -webkit-animation-name: page-11;
            animation-name: page-11;
        }

        .book ul li:nth-child(12) {
            -webkit-animation-name: page-12;
            animation-name: page-12;
        }

        .book ul li:nth-child(13) {
            -webkit-animation-name: page-13;
            animation-name: page-13;
        }

        .book ul li:nth-child(14) {
            -webkit-animation-name: page-14;
            animation-name: page-14;
        }

        .book ul li:nth-child(15) {
            -webkit-animation-name: page-15;
            animation-name: page-15;
        }

        .book ul li:nth-child(16) {
            -webkit-animation-name: page-16;
            animation-name: page-16;
        }

        .book ul li:nth-child(17) {
            -webkit-animation-name: page-17;
            animation-name: page-17;
        }

        .book ul li:nth-child(18) {
            -webkit-animation-name: page-18;
            animation-name: page-18;
        }

        @-webkit-keyframes page-0 {
            4% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            13%,
            54% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            63% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-0 {
            4% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            13%,
            54% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            63% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-1 {
            5.86% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            14.74%,
            55.86% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            64.74% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-1 {
            5.86% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            14.74%,
            55.86% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            64.74% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-2 {
            7.72% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            16.48%,
            57.72% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            66.48% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-2 {
            7.72% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            16.48%,
            57.72% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            66.48% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-3 {
            9.58% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            18.22%,
            59.58% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            68.22% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-3 {
            9.58% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            18.22%,
            59.58% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            68.22% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-4 {
            11.44% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            19.96%,
            61.44% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            69.96% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-4 {
            11.44% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            19.96%,
            61.44% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            69.96% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-5 {
            13.3% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            21.7%,
            63.3% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            71.7% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-5 {
            13.3% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            21.7%,
            63.3% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            71.7% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-6 {
            15.16% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            23.44%,
            65.16% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            73.44% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-6 {
            15.16% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            23.44%,
            65.16% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            73.44% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-7 {
            17.02% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            25.18%,
            67.02% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            75.18% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-7 {
            17.02% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            25.18%,
            67.02% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            75.18% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-8 {
            18.88% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            26.92%,
            68.88% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            76.92% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-8 {
            18.88% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            26.92%,
            68.88% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            76.92% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-9 {
            20.74% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            28.66%,
            70.74% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            78.66% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-9 {
            20.74% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            28.66%,
            70.74% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            78.66% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-10 {
            22.6% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            30.4%,
            72.6% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            80.4% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-10 {
            22.6% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            30.4%,
            72.6% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            80.4% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-11 {
            24.46% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            32.14%,
            74.46% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            82.14% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-11 {
            24.46% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            32.14%,
            74.46% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            82.14% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-12 {
            26.32% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            33.88%,
            76.32% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            83.88% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-12 {
            26.32% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            33.88%,
            76.32% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            83.88% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-13 {
            28.18% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            35.62%,
            78.18% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            85.62% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-13 {
            28.18% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            35.62%,
            78.18% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            85.62% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-14 {
            30.04% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            37.36%,
            80.04% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            87.36% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-14 {
            30.04% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            37.36%,
            80.04% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            87.36% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-15 {
            31.9% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            39.1%,
            81.9% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            89.1% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-15 {
            31.9% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            39.1%,
            81.9% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            89.1% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-16 {
            33.76% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            40.84%,
            83.76% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            90.84% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-16 {
            33.76% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            40.84%,
            83.76% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            90.84% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-17 {
            35.62% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            42.58%,
            85.62% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            92.58% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-17 {
            35.62% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            42.58%,
            85.62% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            92.58% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes page-18 {
            37.48% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            44.32%,
            87.48% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            94.32% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @keyframes page-18 {
            37.48% {
                transform: rotateZ(0deg) translateX(-18px);
            }

            44.32%,
            87.48% {
                transform: rotateZ(180deg) translateX(-18px);
            }

            94.32% {
                transform: rotateZ(0deg) translateX(-18px);
            }
        }

        @-webkit-keyframes left {
            4% {
                transform: rotateZ(90deg);
            }

            10%,
            40% {
                transform: rotateZ(0deg);
            }

            46%,
            54% {
                transform: rotateZ(90deg);
            }

            60%,
            90% {
                transform: rotateZ(0deg);
            }

            96% {
                transform: rotateZ(90deg);
            }
        }

        @keyframes left {
            4% {
                transform: rotateZ(90deg);
            }

            10%,
            40% {
                transform: rotateZ(0deg);
            }

            46%,
            54% {
                transform: rotateZ(90deg);
            }

            60%,
            90% {
                transform: rotateZ(0deg);
            }

            96% {
                transform: rotateZ(90deg);
            }
        }

        @-webkit-keyframes right {
            4% {
                transform: rotateZ(-90deg);
            }

            10%,
            40% {
                transform: rotateZ(0deg);
            }

            46%,
            54% {
                transform: rotateZ(-90deg);
            }

            60%,
            90% {
                transform: rotateZ(0deg);
            }

            96% {
                transform: rotateZ(-90deg);
            }
        }

        @keyframes right {
            4% {
                transform: rotateZ(-90deg);
            }

            10%,
            40% {
                transform: rotateZ(0deg);
            }

            46%,
            54% {
                transform: rotateZ(-90deg);
            }

            60%,
            90% {
                transform: rotateZ(0deg);
            }

            96% {
                transform: rotateZ(-90deg);
            }
        }

        @-webkit-keyframes book {
            4% {
                transform: rotateZ(-90deg);
            }

            10%,
            40% {
                transform: rotateZ(0deg);
                transform-origin: 2px 2px;
            }

            40.01%,
            59.99% {
                transform-origin: 30px 2px;
            }

            46%,
            54% {
                transform: rotateZ(90deg);
            }

            60%,
            90% {
                transform: rotateZ(0deg);
                transform-origin: 2px 2px;
            }

            96% {
                transform: rotateZ(-90deg);
            }
        }

        @keyframes book {
            4% {
                transform: rotateZ(-90deg);
            }

            10%,
            40% {
                transform: rotateZ(0deg);
                transform-origin: 2px 2px;
            }

            40.01%,
            59.99% {
                transform-origin: 30px 2px;
            }

            46%,
            54% {
                transform: rotateZ(90deg);
            }

            60%,
            90% {
                transform: rotateZ(0deg);
                transform-origin: 2px 2px;
            }

            96% {
                transform: rotateZ(-90deg);
            }
        }

        html {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        * {
            box-sizing: inherit;
        }

        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #287bff;
            overflow: hidden;
        }
    </style>
</head>

<body>

    <div class="book">
        <div class="inner">
            <div class="left"></div>
            <div class="middle"></div>
            <div class="right"></div>
        </div>
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>


        


</body>

</html>
