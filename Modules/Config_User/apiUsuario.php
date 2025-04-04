<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    die("No estás autenticado.");
}

$conn = new mysqli("localhost", "root", "", "Agora");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuario_id = $_SESSION['id_usuario'];
$sql = "SELECT nombre, apaterno, amaterno FROM usuario WHERE id_usuario = ? AND estado = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombres = $row['nombre'];
    $apellidop = $row['apaterno'];
    $apellidom = $row['amaterno'];
} else {
    $nombres = "";
    $apellidop = "";
    $apellidom = "";
}

$stmt->close();
$conn->close();
?>