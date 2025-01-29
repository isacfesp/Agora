<?php
function fetchAlumnos()
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

    $stmt = $conn->prepare("SELECT * FROM alumno");
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($data);
}
fetchAlumnos();
?>
