<?php
session_start();

include "../../Config/conexion.php";

$mail = $_POST["email"]; 
$pwd = $_POST["password"];


$sql = "Select * from usuario where email='$mail'";
      $result = mysqli_query($connection, $sql);

      if(mysqli_num_rows($result) > 0){
        $colum = mysqli_fetch_array($result);
        $mail2 = $colum['email'];
        $pwd2 = $colum['password'];
        $estado = $colum['estado'];
        $tipo_user = $colum['tipo_usuario'];
        if($mail2==$mail && $pwd==$pwd2){
            $apa = $colum['apaterno'];
            $ama = $colum['amaterno'];
            $nombre = $colum['nombre'];
            $_SESSION['nombre'] = $nombre;
            $_SESSION['email'] = $mail;
            $_SESSION['apaterno'] = $apa;
            $_SESSION['amaterno'] = $ama;
            $_SESSION['password'] = $pwd;

            if($estado == 1){

                switch($tipo_user){
                    case 1:
                        header('Location: ../../index.php');
                    break;
                    case 2:
                        echo "otro tipo de usuario";
                    break;
                    case 3:
                        echo "otro tipo de usuario";
                    break;
                    case 4:
                        echo "otro tipo de usuario";
                    break;
                }
            }else{
                echo "Usuario inactivo";
            }
        }else{
            echo "usuario y/o contraseña incorrectos";
        }
    }else{
        echo "no se encontró el usuario";
    }



?>