<?php
include "../../Config/conexion.php";

if (isset($_POST['id'])) {
    $id_contacto = $_POST['id'];

    $sql = "DELETE FROM usuario WHERE id_usuario = ?";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id_contacto);

    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente"; 
    } else {
        echo "Error al eliminar usuario: " . $stmt->error;
    }

    $stmt->close();
}

$connection->close();
?>