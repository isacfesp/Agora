<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "agora";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_contacto = $_POST['contactoId'];
$nombre = $_POST['nombre'];
$apellidoPaterno = $_POST['apellidoPaterno'];
$apellidoMaterno = $_POST['apellidoMaterno'];
$telefono = $_POST['telefono'];
$whatsapp = $_POST['whatsapp'];
$formato = $_POST['formato'];

$sql = "UPDATE contacto 
        SET nombre = ?, apaterno = ?, amaterno = ?, numero_telefonico = ?, whatsapp = ?, formato = ?
        WHERE id_contacto = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $nombre, $apellidoPaterno, $apellidoMaterno, $telefono, $whatsapp, $formato, $id_contacto);

if ($stmt->execute()) {
    echo "Contacto actualizado correctamente";
} else {
    echo "Error al actualizar contacto: " . $stmt->error;
}


$stmt->close();
$conn->close();
?>
