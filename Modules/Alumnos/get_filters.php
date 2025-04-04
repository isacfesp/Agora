<?php
include("../../Config/conexion.php");

$data = [
    'periodos' => [],
    'grupos' => [],
    'grados' => []
];


$result = mysqli_query($connection, "SELECT id_periodo, fecha FROM periodo");
while ($row = mysqli_fetch_assoc($result)) {
    $data['periodos'][] = $row;
}


$result = mysqli_query($connection, "SELECT id_grupo FROM grupo");
while ($row = mysqli_fetch_assoc($result)) {
    $data['grupos'][] = $row;
}


$result = mysqli_query($connection, "SELECT id_grado, descripcion FROM grado");
while ($row = mysqli_fetch_assoc($result)) {
    $data['grados'][] = $row;
}

echo json_encode($data);
?>
