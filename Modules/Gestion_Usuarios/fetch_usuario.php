<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'agora';

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Usuario no encontrado']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}

$conn->close();
?>