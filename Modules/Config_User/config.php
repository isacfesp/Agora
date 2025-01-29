<?php
include "apiUsuario.php";

if (!isset($_SESSION['id_usuario'])) {
    die("No estás autenticado.");
}

$conn = new mysqli("localhost", "root", "", "Agora");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuario_id = $_SESSION['id_usuario'];
$sql = "SELECT ruta FROM imagenes WHERE usuario_id = $usuario_id ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePath = $row['ruta'];
    $estadoFoto = 'Cambiar foto';
    $mostrarEliminar = true;
} else {
    $imagePath = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
    $estadoFoto = 'Agregar foto de perfil';
    $mostrarEliminar = false;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información Básica de Usuario</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../Assets/CSS/config.css">
    <link rel="stylesheet" href="CSS/custom.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        img{
            object-fit: cover; /* Escala la imagen y corta si es necesario */
            object-position: center; /* Centra la imagen dentro del contenedor */
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="info-container">
            <h2>Información Básica</h2>
            
            <!-- Imagen de perfil -->
            <a href="#" class="info-item d-flex align-items-center" data-toggle="modal" data-target="#profileImageModal">
                <label>Imagen de perfil</label>
                <div class="flex items-center">
                    <img id="profile-image" src="<?php echo $imagePath; ?>" alt="Imagen" class="rounded-circle border" width="50" height="50">
                </div>
                <div class=" arrow-icon ml-auto"><i class='bx bx-chevron-right'></i></div>
            </a>

            <!-- Datos personales -->
            <a href="configNom.php" class="info-item d-flex align-items-center">
                <label>Nombre/s</label>
                <span class="ml-auto"><?php echo $nombres; ?></span>
                <div class="arrow-icon"><i class='bx bx-chevron-right'></i></div>
            </a>

            <a href="configApa.php" class="info-item d-flex align-items-center">
                <label>Apellido paterno</label>
                <span class="ml-auto"><?php echo $apellidop; ?></span>
                <div class="arrow-icon"><i class='bx bx-chevron-right'></i></div>
            </a>

            <a href="configAma.php" class="info-item d-flex align-items-center">
                <label>Apellido materno</label>
                <span class="ml-auto"><?php echo $apellidom; ?></span>
                <div class="arrow-icon"><i class='bx bx-chevron-right'></i></div>
            </a>
        </div>

        <div class="info-container mt-4">
            <h2>Contraseña</h2>
            <a href="#" class="info-item d-flex align-items-center">
                <label>Contraseña</label>
                <span class="ml-auto">**********</span>
                <div class="arrow-icon"><i class='bx bx-chevron-right'></i></div>
            </a>
        </div>

        <div class="info-container user-options mt-4">
            <h2>Opciones de usuario</h2>
            <a href="#" class="btnC mt-2">Cerrar Sesión</a>
            <a href="#" class="leg">Términos y condiciones</a>
            <a href="#" class="leg">Política de privacidad</a>
        </div>
    </div>

    <!-- Modal para Imagen de Perfil -->
    <div class="modal fade" id="profileImageModal" tabindex="-1" aria-labelledby="profileImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-body text-center">
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <h2 class="h5">Imagen de perfil</h2>
                        <p class="text-muted">Añade una foto para que otros puedan reconocerte.</p>
                        <img id="previewImage" src="<?php echo $imagePath; ?>" class="rounded-circle border mt-3" width="150" height="150" style="object-fit: cover; display: block; margin-left: auto; margin-right: auto;" />
                       
                        <div class="form-group mt-3">
                            <label class="btn btn-secondary">
                                <input type="file" name="fileToUpload" id="fileToUpload" class="d-none" accept="image/*">
                                <span id="estado_foto"><?php echo $estadoFoto; ?></span>
                            </label>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary" type="submit" id="guardarBtn" disabled>Guardar</button>
                            <?php if ($mostrarEliminar) { ?>
                                <button type="button" class="btn btn-danger" onclick="eliminarImagen()">Eliminar</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Activar botón "Guardar" solo cuando se seleccione una imagen
            $("#fileToUpload").on("change", function(event) {
                previewImage(event);
                $("#guardarBtn").prop("disabled", false);
            });
        });

        function previewImage(event) {
            var input = event.target;
            if (input.files && input.files.length > 0) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#previewImage").attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function eliminarImagen() {
            if (confirm('¿Estás seguro de que deseas eliminar tu imagen de perfil?')) {
                window.location.href = 'deleteImage.php';
            }
        }
    </script>
</body>

</html>
