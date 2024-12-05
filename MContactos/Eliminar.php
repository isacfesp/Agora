<?php
// Conexión a la base de datos
$servername = "localhost"; // Cambia esto si es necesario
$username = "root"; // Cambia esto si es necesario
$password = ""; // Cambia esto si es necesario
$dbname = "agora";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si se ha enviado el ID
if (isset($_POST['id'])) {
    $id_contacto = $_POST['id'];

    // Eliminar el contacto de la base de datos
    $sql = "DELETE FROM contacto WHERE id_contacto = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_contacto);

    if ($stmt->execute()) {
        echo "Contacto eliminado correctamente"; // Mensaje opcional
    } else {
        echo "Error al eliminar contacto: " . $stmt->error;
    }

    // Cerrar conexión
    $stmt->close();
}

$conn->close();
?>
