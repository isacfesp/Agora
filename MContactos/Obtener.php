<?php
include 'Agora/conexion.php';

$query = "SELECT * FROM contacto";
$result = mysqli_query($conexion, $query);

$contactos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $contactos[] = $row;
}

echo json_encode($contactos);
?>
