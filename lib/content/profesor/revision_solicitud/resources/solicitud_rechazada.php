<?php
if (isset($_GET['id'])) {
    $idSeleccionado = $_GET['id'];

    // Si la solicitud fue rechazada, eliminar información del alumno
    // usando la funcion [func denegarSolicitud()]

         // Instanciar clases y conexion
         require "../../../../login/conexion/conectAWS.php";
         require "funciones_revision.php";
         
         $revision = new Revision($conn);
 
         // Ejecutar la funcion aceptarSolicitud
         $revision->denegarSolicitud($idSeleccionado);

         // TODO: Eliminar archivos temporal
         $revision->eliminarArchivosPDF($idSeleccionado);
 
         // Si todo el proceso acabo correctamete, regresar al dashboard
         header("Location: ../../PanelDeControlProfesor-Menu.php");
         exit(); 
} else {
    echo "No se ha seleccionado ningún ID para denegar la solicitud.";
}
?>
