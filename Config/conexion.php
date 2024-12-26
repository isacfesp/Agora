<?php
$host = "localhost";
$user = "root";
$pwd = "";
$DB = "agora";


$connection = new mysqli($host, $user, $pwd, $DB);

    if($connection->connect_errno){
         die("Conexión fallida: " . mysqli_connect_error());

    }

    $db = mysqli_select_db($connection, $DB);
?>