<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'agora';

// Conexión a la base de datos
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}


// Inicialización de variables
$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;

if ($start && $end) {
    $stmt = $conn->prepare("SELECT * FROM contacto WHERE DATE(fecha_creacion) BETWEEN ? AND ?");
    $stmt->bind_param('ss', $start, $end);
} else {
    $stmt = $conn->prepare("SELECT * FROM contacto");
}

// Ejecutar consulta
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Enviar respuesta en JSON
echo json_encode($data);

$stmt->close();
$conn->close();
?>
