<?php

// Dependiendo el alumno a revisar
// Se podrán ver sus 3 archivos subidos en su registro de tabla [Documentos]
// se almacenarán de manera temporal en carpetas, y cuando se acabe la revisión
// y se de el [Dictamen] y el valor cambie a TRUE o sea rechazado, se borrarán de manera local
// [LOS NOMBRES DE LOS ARCHIVOS SERÁN SEGUN SU NUMERO DE CONTROL]

if (isset($_GET['id'])) {
    $idSeleccionado = $_GET['id'];

    // Guardar el ID en una cookie con una duración de 1 día
    setcookie("idSeleccionado", $idSeleccionado, time() + (86400), "/");

} else {
    // Verificar si la cookie existe
    if (isset($_COOKIE['idSeleccionado'])) {

        // Recuperar el id del proyecto_x_alumno
        $idSeleccionado = $_COOKIE['idSeleccionado'];

    } else {
        echo "No se ha seleccionado ningún ID y no hay una cookie existente.";
    }
}


// Conexion y clases
    require "../../../../login/conexion/conectAWS.php";
    require "funciones_archivos.php";
    require "funciones_revision.php";

// Instanciar clase y pasar el id del proyecto_x_alumno
    $file = new Files($idSeleccionado, $conn);
    $revision = new Revision($conn);

// Recuperar los 3 archivos a mostrar  
    // Constancia
    $rutaConstancia = $file->descargarConstanciaResidencia();

    // Anteproyecto
    $rutaAnteproyecto = $file->descargarAnteproyecto();

    // Solicitud de Residencia
    $rutaSolicitud = $file->descargarSolicitudResidencia();

// 3 botones para mostrar los archivos en pantalla
// ->>>
?>

<!DOCTYPE html>
<html>
<head>
    <title>Abrir archivo PDF en pestaña emergente</title>
</head>
<body>
    <button onclick="abrirPDF('<?php echo $rutaConstancia; ?>')">Constancia de Residencia Profesional </button>
    <button onclick="abrirPDF('<?php echo $rutaAnteproyecto; ?>')">Anteproyecto de Residencia Profesional </button>
    <button onclick="abrirPDF('<?php echo $rutaSolicitud; ?>')">Solicitud de Participación del Alumno </button>

    <!-- TODO: DOS BOTONES, UNO PARA ACEPTAR Y UNO PARA RECHAZAR -->

    <button onclick="denegar('<?php echo $idSeleccionado; ?>')">RECHAZAR SOLICITUD</button>
    <button onclick="aceptar('<?php echo $idSeleccionado; ?>')">ACEPTAR SOLICITUD</button>


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

        // Enviar el id para DENEGAR SOLICITUD
        function denegar(id) {
            // Enviar el ID mediante una solicitud GET al archivo actual
            window.location.href = 'solicitud_rechazada.php?id=' + id;
        }

        // Enviar el id para ACEPTAR SOLICITUD
        function aceptar(id) {
            // Enviar el ID mediante una solicitud GET a otro archivo PHP
            window.location.href = 'solicitud_aceptada.php?id=' + id;
        }
    </script>
</body>
</html>
