<?php
session_start();
include "../../Config/conexion.php";
$usuario_id = $_SESSION['id_usuario'];

$sql = "SELECT * FROM usuario WHERE id_usuario = $usuario_id";
$result = mysqli_query($connection, $sql);

if(mysqli_num_rows($result) > 0){
$colum = mysqli_fetch_array($result);
$nombres = $colum['nombre'];
$apellidop = $colum['apaterno'];
$apellidom = $colum['amaterno'];


}

?>