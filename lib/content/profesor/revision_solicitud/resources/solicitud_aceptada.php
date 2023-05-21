<?php
if (isset($_GET['id'])) {
    $idSeleccionado = $_GET['id'];

    // Aceptar la solicitud y regresar a la lista [Pendientes por Revisar]

        // Instanciar clases y conexion
        require "../../../../login/conexion/conectAWS.php";
        require "funciones_revision.php";
        
        $revision = new Revision($conn);

        // Ejecutar la funcion aceptarSolicitud
        $revision->aceptarSolicitud($idSeleccionado);

        // TODO: Eliminar archivos temporal
        $revision->eliminarArchivosPDF($idSeleccionado);

        // Si todo el proceso acabo correctamete, regresar al dashboard
        header("Location: ../../PanelDeControlProfesor-Menu.php");
        exit(); 
    
} else {
    echo "No se ha seleccionado ningún ID para aceptar la solicitud.";
}
?>
