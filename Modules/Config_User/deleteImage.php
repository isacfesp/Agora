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

// Obtener la ruta de la imagen actual
$sql = "SELECT ruta FROM imagenes WHERE usuario_id = $usuario_id ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePath = $row['ruta'];
    // Eliminar el archivo del servidor
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    // Eliminar registro de la base de datos
    $sql = "DELETE FROM imagenes WHERE usuario_id = $usuario_id";
    $conn->query($sql);
}

$conn->close();
header("Location: perfil.php"); // Redirige al perfil
?>
