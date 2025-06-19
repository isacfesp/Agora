<?php
include("../../Config/conexion.php");

try {
    $connection->begin_transaction();

    $id_alumno = $_POST['id_alumno'];
    $id_concepto = $_POST['concepto'];
    $monto = $_POST['monto']; // Este monto ya incluye el descuento
    $metodo_pago = $_POST['metodo_pago'];

    // Obtener el nombre del concepto
    $stmt = $connection->prepare("SELECT nombre FROM conceptos WHERE id_concepto = ?");
    $stmt->bind_param("i", $id_concepto);
    $stmt->execute();
    $result = $stmt->get_result();
    $concepto = $result->fetch_assoc()['nombre'];

    // Insertar el pago en la tabla caja
    $sql = "INSERT INTO caja (id_alumno, monto, fecha_pago, metodo_pago, concepto) 
            VALUES (?, ?, CURDATE(), ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("idss", $id_alumno, $monto, $metodo_pago, $concepto);
    $stmt->execute();

    $connection->commit();
    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    $connection->rollback();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}