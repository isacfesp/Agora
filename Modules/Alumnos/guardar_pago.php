<?php
require '../../Config/conexion.php';

$id_alumno = $_POST["id_alumno"];
$mat = $_POST["id_inscripcion"];
$sql = "SELECT * FROM alumno WHERE matricula = '$mat'";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_alumno = $row['id_alumno'];
    $sql = "SELECT * FROM inscripcion WHERE id_alumno = '$id_alumno'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_inscripcion = $row['id_inscripcion'];
        $tipoPago = $_POST['tipoPago'];
        if ($tipoPago == 'caja') {
            $concepto = $_POST['concepto'];
            $monto = $_POST['monto'];
            $sql = "INSERT INTO caja (id_pago, id_inscripcion, monto, concepto) VALUES (id_pago, '$id_inscripcion', '$monto', '$concepto')";
            if ($connection->query($sql) === TRUE) {
                // Actualizar el estado del alumno a 'activo' si el concepto es 'Inscripción'
                if ($concepto === 'Inscripción') {
                    $sql = "UPDATE alumno SET estado = 'activo' WHERE id_alumno = '$id_alumno'";
                    $connection->query($sql);
                }
                header("Location: alumno.php?id_alumno=$id_alumno&status=success");
            } else {
                header("Location: alumno.php?id_alumno=$id_alumno&status=error");
            }
            exit();
        } else {
            $mes = $_POST['mes'];
            $sql = "INSERT INTO colegiatura (id_colegiatura, id_inscripcion, mes) VALUES (id_colegiatura, '$id_inscripcion', '$mes')";
            if ($connection->query($sql) === TRUE) {
                header("Location: alumno.php?id_alumno=$id_alumno&status=success");
            } else {
                header("Location: alumno.php?id_alumno=$id_alumno&status=error");
            }
            exit();
        }
    } else {
        echo "No se encontró la inscripción del alumno.";
    }
} else {
    echo "No se encontró el alumno.";
}
?>