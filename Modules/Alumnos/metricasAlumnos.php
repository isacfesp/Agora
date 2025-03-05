<?php
include("../Config/conexion.php");

$sql = mysqli_query($connection, "SELECT * from alumno");
$contar = mysqli_num_rows($sql);

$horario = mysqli_query($connection, "SELECT horario from alumno");
$semana = 0;
$sabado = 0;
while ($row = mysqli_fetch_assoc($horario)) {
    if ($row['horario'] == 1) {
        $semana++;
    } else {
        $sabado++;
    }
}
?>