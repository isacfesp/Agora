<?php
include("../../Config/conexion.php");

$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '';

$sql = "SELECT * FROM alumno";
if (!empty($periodo)) {
    $sql .= " WHERE curso = '$periodo'";
}

$result = mysqli_query($connection, $sql);
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>