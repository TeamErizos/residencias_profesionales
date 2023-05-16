<?php
// Datos de conexión a la base de datos
$host = 'database-1.ce6k0ybbwxvv.us-east-2.rds.amazonaws.com';
$dbname = 'residencia';
$user = 'frontend';
$password = 'galleta';

try {
    
    // Crear la instancia de conexión con PDO
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $conn = new PDO($dsn, $user, $password);
    // Configurar el modo de errores de PDO para mostrar excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Imprimir mensaje de error
    echo "Error al conectar a la base de datos $dbname en $host: " . $e->getMessage();
}
?>
