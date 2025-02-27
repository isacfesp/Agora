<?php
include("../Config/conexion.php");

$sql = mysqli_query($connection, "SELECT * from alumno");
$contar = mysqli_num_rows($sql);

$horario = mysqli_query($connection, "SELECT horario from alumno");
if($horario == 1){
    $semana = $horario;
} else{
    $sabado = $horario;
}
?>