<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/CSS/crearContacto.css">
</head>

<body>
    <div class="container form-container">
        <div class="form-box">
            <a href="../../Templates/contactos.php" class="btn-back">
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