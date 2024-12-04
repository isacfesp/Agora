<?php
include 'Agora/conexion.php';

$id = $_POST['id_contacto'];
$query = "DELETE FROM contacto WHERE id_contacto = $id";
mysqli_query($conexion, $query);
?>
