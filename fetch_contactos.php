<?php
function fetchContactos($start = null, $end = null)
{
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'agora';

    $conn = new mysqli($host, $user, $password, $dbname);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }

    if ($start && $end) {
        $stmt = $conn->prepare("SELECT * FROM contacto WHERE DATE(fecha_creacion) BETWEEN ? AND ?");
        $stmt->bind_param('ss', $start, $end);
    } else {
        $stmt = $conn->prepare("SELECT * FROM contacto");
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $data;
}
