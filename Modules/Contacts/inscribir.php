<?php

// Este archivo ya no es funcional, se ha cambiado a un archivo PHP que recibe los datos del formulario y para insertarlos en la base de datos.
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "agora";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$valores = [
    $matricula = $_POST['matricula'],
    $horario = $_POST['horario'],
    $apaterno= $_POST['apaterno'],
    $amaterno= $_POST['amaterno'],
    $nombre= $_POST['nom'],
    $nacimiento = $_POST['nacimiento'],
    $edad = $_POST['edad'],
    $curp = $_POST['curp'],
    $telfijo=$_POST['telfijo'],
    $celular= $_POST['celular'],
    $email = $_POST['email'],
    $calle = $_POST['calle'],
    $colonia = $_POST['colonia'],
    $cp = $_POST['codpostal'],
    $municipio = $_POST['municipio'],
    $tutor_apaterno = $_POST['tutor_apaterno'],
    $tutor_amaterno = $_POST['tutor_amaterno'],
    $tutor_nombre = $_POST['tutor_nombre'],
    $tutor_telfijo = $_POST['tutor_telfijo'],
    $tutor_celular = $_POST['tutor_celular'],
    $tutor_email = $_POST['tutor_email'],
    $emergencia_apaterno = $_POST['emergencia_apaterno'],
    $emergencia_amaterno = $_POST['emergencia_amaterno'],
    $emergencia_nombre = $_POST['emergencia_nombre'],
    $parentesco = $_POST['parentesco'],
    $emergencia_tel = $_POST['emergencia_telefono']
];

$sql = "INSERT INTO alumno(matricula, horario, apaterno, amaterno, nombre, nacimiento, edad, curp, tel_fijo, tel_celular, email, calle, colonia, cp, municipio, tutor_apaterno, tutor_amaterno, tutor_nombre, tutor_tel_fijo, tutor_tel_celular, tutor_email, emergencia_apaterno, emergencia_amaterno, emergencia_nombre, emergencia_tel, emergencia_parentesco)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

    if ($stmt->execute($valores)) {
        echo "Contacto inscrito correctamente";
    } else {
        echo "Error al inscribir contacto: " . $stmt->error;
    }
    
    
    $stmt->close();
    $conn->close();
?>