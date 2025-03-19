<?php
include('../../Config/conexion.php');

$id_alumno = $_POST['id_alumno'];

$sql = "UPDATE alumno SET estado = 'baja_temporal' WHERE id_alumno = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id_alumno);
$result = $stmt->execute();

$response = array();
if ($result) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
}


echo json_encode($response);
