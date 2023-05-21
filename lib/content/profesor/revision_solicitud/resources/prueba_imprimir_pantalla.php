<?php

// Conexion y clases

require "../../../../login/conexion/conectAWS.php";
require "funciones_archivos.php";

// Instanciar clase

$file = new Files("734009", $conn);


$rutaConstancia = $file->descargarConstanciaResidencia();


?>

<!DOCTYPE html>
<html>
<head>
    <title>Abrir archivo PDF en pestaña emergente</title>
</head>
<body>
    <button onclick="abrirPDF('<?php echo $rutaConstancia; ?>')">Abrir PDF</button>

    <script>
        function abrirPDF(url) {
            // Tamaño de la ventana emergente
            var width = 800;
            var height = 600;

            // Calcular la posición para centrar la ventana en la pantalla
            var left = (screen.width / 2) - (width / 2);
            var top = (screen.height / 2) - (height / 2);

            // Abrir una pestaña emergente con el archivo PDF
            window.open(url, '_blank', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top);
        }
    </script>
</body>
</html>

