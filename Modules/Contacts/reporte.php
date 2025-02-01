<?php
require('../../Config/fpdf/fpdf.php');
date_default_timezone_set('America/Mexico_City');

class PDF extends FPDF
{
    private $start;
    private $end;

    public function __construct($start = null, $end = null)
    {
        parent::__construct('L', 'mm', 'A4');
        $this->start = $start;
        $this->end = $end;
    }

    function Header()

    {
        
        $this->SetFont('Helvetica', 'I', 18);
        $this->Cell(0, 16, utf8_decode('Reporte de Contactos'), 0, 1, 'C');
        // Configuración de colores
        $this->SetDrawColor(58, 88, 159); // Azul corporativo
        $this->SetFillColor(58, 88, 159);
        $this->SetTextColor(255);
        
        // Encabezado principal
        
        // Logo
        $this->Image('../../Assets/Images/LogoTrans.png', 248, 0, 40);
        
        // Filtros
        if ($this->start && $this->end) {
            $this->SetFont('Helvetica', 'I', 14);
            $this->SetTextColor(0);
            $this->Cell(0, 0, utf8_decode("Período: {$this->start} al {$this->end}"), 0, 1, 'C');
        }
        
        // Encabezado de tabla
        $this->SetY(40);
        $this->SetFont('Helvetica', 'B', 10);
        $this->SetFillColor(58, 88, 159);
        $this->SetTextColor(255);
        $this->SetLineWidth(0.3);
        
        // Columnas
        $headers = ['ID', 'Nombre', 'Apellido P.', 'Apellido M.', 'Teléfono', 'WhatsApp', 'Formato', 'Creación'];
        $widths = [20, 40, 40, 38, 38, 30, 30, 40];
        
        foreach ($headers as $key => $header) {
            $this->Cell($widths[$key], 8, utf8_decode($header), 1, 0, 'C', true);
        }
        $this->Ln();
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Helvetica', 'I', 12);
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
        $this->Cell(0, 10, utf8_decode('Generado el ') . date('d/m/Y H:i'), 0, 0, 'R');
    }
}

require('fetch_contactos.php');

$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;
$data = fetchContactos($start, $end);

$pdf = new PDF($start, $end);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('Helvetica', '', 10);
$pdf->SetDrawColor(221, 221, 221); // Gris claro para bordes
$pdf->SetTextColor(0); // Texto negro

$fill = false;
foreach ($data as $row) {
    $fillColor = $fill ? [245, 245, 245] : [255, 255, 255];
    $pdf->SetFillColor($fillColor[0], $fillColor[1], $fillColor[2]);
    
    $pdf->Cell(20, 8, $row['id_contacto'], 'LRB', 0, 'C', true);
    $pdf->Cell(40, 8, utf8_decode($row['nombre']), 'LRB', 0, 'L', true);
    $pdf->Cell(38, 8, utf8_decode($row['apaterno']), 'LRB', 0, 'L', true);
    $pdf->Cell(38, 8, utf8_decode($row['amaterno']), 'LRB', 0, 'L', true);
    $pdf->Cell(40, 8, $row['numero_telefonico'], 'LRB', 0, 'C', true);
    $pdf->Cell(30, 8, utf8_decode($row['whatsapp']), 'LRB', 0, 'C', true);
    $pdf->Cell(30, 8, utf8_decode($row['formato']), 'LRB', 0, 'C', true);
    $pdf->Cell(40, 8, $row['fecha_creacion'], 'LRB', 1, 'C', true);
    
    $fill = !$fill;
}

$pdf->Output('Reporte_Contactos.pdf', 'I');
?>