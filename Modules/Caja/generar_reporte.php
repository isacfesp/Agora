<?php
require('../../Config/fpdf/fpdf.php');
include("../../Config/conexion.php");

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Historial de Pagos', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

$id_alumno = isset($_GET['id_alumno']) ? $_GET['id_alumno'] : die('ID de alumno requerido');

// Obtener datos del alumno
$sql = "SELECT matricula, CONCAT(nombre, ' ', apaterno, ' ', amaterno) as nombre_completo 
        FROM alumno WHERE id_alumno = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$result = $stmt->get_result();
$alumno = $result->fetch_assoc();

// Obtener pagos de caja
$sql_caja = "SELECT 'Caja' as tipo, fecha_pago, concepto, monto, metodo_pago 
             FROM caja WHERE id_alumno = ?";
$stmt = $connection->prepare($sql_caja);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$result_caja = $stmt->get_result();

// Obtener pagos de colegiatura
$sql_col = "SELECT 'Colegiatura' as tipo, fecha_pago, mes as concepto, monto, metodo_pago 
            FROM colegiatura WHERE id_alumno = ?";
$stmt = $connection->prepare($sql_col);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$result_col = $stmt->get_result();

$pdf = new PDF();
$pdf->AddPage();

// Información del alumno
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Datos del Alumno:', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Matrícula: ' . $alumno['matricula'], 0, 1);
$pdf->Cell(0, 10, 'Nombre: ' . $alumno['nombre_completo'], 0, 1);
$pdf->Ln(10);

// Encabezados de tabla
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 10, 'Fecha', 1);
$pdf->Cell(30, 10, 'Tipo', 1);
$pdf->Cell(60, 10, 'Concepto', 1);
$pdf->Cell(30, 10, 'Monto', 1);
$pdf->Cell(30, 10, 'Método', 1);
$pdf->Ln();

// Contenido de la tabla
$pdf->SetFont('Arial', '', 10);
while ($row = $result_caja->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['fecha_pago'], 1);
    $pdf->Cell(30, 10, $row['tipo'], 1);
    $pdf->Cell(60, 10, $row['concepto'], 1);
    $pdf->Cell(30, 10, '$' . number_format($row['monto'], 2), 1);
    $pdf->Cell(30, 10, $row['metodo_pago'], 1);
    $pdf->Ln();
}

while ($row = $result_col->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['fecha_pago'], 1);
    $pdf->Cell(30, 10, $row['tipo'], 1);
    $pdf->Cell(60, 10, $row['concepto'], 1);
    $pdf->Cell(30, 10, '$' . number_format($row['monto'], 2), 1);
    $pdf->Cell(30, 10, $row['metodo_pago'], 1);
    $pdf->Ln();
}

// Total de pagos
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$sql_total = "SELECT 
    (SELECT COALESCE(SUM(monto), 0) FROM caja WHERE id_alumno = ?) +
    (SELECT COALESCE(SUM(monto), 0) FROM colegiatura WHERE id_alumno = ?) as total";
$stmt = $connection->prepare($sql_total);
$stmt->bind_param("ii", $id_alumno, $id_alumno);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];
$pdf->Cell(0, 10, 'Total Pagado: $' . number_format($total, 2), 0, 1, 'R');

$pdf->Output('D', 'Historial_Pagos_' . $alumno['matricula'] . '.pdf');