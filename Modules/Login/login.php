<?php
session_start();
include "../../Config/conexion.php";

$mail = mysqli_real_escape_string($connection, $_POST["email"]); 
$pwd = mysqli_real_escape_string($connection, $_POST["password"]);

$sql = "SELECT * FROM usuario WHERE email='$mail'";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    $colum = mysqli_fetch_array($result);
    $mail2 = $colum['email'];
    $pwd2 = $colum['password'];
    $estado = $colum['estado'];
    $tipo_user = $colum['tipo_usuario'];

    if ($mail2 == $mail && $pwd == $pwd2) {
        if ($estado == 1) {
            $_SESSION['id_usuario'] = $colum['id_usuario'];
            $_SESSION['nombre'] = $colum['nombre'];
            $_SESSION['email'] = $mail;
            $_SESSION['apaterno'] = $colum['apaterno'];
            $_SESSION['amaterno'] = $colum['amaterno'];
            $_SESSION['tipo_usuario'] = $colum['tipo_usuario']; 
            $_SESSION['usuario'] = $mail; 

            header('Location: ../../index.php');
            exit();
        } else {
            $_SESSION['error'] = "Usuario inactivo.";
        }
    } else {
        $_SESSION['error'] = "Contraseña incorrecta.";
    }
} else {
    $_SESSION['error'] = "Usuario no encontrado.";
}


header('Location: ../../Templates/login.php');
exit();
?>
