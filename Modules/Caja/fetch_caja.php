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
            IFNULL(grupo.id_grupo, 'Sin grupo') as id_grupo,
            IFNULL(grado.descripcion, 'Sin grado') as grado
        FROM alumno
        LEFT JOIN alumno_grupo ON alumno.id_alumno = alumno_grupo.id_alumno
        LEFT JOIN grupo ON alumno_grupo.id_grupo = grupo.id_grupo
        LEFT JOIN grado ON grupo.id_grado = grado.id_grado";

$conditions = [];
$params = [];

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

$sql .= " ORDER BY alumno.apaterno, alumno.amaterno, alumno.nombre";

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