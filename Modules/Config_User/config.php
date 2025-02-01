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
    $mostrarEliminar = true;
} else {
    $imagePath = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
    $mostrarEliminar = false;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../Assets/CSS/config.css">
</head>

<body>
    <div class="config-container">
        <!-- Sección de Información Básica -->
        <div class="section-header">
            <h2><i class='bx bx-user'></i>Información Básica</h2>
        </div>
        <div class="section-body">
            <!-- Foto de Perfil -->
            <div class="config-item" data-bs-toggle="modal" data-bs-target="#profileModal">
                <div class="item-label">
                    <i class='bx bx-camera'></i>
                    <span>Foto de perfil</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <img src="<?php echo $imagePath; ?>" 
                         class="profile-picture"
                         alt="Foto de perfil"
                         onerror="this.src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png'">
                    <div class="btn-add-photo">
                        <i class='bx bx-plus'></i>
                    </div>
                </div>
            </div>

            <!-- Nombre -->
            <div class="config-item">
                <div class="item-label">
                    <i class='bx bx-id-card'></i>
                    <span>Nombre</span>
                </div>
                <span class="item-value"><?php echo $nombres; ?></span>
                <i class='bx bx-chevron-right'></i>
            </div>

            <!-- Apellido Paterno -->
            <div class="config-item">
                <div class="item-label">
                    <i class='bx bx-user-pin'></i>
                    <span>Apellido Paterno</span>
                </div>
                <span class="item-value"><?php echo $apellidop; ?></span>
                <i class='bx bx-chevron-right'></i>
            </div>

            <!-- Apellido Materno -->
            <div class="config-item">
                <div class="item-label">
                    <i class='bx bx-user-voice'></i>
                    <span>Apellido Materno</span>
                </div>
                <span class="item-value"><?php echo $apellidom; ?></span>
                <i class='bx bx-chevron-right'></i>
            </div>
        </div>

        <!-- Sección de Contraseña -->
        <div class="section-header">
            <h2><i class='bx bx-lock-alt'></i>Seguridad</h2>
        </div>
        <div class="section-body">
            <div class="config-item">
                <div class="item-label">
                    <i class='bx bx-key'></i>
                    <span>Contraseña</span>
                </div>
                <span class="item-value">**********</span>
                <i class='bx bx-chevron-right'></i>
            </div>
        </div>

        <!-- Sección de Opciones -->
        <div class="section-body">
            <button class="btn-logout">
                <i class='bx bx-log-out'></i>
                Cerrar Sesión
            </button>
            <div class="legal-links">
                <a href="#">Términos y Condiciones</a>
                <a href="#">Política de Privacidad</a>
            </div>
        </div>
    </div>

    <!-- Modal de Foto de Perfil Mejorado -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2">
                        <i class='bx bx-camera'></i>
                        Foto de perfil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="profileForm" action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="profile-preview-container">
                                <img id="modalProfileImage" src="<?php echo $imagePath; ?>" 
                                     class="profile-preview-image"
                                     alt="Foto de perfil"
                                     onerror="this.src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png'">
                                <div class="edit-overlay" onclick="document.getElementById('fileInput').click()">
                                    <i class='bx bx-edit'></i>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <label class="btn btn-outline-primary w-100" for="fileInput">
                                <i class='bx bx-upload'></i>
                                Subir nueva foto
                            </label>
                            <input type="file" id="fileInput" name="fileToUpload" class="d-none" accept="image/*" onchange="previewImage(event)">
                            
                            <?php if ($mostrarEliminar) { ?>
                            <button type="button" class="btn btn-outline-danger w-100" onclick="eliminarImagen()">
                                <i class='bx bx-trash'></i>
                                Eliminar foto actual
                            </button>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="saveButton" disabled>
                            <i class='bx bx-save'></i>
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('modalProfileImage');
            const saveButton = document.getElementById('saveButton');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    saveButton.disabled = false;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function eliminarImagen() {
            if (confirm('¿Estás seguro de que deseas eliminar tu foto de perfil?')) {
                window.location.href = 'deleteImage.php';
            }
        }

        document.getElementById('profileForm').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('fileInput');
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Por favor, selecciona una imagen antes de guardar.');
            }
        });
    </script>
</body>

</html>