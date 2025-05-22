<?php
include "../../Config/conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/CSS/crearContacto.css">
</head>
<body>
    <div class="container form-container">
        <div class="form-box">
            <a href="../../Templates/Gestion_usuarios.html" class="btn-back">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
            <!-- Formulario -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" id="email" placeholder="Ingresa el correo" required name="email">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" placeholder="Ingresa la contraseña" required name="password">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre" required name="nombre">
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
                    <label for="estado">Estado:</label>
                    <select class="form-control" id="estado" required name="estado">
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo_usuario">Tipo de Usuario:</label>
                    <select class="form-control" id="tipo_usuario" required name="tipo_usuario">
                        <option value="1">Administrador</option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"></option>
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

        $email = $_POST["email"];
        $password = $_POST["password"];
        $nombre = $_POST["nombre"];
        $apaterno = $_POST["apaterno"];
        $amaterno = $_POST["amaterno"];
        $estado = $_POST["estado"];
        $tipo_usuario = $_POST["tipo_usuario"];

        // Hash de la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = mysqli_query($connection, "INSERT INTO usuario (email, password, nombre, apaterno, amaterno, estado, tipo_usuario) VALUES ('$email', '$password_hash', '$nombre', '$apaterno', '$amaterno', '$estado', '$tipo_usuario')");
        if ($sql) {
            echo "<script>
                window.onload = function() {
                    document.getElementById('overlay').style.display = 'flex';
                }
            </script>";
        } else {
            echo "No se creó el usuario";
        }
    }
}
?>

<!-- Ventana emergente de éxito -->
<div class="overlay" id="overlay" style="display: none;">
    <div class="popup">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark-check" fill="none" stroke="#BBCD5D" stroke-width="5"
                d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <p>¡Usuario creado exitosamente!</p>
        <button class="btn-primary" onclick="closePopup()">Aceptar</button>
    </div>
</div>

<script>
    function closePopup() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>