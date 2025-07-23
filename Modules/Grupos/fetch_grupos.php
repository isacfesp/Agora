<?php
include("../../Config/conexion.php");

try {
    // Obtener parámetros de filtrado
    $filtroGrado = isset($_GET['grado']) ? intval($_GET['grado']) : null;
    $filtroProfesor = isset($_GET['profesor']) ? intval($_GET['profesor']) : null;
    $filtroPeriodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : null;

    $sql = "SELECT DISTINCT
                g.id_grupo,
                grd.descripcion AS grado,
                CONCAT(u.nombre, ' ', u.apaterno, ' ', u.amaterno) as profesor_nombre,
                GROUP_CONCAT(DISTINCT DATE_FORMAT(p.fecha, '%Y-%m') ORDER BY p.fecha DESC) as periodo,
                (SELECT COUNT(*) FROM alumno_grupo WHERE id_grupo = g.id_grupo) as total_alumnos
            FROM grupo g
            LEFT JOIN grado grd ON g.id_grado = grd.id_grado
            LEFT JOIN profesor pr ON g.profesor = pr.id_profesor
            LEFT JOIN usuario u ON pr.id_usuario = u.id_usuario
            LEFT JOIN alumno_grupo ag ON g.id_grupo = ag.id_grupo
            LEFT JOIN inscripcion i ON ag.id_alumno = i.id_alumno
            LEFT JOIN periodo p ON i.id_periodo = p.id_periodo
            WHERE 1=1";

    if ($filtroGrado) {
        $sql .= " AND g.id_grado = " . $filtroGrado;
    }
    if ($filtroProfesor) {
        $sql .= " AND g.profesor = " . $filtroProfesor;
    }
    if ($filtroPeriodo) {
        $sql .= " AND i.id_periodo = " . $filtroPeriodo;
    }

    $sql .= " GROUP BY g.id_grupo, grd.descripcion, u.nombre, u.apaterno, u.amaterno";
    $sql .= " ORDER BY g.id_grupo";

    $result = $connection->query($sql);

    if (!$result) {
        throw new Exception("Error en la consulta: " . $connection->error);
    }

    $grupos = array();
    while ($row = $result->fetch_assoc()) {
        $grupos[] = array(
            'id_grupo' => $row['id_grupo'],
            'grado' => $row['grado'] ?? 'Sin asignar',
            'profesor' => $row['profesor_nombre'] ?? 'Sin asignar', 
            'periodo' => $row['periodo'] ?? 'Sin asignar',
            'total_alumnos' => (int)$row['total_alumnos']
        );
    }

    $response = array(
        "data" => $grupos,
        "recordsTotal" => count($grupos),
        "recordsFiltered" => count($grupos)
    );

} catch (Exception $e) {
    $response = array(
        "data" => array(),
        "error" => $e->getMessage(),
        "recordsTotal" => 0,
        "recordsFiltered" => 0
    );
}

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
echo json_encode($response);
exit;
?>