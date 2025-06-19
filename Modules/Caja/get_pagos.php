<?php
include("../../Config/conexion.php");
header('Content-Type: application/json');

// Activar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Validar que se haya proporcionado el ID del alumno
    if (!isset($_GET['id_alumno'])) {
        throw new Exception('ID de alumno no proporcionado');
    }

    $id_alumno = intval($_GET['id_alumno']);
    $response = [];

    // Consulta para obtener pagos de caja
    $sql_caja = "SELECT fecha_pago, metodo_pago, concepto, monto 
                 FROM caja 
                 WHERE id_alumno = ?";
    $stmt_caja = $connection->prepare($sql_caja);
    if (!$stmt_caja) {
        throw new Exception("Error preparando consulta de caja: " . $connection->error);
    }
    $stmt_caja->bind_param("i", $id_alumno);
    if (!$stmt_caja->execute()) {
        throw new Exception("Error ejecutando consulta de caja: " . $stmt_caja->error);
    }
    $result_caja = $stmt_caja->get_result();
    $response['caja'] = $result_caja->fetch_all(MYSQLI_ASSOC);

    // Consulta para obtener pagos de colegiatura
    $sql_colegiatura = "SELECT fecha_pago, metodo_pago, mes, monto 
                        FROM colegiatura 
                        WHERE id_alumno = ?";
    $stmt_colegiatura = $connection->prepare($sql_colegiatura);
    if (!$stmt_colegiatura) {
        throw new Exception("Error preparando consulta de colegiatura: " . $connection->error);
    }
    $stmt_colegiatura->bind_param("i", $id_alumno);
    if (!$stmt_colegiatura->execute()) {
        throw new Exception("Error ejecutando consulta de colegiatura: " . $stmt_colegiatura->error);
    }
    $result_colegiatura = $stmt_colegiatura->get_result();
    $response['colegiatura'] = $result_colegiatura->fetch_all(MYSQLI_ASSOC);

    // Respuesta JSON
    echo json_encode(['status' => 'success', 'data' => $response]);

} catch (Exception $e) {
    // Manejo de errores
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>