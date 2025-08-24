<?php

// conexion.php

// Cargar el autoload de Composer para Dotenv
require __DIR__ . '/../vendor/autoload.php';

// Cargar las variables de entorno
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (Exception $e) {
    error_log("Error al cargar .env: " . $e->getMessage());
    http_response_code(500);
    die("Error interno del servidor. Inténtelo más tarde.");
}

// Configuración de la conexión con PDO
$db_host = $_ENV['DB_HOST'];
$db_user = $_ENV['DB_USERNAME'];
$db_pass = $_ENV['DB_PASSWORD'];
$db_name = $_ENV['DB_DATABASE'];
$db_port = $_ENV['DB_PORT'];
$db_charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4'; // Usa un valor por defecto si no está definido

try {
    // Definición del DSN (Data Source Name)
    $dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=$db_charset";
    $options = [
        PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION, // Lanzar excepciones en caso de errores
        PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC,       // Devolver arrays asociativos por defecto
        PDO::ATTR_EMULATE_PREPARES     => false,                  // Deshabilitar la emulación de sentencias preparadas
    ];
    
    // Crear una nueva instancia de PDO
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    
    // Devolver el objeto de conexión PDO
    return $pdo;

} catch (\PDOException $e) {
    // Registro de error detallado para el log, no para el usuario
    error_log("Error de conexión PDO: " . $e->getMessage());
    
    // Mensaje genérico para el usuario
    http_response_code(500);
    die("Hubo un problema de conexión con la base de datos.");
}