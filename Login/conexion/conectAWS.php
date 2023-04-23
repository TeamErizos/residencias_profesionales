<?php
// Datos de conexión a la base de datos
$host = 'database-1.ce6k0ybbwxvv.us-east-2.rds.amazonaws.com';
$dbname = 'residencia';
$user = 'pech';
$password = '654321';

try {
    // Crear la instancia de conexión con PDO
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $conn = new PDO($dsn, $user, $password);
    // Configurar el modo de errores de PDO para mostrar excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Imprimir mensaje de éxito
    echo "Conexión establecida correctamente a la base de datos $dbname en $host";

    $sql = "SELECT * FROM empresa";
    $stmt = $conn->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        echo implode("\t", $row) . "\n";
    }

} catch (PDOException $e) {
    // Imprimir mensaje de error
    echo "Error al conectar a la base de datos $dbname en $host: " . $e->getMessage();
}
?>
