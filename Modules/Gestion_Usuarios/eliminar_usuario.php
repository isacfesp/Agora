<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "agora";
$connection = new mysqli($host, $user, $password, $dbname);
if ($connection->connect_error){
    die("Connection failed:" . $connection->connect_error); 
}

if (isset($_POST['id'])) {
    $id_usuario = $_POST['id'];

    $sql = "DELETE FROM usuario WHERE id_usuario = ?";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id_usuario);

    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente"; 
    } else {
        echo "Error al eliminar usuario: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>