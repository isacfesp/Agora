<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fb;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-box {
            width: 100%;
            max-width: 600px;
            margin: 20px;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #BBCD5D;
            border-color: #BBCD5D;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #aabb57;
            border-color: #aabb57;
        }

        .btn-back {
            background-color: #e9ecef;
            color: #6c757d;
            border: none;
            display: inline-flex;
            align-items: center;
            padding: 10px 15px;
            font-size: 0.9rem;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background-color: #d6dbdf;
            text-decoration: none;
        }

        .btn-back i {
            margin-right: 5px;
        }

        .modal-content {
            position: relative;
            overflow: hidden;
        }

       

        .modal.show .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .btn-primary {
            background-color: #BBCD5D;
            border-color: #BBCD5D;
        }

        .btn-primary:hover {
            background-color: #aabb57;
            border-color: #aabb57;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        .btn-primary {
            padding: 10px 20px;
            background-color: #BBCD5D;
            border-color: #BBCD5D;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #aabb57;
            border-color: #aabb57;
        }
    </style>
</head>

<body>
    <div class="container form-container">
        <div class="form-box">
            <a href="../../Templates/contactos.html" class="btn-back">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>

            <!-- Formulario -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre" required
                        name="name">
                </div>
                <div class="form-group">
                    <label for="apaterno">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="apaterno" placeholder="Ingresa el apellido paterno"
                        required name="apaterno">
                </div>
                <div class="form-group">
                    <label for="amaterno">Apellido Materno:</label>
                    <input type="text" class="form-control" id="amaterno" placeholder="Ingresa el apellido materno"
                        required name="amaterno">
                </div>
                <div class="form-group">
                    <label for="telefono">Número Telefónico:</label>
                    <input type="text" class="form-control" id="telefono" placeholder="Ingresa el número telefónico"
                        maxlength="10" pattern="\d{10}" required name="num">
                </div>
                <div class="form-group">
                    <label for="whatsapp">WhatsApp:</label>
                    <select class="form-control" id="whatsapp" required name="whatsapp">
                        <option value="">Selecciona una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="formato">Formato:</label>
                    <select class="form-control" id="whatsapp" required name="formato">
                        <option value="">Selecciona una opción</option>
                        <option value="Sí">Facebook</option>
                        <option value="No">Familiar</option>
                        <option value="No">Instagram</option>
                        <option value="No">Tik Tok</option>
                        <option value="No">Conocido</option>
                        <option value="No">Otro</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="submit">Guardar</button>
            </form>
        </div>
    </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['submit'])) {

            require '../../Config/conexion.php';

            $name = $_POST["name"];
            $apaterno = $_POST["apaterno"];
            $amaterno = $_POST["amaterno"];
            $num = $_POST["num"];
            $whatsapp = $_POST["whatsapp"];
            $formato = $_POST["formato"];

            $sql = mysqli_query($connection, "INSERT INTO contacto (nombre, apaterno, amaterno, numero_telefonico, whatsapp, formato) values ('$name', '$apaterno', '$amaterno', '$num', '$whatsapp', '$formato') ");
            if ($sql) {
                echo "<script>
        window.onload = function() {
            document.getElementById('overlay').style.display = 'flex';
        }
        </script>";
            } else {
                echo "No se creó el contacto";
            }
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>


<!--Ventanas emergentes -->
<div class="overlay" id="overlay" style="display: none;">
    <div class="popup">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark-check" fill="none" stroke="#BBCD5D" stroke-width="5"
                d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <p>¡Operación exitosa!</p>
        <button class="btn-primary" onclick="closePopup()">Aceptar</button>
    </div>
</div>



<script>
    function closePopup() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>



</html>