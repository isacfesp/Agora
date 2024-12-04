<?php
include '../conexion.php';

$id = $_POST['id_contacto'];
$nombre = $_POST['nombre'];
$apaterno = $_POST['apaterno'];
$amaterno = $_POST['amaterno'];
$numero = $_POST['numero_telefonico'];
$whatsapp = $_POST['whatsapp'];
$formato = $_POST['formato'];

$query = "UPDATE contacto SET 
    nombre = '$nombre',
    apaterno = '$apaterno',
    amaterno = '$amaterno',
    numero_telefonico = '$numero',
    whatsapp = '$whatsapp',
    formato = '$formato'
    WHERE id_contacto = $id";

mysqli_query($conexion, $query);
?>
