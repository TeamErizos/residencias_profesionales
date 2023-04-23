<?php

// Datos de conexión a la base de datos
$host = 'localhost';
$dbname = 'test';
$user = 'root';
$password = '';

try {
    // Crear la instancia de conexión con PDO
    $dsn = "mysql:host=$host;dbname=$dbname";
    $conn = new PDO($dsn, $user, $password);
    // Configurar el modo de errores de PDO para mostrar excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Imprimir mensaje de éxito
    echo "Conexión establecida correctamente a la base de datos $dbname en $host";
} catch (PDOException $e) {
    // Imprimir mensaje de error
    echo "Error al conectar a la base de datos $dbname en $host: " . $e->getMessage();
}

?>