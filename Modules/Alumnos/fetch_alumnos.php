<?php
include("../../Config/conexion.php");

$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '';
$grupo = isset($_GET['grupo']) ? $_GET['grupo'] : '';
$grado = isset($_GET['grado']) ? $_GET['grado'] : '';

$sql = "SELECT 
            alumno.id_alumno, 
            alumno.matricula, 
            alumno.apaterno, 
            alumno.amaterno, 
            alumno.nombre,
            grupo.id_grupo,
            grado.descripcion AS grado,
            DATE_FORMAT(periodo.fecha, '%Y-%m-%d') AS periodo
        FROM alumno
        JOIN alumno_grupo ON alumno.id_alumno = alumno_grupo.id_alumno
        JOIN grupo ON alumno_grupo.id_grupo = grupo.id_grupo
        JOIN grado ON grupo.id_grado = grado.id_grado
        JOIN inscripcion ON alumno.id_alumno = inscripcion.id_alumno
        JOIN periodo ON inscripcion.id_periodo = periodo.id_periodo";

$conditions = [];
$params = [];

if (!empty($periodo)) {
    $conditions[] = "periodo.id_periodo = ?";
    $params[] = $periodo;
}
if (!empty($grupo)) {
    $conditions[] = "grupo.id_grupo = ?";
    $params[] = $grupo;
}
if (!empty($grado)) {
    $conditions[] = "grado.id_grado = ?";
    $params[] = $grado;
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$stmt = $connection->prepare($sql);
if ($params) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}


header('Content-Type: application/json');
echo json_encode($data);
?>