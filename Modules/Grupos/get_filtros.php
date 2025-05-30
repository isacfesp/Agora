<?php
<?php
include("../../Config/conexion.php");

try {
    $response = array(
        'grados' => array(),
        'profesores' => array(),
        'periodos' => array()
    );

    // Obtener grados
    $sqlGrados = "SELECT id_grado, descripcion FROM grado ORDER BY descripcion";
    $resultGrados = $connection->query($sqlGrados);
    
    while ($row = $resultGrados->fetch_assoc()) {
        $response['grados'][] = array(
            'id' => $row['id_grado'],
            'descripcion' => $row['descripcion']
        );
    }

    // Obtener profesores
    $sqlProfesores = "SELECT p.id_profesor, CONCAT(u.nombre, ' ', u.apaterno, ' ', u.amaterno) as nombre_completo 
                      FROM profesor p 
                      JOIN usuario u ON p.id_usuario = u.id_usuario 
                      ORDER BY u.nombre";
    $resultProfesores = $connection->query($sqlProfesores);
    
    while ($row = $resultProfesores->fetch_assoc()) {
        $response['profesores'][] = array(
            'id' => $row['id_profesor'],
            'nombre' => $row['nombre_completo']
        );
    }

    // Obtener periodos
    $sqlPeriodos = "SELECT id_periodo, DATE_FORMAT(fecha, '%Y-%m') as fecha 
                    FROM periodo 
                    ORDER BY fecha DESC";
    $resultPeriodos = $connection->query($sqlPeriodos);
    
    while ($row = $resultPeriodos->fetch_assoc()) {
        $response['periodos'][] = array(
            'id' => $row['id_periodo'],
            'fecha' => $row['fecha']
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}