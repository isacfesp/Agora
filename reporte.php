<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    private $start;
    private $end;

    public function __construct($start = null, $end = null)
    {
        parent::__construct();
        $this->start = $start;
        $this->end = $end;
    }

    function Header()
    {
        $this->Image('Images/LogoTrans.png', 170, 8, 35);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 50, 'Reporte Contactos', 0, 0, 'C');
        $this->Ln(30);

        if ($this->start && $this->end) {
            $this->SetFont('Arial', 'I', 12);
            $this->Cell(0, 10, "Filtrado desde: {$this->start} hasta: {$this->end}", 0, 1, 'C');
        }


        $this->SetFont('Arial', 'B', 11);
        $this->Cell(10, 10, 'ID', 1, 0, 'C');
        $this->Cell(30, 10, 'Nombre', 1, 0, 'C');
        $this->Cell(23, 10, 'Apellido P.', 1, 0, 'C');
        $this->Cell(23, 10, 'Apellido M.', 1, 0, 'C');
        $this->Cell(25, 10, 'Tel.', 1, 0, 'C');
        $this->Cell(22, 10, 'WhatsApp', 1, 0, 'C');
        $this->Cell(20, 10, 'Formato', 1, 0, 'C');
        $this->Cell(40, 10, utf8_decode('Fecha de Creación'), 1, 1, 'C');
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

require('fetch_contactos.php');

$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;
$data = fetchContactos($start, $end);

$pdf = new PDF($start, $end);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

foreach ($data as $row) {
    $pdf->Cell(10, 10, $row['id_contacto'], 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode($row['nombre']), 1, 0, 'C');
    $pdf->Cell(23, 10, utf8_decode($row['apaterno']), 1, 0, 'C');
    $pdf->Cell(23, 10, utf8_decode($row['amaterno']), 1, 0, 'C');
    $pdf->Cell(25, 10, $row['numero_telefonico'], 1, 0, 'C');
    $pdf->Cell(22, 10, utf8_decode($row['whatsapp']), 1, 0, 'C');
    $pdf->Cell(20, 10, utf8_decode($row['formato']), 1, 0, 'C');
    $pdf->Cell(40, 10, $row['fecha_creacion'], 1, 1, 'C');
}

$pdf->Output('Reporte_Contactos.pdf', 'I');
