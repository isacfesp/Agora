<?php
require('../../Config/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Encabezado
    function Header()
    {
        // Logo
       $this->Image('../../Assets/Images/LogoTrans.png', 5, 0, 50); // Cambia 'logo.png' por la ruta de tu imagen
        $this->SetFont('Times', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 4, 'Plaza Coral, Local 2', 0, 1, 'R');
        $this->Cell(0, 4, 'Av. Industrias #2110', 0, 1, 'R');
        $this->Cell(0, 4, 'Col. Providencia', 0, 1, 'R');
        $this->Cell(0, 4, 'C.P. 78395', 0, 1, 'R');
        $this->Cell(0, 4, 'Tel. 444-873-34-2', 0, 1, 'R');

        // Cuadro para fotografía
        $this->SetXY(92, 10);
        $this->Cell(27, 30, '', 1, 1, 'C'); // Marco para la foto
        $this->SetXY(90, 40);
        $this->Cell(30, 5, 'FOTOGRAFIA', 0, 1, 'C');
        $this->Ln(5);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 9);
        $this->Cell(0, 10, utf8_decode( 'Página ') . $this->PageNo(), 0, 0, 'C');
    }

    // Cuerpo del documento
    function Body()
    {
        // Título
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 0, 'SOLICITUD DE INSCRIPCION', 0, 1, 'C');
        $this->Ln(5);

        // Fecha
        $this->SetFont('Times', 'B', 11);
        $this->Cell(130, 5, 'Fecha:', 0, 0, 'R');
        $this->Cell(50, 5, '________________________', 0, 1, 'R');
        $this->Ln(5);

        // Subtítulo
        $this->SetFont('Times', '', 11);
        $this->Cell(0, 0, 'Mecanica en Reparacion de Motocicletas                                                                                                ', 0, 1, 'C');
        $this->SetFont('Times', 'B', 14);
        $this->Cell(0, 3, '____________________________________________________________________', 0, 1, 'C');
        $this->SetFont('Times', '', 9);
        $this->Cell(0, 5, 'Carrera / Especialidad / Cursos                                                 Horario                                               Matricula', 0, 1, 'C');
        $this->Ln(10);

        // Datos del alumno
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, 'DATOS DEL ALUMNO:', 0, 1);

        $this->SetFont('Arial', '', 9);
        $this->Cell(45, 5, 'Apellido Paterno:', 0, 0);
        $this->Cell(50, 5, '__________________', 0, 0);
        $this->Cell(45, 5, 'Apellido Materno:', 0, 0);
        $this->Cell(50, 5, '__________________', 0, 1);

        $this->Cell(45, 5, 'Nombre(s):', 0, 0);
        $this->Cell(50, 5, '__________________', 0, 0);
        $this->Cell(45, 5, 'Fecha de Nacimiento:', 0, 0);
        $this->Cell(50, 5, '__________________', 0, 1);

        $this->Cell(45, 5, 'Edad:', 0, 0);
        $this->Cell(50, 5, '__________', 0, 0);
        $this->Cell(45, 5, 'CURP:', 0, 0);
        $this->Cell(50, 5, '__________________', 0, 1);

        $this->Cell(45, 5, 'Telefono Fijo:', 0, 0);
        $this->Cell(50, 5, '__________________', 0, 0);
        $this->Cell(45, 5, 'Telefono Celular:', 0, 0);
        $this->Cell(50, 5, '__________________', 0, 1);

        $this->Cell(45, 5, 'Correo Electronico:', 0, 0);
        $this->Cell(50, 5, '__________________________', 0, 1);
        $this->Ln(5);

        // Dirección
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, 'DIRECCION:', 0, 1);

        $this->SetFont('Arial', '', 9);
        $this->Cell(45, 5, 'Calle y No.:', 0, 0);
        $this->Cell(50, 5, '__________________', 0, 0);
        $this->Cell(45, 5, 'Colonia:', 0, 0);
        $this->Cell(50, 5, '__________________', 0, 1);

        $this->Cell(45, 5, 'C.P.:', 0, 0);
        $this->Cell(50, 5, '__________', 0, 0);
        $this->Cell(45, 5, 'Municipio:', 0, 0);
        $this->Cell(50, 5, '__________________', 0, 1);
        $this->Ln(10);

        // Firmas
        $this->Cell(0, 5, 'Nombre y Firma del Alumno: _________________________', 0, 1);
        $this->Cell(0, 5, 'Nombre y Firma del Padre o Tutor: __________________', 0, 1);
    }
}

// Crear PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->Body();
$pdf->Output();
?>