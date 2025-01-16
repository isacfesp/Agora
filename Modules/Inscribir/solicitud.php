<?php
require('../../Config/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Encabezado
    function Header()
    {
        //Linea Horizontal
        $this->SetDrawColor(187, 205, 93); 
        $this->SetLineWidth(1.3); 
        $this->Line(55, 15, 205, 15); 
        $this->Ln(8);


        // Logo
        $this->Image('../../Assets/Images/LogoTrans.png', 5, 0, 50);
        $this->SetFont('Times', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 4, 'Plaza Coral, Local 2', 0, 1, 'R');
        $this->Cell(0, 4, 'Av. Industrias #2110', 0, 1, 'R');
        $this->Cell(0, 4, 'Col. Providencia', 0, 1, 'R');
        $this->Cell(0, 4, 'C.P. 78395', 0, 1, 'R');
        $this->Cell(0, 4, 'Tel. 444-873-34-2', 0, 1, 'R');

        // Cuadro para fotografía
        $this->SetFont('Times', '', 10);
        $this->SetLineWidth(0.3);
        $this->SetDrawColor(0, 0, 0);
        $this->SetXY(95, 17);
        $this->Cell(25, 30, '', 1, 1, 'C');
        $this->SetXY(93, 40);
        $this->Cell(30, 5, 'FOTOGRAFIA', 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    
    // Cuerpo del documento
    function Body()
    {

        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 0, utf8_decode('SOLICITUD DE INSCRIPCIÓN'), 0, 1, 'C');
        $this->Ln(5);


        $this->SetFont('Times', 'B', 11);
        $this->Cell(130, 5, 'Fecha:', 0, 0, 'R');
        $this->Cell(50, 5, '_______________________     ', 0, 1, 'R');
        $this->Ln(5);


        $this->SetFont('Times', '', 11);
        $this->Cell(0, 0, '          Mecanica en Reparacion de Motocicletas                                                                                                          ', 0, 1, 'C');
        $this->SetFont('Times', 'B', 14);
        $this->Cell(0, 1, '    _______________________________________________________________      ', 0, 1, 'C');
        $this->SetFont('Times', 'B', 8);
        $this->Cell(0, 7, '             Carrera / Especialidad / Cursos                                                Horario                                         Matricula                    ', 0, 1, 'C');
        $this->Ln(3);


        $this->SetFont('Times', 'B', 11);
        $this->Cell(0, 10, '                   DATOS DEL ALUMNO:', 0, 1);
        $this->Ln(2);
        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 2, '                     ________________________________________________________________________________________ ', 0, 1);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(45, 5, '                                               Apellido Paterno', 0, 0);
        $this->Cell(45, 5, '                                                         Apellido Materno', 0, 0);
        $this->Cell(45, 5, '                                                                         Nombre(s)', 0, 1);
        $this->Ln(8);


        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 2, '                     ________________________________________________________________________________________ ', 0, 1);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(45, 5, '                                           Fecha de Nacimiento', 0, 0);
        $this->Cell(45, 5, '                                                                  Edad', 0, 0);
        $this->Cell(45, 5, '                                                                             CURP', 0, 1);
        $this->Cell(45, 2, '                                                DD/MM/AAAA', 0, 1);
        $this->Ln(10);

        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 2, '                     ________________________________________________________________________________________ ', 0, 1);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(45, 5, '                                                   Telefono Fijo', 0, 0);
        $this->Cell(45, 5, '                                                        Telefono Celular', 0, 0);
        $this->Cell(45, 5, '                                                                    Correo Electronico', 0, 1);
        $this->Ln(3);

        $this->SetFont('Times', 'B', 11);
        $this->Cell(0, 10, utf8_decode('                   DIRECCIÓN:'), 0, 1);
        $this->Ln(2);
        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 2, '                     ________________________________________________________________________________________ ', 0, 1);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(45, 5, '                                           Calle y No.', 0, 0);
        $this->Cell(45, 5, '                                   Colonia', 0, 0);
        $this->Cell(45, 5, '                               C.P.', 0, 0);
        $this->Cell(45, 5, '                Municipio', 0, 0);
        $this->Ln(9);
        
        $this->SetFont('Times', 'B', 11);
        $this->Cell(0, 10, utf8_decode('                   DATOS DEL PADRE O TUTOR:'), 0, 1);
        $this->Ln(2);
        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 2, '                     ________________________________________________________________________________________ ', 0, 1);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(45, 5, '                                               Apellido Paterno', 0, 0);
        $this->Cell(45, 5, '                                                      Apellido Materno', 0, 0);
        $this->Cell(45, 5, '                                                                         Nombre(s)', 0, 1);
        $this->Ln(8); 
        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 2, '                     ________________________________________________________________________________________ ', 0, 1);;
        $this->SetFont('Times', 'B', 8);
        $this->Cell(45, 5, '                                                  Telefono Fijo', 0, 0);
        $this->Cell(45, 5, '                                                        Telefono Celular', 0, 0);
        $this->Cell(45, 5, '                                                                    Correo Electronico', 0, 1);
        $this->Ln(10);

        $this->SetFont('Times', 'B', 11);
        $this->Cell(0, 10, utf8_decode('                   EN CASO DE EMERGENCIA COMUNICARSE CON:'), 0, 1);
        $this->Ln(3);
        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 2, '                     ________________________________________________________________________________________ ', 0, 1);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(45, 5, '                                                Apellido Paterno', 0, 0);
        $this->Cell(45, 5, '                                                        Apellido Materno', 0, 0);
        $this->Cell(45, 5, '                                                                           Nombre(s)', 0, 1);
        $this->Ln(5);


        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 2, '                     ________________________________________________________________________________________ ', 0, 1);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(45, 5, '                                                      Parentesco', 0, 0);
        $this->Cell(45, 5, utf8_decode('                                                                 Teléfono'), 0, 0);
        $this->Ln(21); 






        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 2, '                     ______________________________                                                       ______________________________     ', 0, 1);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(45, 5, '                                      Nombre y Firma del Alumno', 0, 0);
        $this->Cell(45, 5, '                                                                                                                  Nombre y Firma del Padre o Tutor', 0, 1);
    }
}

$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->Body();
$pdf->Output(utf8_decode('SOLICITUD DE INSCRIPCION IMMOTO CORAL'), 'I');
