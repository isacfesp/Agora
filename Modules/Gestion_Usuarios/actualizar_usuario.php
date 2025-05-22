<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'agora';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_usuario = $_POST['id_usuario'];
$estado = $_POST['estado'];
$tipo_usuario = $_POST['tipo'];

$sql = "UPDATE usuario SET estado = ?, tipo_usuario = ? WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii",  $estado, $tipo_usuario, $id_usuario);

if ($stmt->execute()) {
    echo "Contacto actualizado correctamente";
} else {
    echo "Error al actualizar contacto: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>