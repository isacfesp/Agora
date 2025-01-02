<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    die("No estás autenticado.");
}

define('BASE_URL', '/Modules/Config_User/uploads/'); // Cambia esta ruta según tu configuración del servidor

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    echo "El archivo no es una imagen.";
    $uploadOk = 0;
}

if (file_exists($target_file)) {
    echo "Lo siento, el archivo ya existe.";
    $uploadOk = 0;
}

if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG & GIF.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Lo siento, tu archivo no fue subido.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "El archivo " . basename($_FILES["fileToUpload"]["name"]) . " ha sido subido.";

        $conn = new mysqli("localhost", "root", "", "Agora");
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        $usuario_id = $_SESSION['id_usuario'];
        $ruta = $target_file;
        $sql = "INSERT INTO imagenes (ruta, usuario_id) VALUES ('$ruta', $usuario_id)";
        if ($conn->query($sql) === TRUE) {
            echo "Ruta de la imagen almacenada en la base de datos.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    } else {
        echo "Lo siento, hubo un error al subir tu archivo.";
    }
}
?>
