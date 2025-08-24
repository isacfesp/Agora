<?php
session_start();

// 1. Incluir y obtener la conexión PDO de forma segura.
try {
    $pdo = require __DIR__ . '/../../Config/conexion.php';
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión con la base de datos.']);
    error_log("Error de conexión en apiUsuario.php: " . $e->getMessage());
    exit();
}

// 2. Establecer el encabezado de respuesta a JSON.
header('Content-Type: application/json');

// 3. Manejar peticiones GET para obtener usuarios.
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT id_usuario, email, nombre, apaterno, amaterno, estado, tipo_usuario FROM usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($users);
    exit();
}

// 4. Manejar peticiones POST para actualizar el estado.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle_status') {
    $userId = $_POST['user_id'];
    $currentStatus = $_POST['current_status'];
    $newStatus = ($currentStatus == 1) ? 0 : 1;
    
    // Usa un bloque try-catch para manejar errores de base de datos.
    try {
        $sql = "UPDATE usuario SET estado = ? WHERE id_usuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$newStatus, $userId]);
    
        $response = [
            'success' => true,
            'message' => 'Estado actualizado correctamente',
            'new_status' => $newStatus
        ];
        echo json_encode($response);
    } catch (\PDOException $e) {
        $response = [
            'success' => false,
            'message' => 'Error al actualizar el estado: ' . $e->getMessage()
        ];
        echo json_encode($response);
    }
    
    exit();
}
// El objeto PDO se cierra automáticamente cuando el script termina.
// Si deseas cerrarlo explícitamente, puedes usar: $pdo = null;
?>