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

    // Consulta para obtener conceptos no pagados por el alumno
    $sql = "SELECT c.id_concepto, c.nombre, c.precio, 
                   COALESCE(p.descuento, 0) AS descuento 
            FROM conceptos c 
            LEFT JOIN promociones p ON c.id_concepto = p.id_concepto
            WHERE c.nombre NOT IN (
                SELECT concepto 
                FROM caja 
                WHERE id_alumno = ?
            )";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $result = $stmt->get_result();

    $conceptos = $result->fetch_all(MYSQLI_ASSOC);

    // Respuesta JSON
    echo json_encode(['status' => 'success', 'data' => $conceptos]);

} catch (Exception $e) {
    // Manejo de errores
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}