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

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            text-align: center;
            border-radius: 15px;
            padding: 20px;
        }

        .modal-icon {
            font-size: 50px;
            color: #BBCD5D;
            animation: pop 0.5s ease;
        }

        @keyframes pop {
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <div class="container form-container">
        <div class="form-box">
            <a href="javascript:history.back()" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre" required name="name">
                </div>
                <div class="form-group">
                    <label for="apaterno">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="apaterno" placeholder="Ingresa el apellido paterno" required name="apaterno">
                </div>
                <div class="form-group">
                    <label for="amaterno">Apellido Materno:</label>
                    <input type="text" class="form-control" id="amaterno" placeholder="Ingresa el apellido materno" required name="amaterno">
                </div>
                <div class="form-group">
                    <label for="telefono">Número Telefónico:</label>
                    <input type="text" class="form-control" id="telefono" placeholder="Ingresa el número telefónico" maxlength="10" pattern="\d{10}" required name="num">
                </div>
                <div class="form-group">
                    <label for="whatsapp">WhatsApp:</label>
                    <select class="form-control" id="whatsapp" required name="whatsapp">
                        <option value="">Selecciona una opción</option>
                        <option value="Yes">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="formato">Formato:</label>
                    <input type="text" class="form-control" id="formato" placeholder="Ingresa el formato" required name="formato">
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="submit">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Modales -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <i class="modal-icon fas fa-check-circle"></i>
                <h5 class="mt-3">Contacto creado con éxito</h5>
                <button type="button" class="btn btn-primary mt-3" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <i class="modal-icon fas fa-times-circle text-danger"></i>
                <h5 class="mt-3">Error al crear el contacto</h5>
                <button type="button" class="btn btn-primary mt-3" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>

    <!-- Script PHP -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $host = "localhost";
        $user = "root";
        $pwd = "";
        $DB = "agora";

        $connection = new mysqli($host, $user, $pwd, $DB);
        if ($connection->connect_errno) {
            echo "<script>$(document).ready(function(){ $('#errorModal').modal('show'); });</script>";
            exit;
        }

        $name = $_POST["name"];
        $apaterno = $_POST["apaterno"];
        $amaterno = $_POST["amaterno"];
        $num = $_POST["num"];
        $whatsapp = $_POST["whatsapp"];
        $formato = $_POST["formato"];

        $sql = mysqli_query($connection, "INSERT INTO contacto (nombre, apaterno, amaterno, numero_telefonico, whatsapp, formato) VALUES ('$name', '$apaterno', '$amaterno', '$num', '$whatsapp', '$formato')");
        if ($sql) {
            echo "<script>$(document).ready(function(){ $('#successModal').modal('show'); });</script>";
        } else {
            echo "<script>$(document).ready(function(){ $('#errorModal').modal('show'); });</script>";
        }
    }
    ?>

    <!-- Enlaces a JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Usar la versión completa de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>

</html>
