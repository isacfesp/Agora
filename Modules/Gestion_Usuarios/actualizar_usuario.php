<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'agora';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$nombre = $_POST['nombre'];
$estado = $_POST['estado'];
$tipo_usuario = $_POST['tipo'];

$sql = "UPDATE usuario SET email = ?, nombre = ?, apaterno = ?, amaterno = ?, estado = ?, tipo = ? WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssii", $email, $nombre, $estado, $tipo_usuario);

if ($stmt->execute()) {
    echo "Contacto actualizado correctamente";
} else {
    echo "Error al actualizar contacto: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>