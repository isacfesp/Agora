<?php
session_start();
include "../../Config/conexion.php";

// Get all users
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT id_usuario, email, nombre, apaterno, amaterno, estado, tipo_usuario FROM usuario";
    $result = mysqli_query($connection, $sql);
    
    $users = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    
    header('Content-Type: application/json');
    echo json_encode($users);
}

// Toggle user status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle_status') {
    $userId = $_POST['user_id'];
    $currentStatus = $_POST['current_status'];
    $newStatus = $currentStatus == 1 ? 0 : 1;
    
    $sql = "UPDATE usuario SET estado = ? WHERE id_usuario = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $newStatus, $userId);
    
    $response = array();
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Estado actualizado correctamente';
        $response['new_status'] = $newStatus;
    } else {
        $response['success'] = false;
        $response['message'] = 'Error al actualizar el estado';
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
}

$connection->close();
?>