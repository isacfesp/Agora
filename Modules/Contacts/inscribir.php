<?php
include("conexion.php");
$matricula= $_POST['matricula'];
$horario = $_POST['horario'];
$apaterno= $_POST['apaterno'];
$amaterno= $_POST['amaterno'];
$nombre= $_POST['nom'];
$nacimiento = $_POST['nacimiento'];
$edad = $_POST['edad'];
$curp = $_POST['curp'];
$telfijo=$_POST['telfijo'];
$celular= $_POST['celular'];
$email = $_POST['email'];
$calle = $_POST['calle'];
$colonia = $_POST['colonia'];
$cp = $_POST['codpostal'];
$municipio = $_POST['municipio'];
$tutor_apaterno = $_POST['tutor_apaterno'];
$tutor_amaterno = $_POST['tutor_amaterno'];
$tutor_nombre = $_POST['tutor_nombre'];
$tutor_telfijo = $_POST['tutor_telfijo'];
$tutor_celular = $_POST['tutor_celular'];
$tutor_email = $_POST['tutor_email'];
$emergencia_apaterno = $_POST['emergencia_apaterno'];
$emergencia_amaterno = $_POST['emergencia_amaterno'];
$emergencia_nombre = $_POST['emergencia_nombre'];
$parentesco = $_POST['parentesco'];
$emergencia_tel = $_POST['emergencia_telefono'];

$sql = "INSERT INTO alumno(matricula, horario, apaterno, amaterno, nombre, nacimiento, edad, curp, tel_fijo, tel_celular, email, calle, colonia, cp, municipio, tutor_apaterno, tutor_amaterno, tutor_nombre, tutor_tel_fijo, tutor_tel_celular, tutor_email, emergencia_apaterno, emergencia_amaterno, emergencia_tel, emergencia_parentesco)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $connection->prepare($sql);
$stmt->bind_param($matricula, $horario, $apaterno, $amaterno, $nombre, $nacimiento, $edad, $curp, $telfijo, $celular, $email, $calle, $colonia, $cp, $municipio, $tutor_apaterno, $tutor_amaterno, $tutor_nombre, $tutor_telfijo, $tutor_celular, $tutor_email, $emergencia_apaterno, $emergencia_amaterno, $emergencia_nombre, $parentesco, $emergencia_tel);  //bind_param es para vincular variables a una sentencia SQL de forma segura :)
    if ($stmt->execute()) {
        echo "Contacto actualizado correctamente";
    } else {
        echo "Error al actualizar contacto: " . $stmt->error;
    }
    
    
    $stmt->close();
    $connection->close();
?>