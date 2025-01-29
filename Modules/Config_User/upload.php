<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    die("No estás autenticado.");
}

if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
    $target_dir = "uploads/";
    // Crear el directorio si no existe
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $fileName = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9\.]/", "", $fileName); // Evitar conflictos de nombre
    $target_file = $target_dir . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen real
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }

    // Limitar tamaños de archivo (opcional)
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Lo siento, el archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permitir solo ciertos formatos de imagen
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG & GIF.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no fue subido.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $conn = new mysqli("localhost", "root", "", "Agora");
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $usuario_id = $_SESSION['id_usuario'];
            $ruta = $target_file;

            // Eliminar la imagen anterior del servidor
            $sql = "SELECT ruta FROM imagenes WHERE usuario_id = $usuario_id ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $oldImagePath = $row['ruta'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Actualizar ruta en la base de datos
            $sql = "INSERT INTO imagenes (ruta, usuario_id) VALUES ('$ruta', $usuario_id)";
            if ($conn->query($sql) === TRUE) {
                echo "Imagen actualizada correctamente.";
                header("Location: config.php"); // Redirige al perfil
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
} else {
    echo "No se seleccionó ninguna imagen.";
}
?>
