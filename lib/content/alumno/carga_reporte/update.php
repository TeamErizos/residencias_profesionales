<?php
// Establecer la conexión a la base de datos
require_once '../../../login/conexion/conectAWS.php';

// Obtener el id_proyecto_activo seleccionado del formulario
$id_proyecto_activo = $_POST['id_proyecto_activo'];

// Verificar si se ha enviado un archivo
if(isset($_FILES['file'])) {
  $nombre_original = $_FILES['file']['name'];
  $tipo = $_FILES['file']['type'];
  $tamaño = $_FILES['file']['size'];
  $temp = $_FILES['file']['tmp_name'];

  // Verificar si se ha producido un error al cargar el archivo
  if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    die('Error al cargar el archivo: ' . $_FILES['file']['error']);
  }

  // Leer el contenido del archivo
  $contenido = file_get_contents($temp);

  // Verificar si el id_proyecto_activo es un entero válido
  if (!is_numeric($id_proyecto_activo)) {
    die('El id_proyecto_activo no es un entero válido.');
  }

  try {
 
    // Actualizar la tabla Documentos con el archivo PDF
    $sql = "UPDATE Documentos SET reporte_final = :reporte_final WHERE id_proyecto_activo = :id_proyecto_activo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_proyecto_activo', $id_proyecto_activo, PDO::PARAM_INT);
    $stmt->bindParam(':reporte_final', $contenido, PDO::PARAM_LOB);
    $stmt->execute();

   // Redireccionar a ver_archivos.php
    header('Location: ../PanelDeControl-Menu.php');
    exit;

  } catch (PDOException $e) {
    die('Error al insertar el archivo en la base de datos: ' . $e->getMessage());
  }

} else {
  die('No se ha enviado ningún archivo.');
}
?>
