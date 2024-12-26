<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "agora";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id_contacto = $_POST['id'];

    $sql = "DELETE FROM contacto WHERE id_contacto = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_contacto);

    if ($stmt->execute()) {
        echo "Contacto eliminado correctamente"; 
    } else {
        echo "Error al eliminar contacto: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
