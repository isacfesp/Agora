<?php
include("../Config/conexion.php");

$sql = mysqli_query($connection, "SELECT * from alumno");
$contar = mysqli_num_rows($sql);
?>