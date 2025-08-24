<?php
session_start();

// Control de acceso. Si el usuario no está autenticado, devuelve un JSON de error.
if (!isset($_SESSION['id_usuario'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso denegado. No estás autenticado.']);
    exit();
}

// Incluye la conexión segura a la base de datos (con PDO).
// La ruta es relativa a la ubicación de este archivo.
try {
    $pdo = require __DIR__ . '/../../Config/conexion.php';
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión con la base de datos.']);
    error_log("Error de conexión en apiUsuario.php: " . $e->getMessage());
    exit();
}

// Establece el encabezado de respuesta a JSON.
header('Content-Type: application/json');

// Consulta para obtener la lista de usuarios.
// Selecciona las columnas que tu DataTables necesita.
$sql = "SELECT id_usuario, email, nombre, apaterno, amaterno, estado, tipo_usuario FROM usuario";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$usuarios = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $usuarios[] = $row;
}

// Devuelve el array de usuarios directamente, ya que 'dataSrc' está vacío en el JS.
echo json_encode($usuarios);