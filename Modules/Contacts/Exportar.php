<?php

// Archivo para exportar datos de la tabla contacto a un archivo Excel
// Asegúrate de tener la biblioteca PhpSpreadsheet instalada y configurada correctamente
// Este código falló, encutra el error xd.
$host = 'localhost';
$dbname = 'Agora';
$username = 'root';
$password = '';
$table = 'contacto';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM $table";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 resultados";
}
$conn->close();

spl_autoload_register(function ($class) {
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';
    $base_dir = __DIR__ . '/PhpSpreadsheet-master/src/PhpSpreadsheet/'; // Ruta ajustada

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    echo "Buscando archivo en: $file<br>"; // Imprimir la ruta completa

    if (file_exists($file)) {
        require $file;
    } else {
        echo "No se encontró el archivo: $file<br>";
    }
});

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Agregar encabezados
$headers = ['id_contacto', 'nombre', 'apaterno', 'amaterno', 'numero_telefonico', 'whatsapp', 'formato', 'fecha_creacion'];
$column = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($column . '1', $header);
    $column++;
}

// Agregar datos
$rowIndex = 2;
foreach ($data as $row) {
    $column = 'A';
    foreach ($row as $cell) {
        $sheet->setCellValue($column . $rowIndex, $cell);
        $column++;
    }
    $rowIndex++;
}

// Guardar la hoja de cálculo
$writer = new Xlsx($spreadsheet);
$writer->save('datos.xlsx');
?>
