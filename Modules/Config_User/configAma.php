<?php

include "apiUsuario.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Apellido materno</title>
    <!-- Enlace a Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .btn-primary {
            background-color: #3C4046;
            border: none;
            margin-left: 75%;
        }

        .btn-primary:hover{
            background-color: #3C4046;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            background-color: #e9ecef;
            color: #6c757d;
            padding: 10px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #d6dbdf;
            color: #4a4a4a;
        }

        .btn-back i {
            margin-right: 5px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: popup-animation 0.3s ease-in-out;
        }

        @keyframes popup-animation {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .checkmark {
            width: 50px;
            height: 50px;
            margin: 0 auto 20px;
            display: block;
            stroke-width: 2;
            stroke: #BBCD5D;
            stroke-miterlimit: 10;
            fill: none;
            animation: checkmark-fill 0.4s ease-in-out 0.4s forwards, checkmark-scale 0.3s ease-in-out 0.9s both;
        }

        .checkmark-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke: #BBCD5D;
            fill: none;
            animation: checkmark-stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .checkmark-check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            stroke: #BBCD5D;
            animation: checkmark-check-animation 0.4s cubic-bezier(0.65, 0, 0.45, 1) 1s forwards;
        }

        @keyframes checkmark-stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes checkmark-check-animation {
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes checkmark-scale {

            0%,
            100% {
                transform: none;
            }

            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }

        @keyframes checkmark-fill {
            100% {
                box-shadow: none;
            }
        }

        .btn-primarys {
            padding: 10px 20px;
            background-color: #BBCD5D;
            border-color: #BBCD5D;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primarys:hover {
            background-color: #aabb57;
            border-color: #aabb57;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="form-container mx-auto">
            <!-- Botón para regresar -->
            <a href="config.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="nombre" style="font-size: 24px; margin-bottom: 10%">Apellido materno:</label>
                    <input type="text" id="nombre" name="amaterno" class="form-control" placeholder="Ingresa el apellido materno" value="<?php echo $apellidom;?>">
                </div>
                <div class="d-flex justify-content-between">
                <input type="submit" name="submit" class="btn btn-primary" value="Guardar">
                </div>
            </form>
        </div>
    </div>

    <!-- Enlace a FontAwesome para los íconos -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <!-- Enlace a Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        include "../../Config/conexion.php";
        $userId = $_SESSION['id_usuario'];
        $ama = $_POST['amaterno'];

        $stmt = $connection->prepare("UPDATE usuario SET amaterno = ? WHERE id_usuario = ?");
        $stmt->bind_param("si", $ama, $userId);

        if ($stmt->execute()) {
            echo "<script>
        window.onload = function() {
            document.getElementById('overlay').style.display = 'flex';
        }
        </script>";
        } else {
            echo "Error al actualizar el apellido materno.";
        }

        $stmt->close();
        $connection->close();
    }
}
?>

<!--Ventanas emergentes -->
<div class="overlay" id="overlay" style="display: none;">
    <div class="popup">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark-check" fill="none" stroke="#BBCD5D" stroke-width="5"
                d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <p>¡Operación exitosa!</p>
        <button class="btn-primarys" onclick="closePopup()"><a href="config.php" style="text-decoration:none; color:#fff;">Aceptar</a></button>
    </div>
</div>



<script>
    function closePopup() {
        document.getElementById('overlay').style.display = 'none';
        
    }
</script>

</html>
</html>
