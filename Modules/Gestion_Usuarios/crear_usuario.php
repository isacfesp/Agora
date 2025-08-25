<?php

session_start();
$pdo = require_once '../../Config/conexion.php';

// Generar token CSRF si no existe en la sesión.
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error_message = ''; // Variable para almacenar mensajes de error y mostrarlos.

// Procesar la solicitud POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. VERIFICACIÓN DEL TOKEN CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error_message = "Error de validación de seguridad. Por favor, envíe el formulario de nuevo.";
    } else {
        // 2. SANITIZACIÓN Y VALIDACIÓN DE DATOS.
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $password = $_POST["password"];
        $nombre = htmlspecialchars(trim($_POST["nombre"]), ENT_QUOTES, 'UTF-8');
        $apaterno = htmlspecialchars(trim($_POST["apaterno"]), ENT_QUOTES, 'UTF-8');
        $amaterno = htmlspecialchars(trim($_POST["amaterno"]), ENT_QUOTES, 'UTF-8');
        $tipo_usuario = filter_var($_POST["tipo_usuario"], FILTER_VALIDATE_INT);
        $estado = 1; // Inactivo por defecto

        // Validaciones básicas
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password) || empty($nombre) || empty($apaterno) || $tipo_usuario === false) {
            $error_message = "Error: Todos los campos obligatorios deben ser completados.";
        } elseif (strlen($password) < 8) {
            $error_message = "Error: La contraseña debe tener al menos 8 caracteres.";
        } else {
            // 3. PASO CLAVE: VERIFICACIÓN SÍNCRONA DE EMAIL EXISTENTE
            try {
                $sql_check = "SELECT 1 FROM usuario WHERE email = :email LIMIT 1";
                $stmt_check = $pdo->prepare($sql_check);
                $stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt_check->execute();

                if ($stmt_check->fetchColumn()) {
                    // El email ya existe.
                    $error_message = "Error: El correo electrónico ya está registrado en el sistema.";
                } else {
                    // Si el email no existe y no hay otros errores, procedemos a la creación.
                    
                    // 4. HASHING SEGURO DE LA CONTRASEÑA
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // 5. GENERACIÓN DE CÓDIGOS
                    $codigoVerificacion = bin2hex(random_bytes(16));
                    $codigoRecuperacion = null;

                    // 6. INSERCIÓN EN LA BASE DE DATOS
                    $sql_insert = "INSERT INTO usuario (email, password, nombre, apaterno, amaterno, estado, tipo_usuario, fecha_creacion, codigoVerificacion, codigoRecuperacion) 
                                   VALUES (:email, :password, :nombre, :apaterno, :amaterno, :estado, :tipo_usuario, NOW(), :codigoVerificacion, :codigoRecuperacion)";
                    
                    $stmt_insert = $pdo->prepare($sql_insert);
                    $stmt_insert->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt_insert->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                    $stmt_insert->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                    $stmt_insert->bindParam(':apaterno', $apaterno, PDO::PARAM_STR);
                    $stmt_insert->bindParam(':amaterno', $amaterno, PDO::PARAM_STR);
                    $stmt_insert->bindParam(':estado', $estado, PDO::PARAM_INT);
                    $stmt_insert->bindParam(':tipo_usuario', $tipo_usuario, PDO::PARAM_INT);
                    $stmt_insert->bindParam(':codigoVerificacion', $codigoVerificacion, PDO::PARAM_STR);
                    $stmt_insert->bindParam(':codigoRecuperacion', $codigoRecuperacion, PDO::PARAM_NULL);
                    
                    if ($stmt_insert->execute()) {
                        header("Location: ../../Templates/Gestion_usuarios.html?usuario_creado=1");
                        exit();
                    } else {
                        $error_message = "No se pudo crear el usuario. Error inesperado.";
                    }
                }
            } catch (PDOException $e) {
                error_log("Error de PDO al crear usuario: " . $e->getMessage());
                $error_message = "Hubo un error con la base de datos. Por favor, inténtelo de nuevo más tarde.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario (Modo Robusto)</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/CSS/crearContacto.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container form-container">
        <div class="form-box">
            <a href="../../Templates/Gestion_usuarios.html" class="btn-back">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="crearUsuarioForm">
                
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre" required name="nombre">
                </div>
                <div class="form-group">
                    <label for="apaterno">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="apaterno" placeholder="Ingresa el apellido paterno" required name="apaterno">
                </div>
                <div class="form-group">
                    <label for="amaterno">Apellido Materno (opcional):</label>
                    <input type="text" class="form-control" id="amaterno" placeholder="Ingresa el apellido materno" name="amaterno">
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" id="email" placeholder="Ingresa el correo" required name="email">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" placeholder="Mínimo 8 caracteres" required name="password" minlength="8">
                </div>
                
                <div class="form-group">
                    <label for="tipo_usuario">Tipo de Usuario:</label>
                    <select class="form-control" id="tipo_usuario" required name="tipo_usuario">
                        <option value="1" selected>Administrador</option>
                        <option value="2">Permiso B</option>
                        <option value="3">Permiso C</option>
                        <option value="4">Permiso D</option>
                    </select>
                </div>
                <div class="form-group">
                    <label id="permisos">Permisos: A</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Guardar Usuario</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('tipo_usuario').addEventListener('change', function() {
            const mensaje = document.getElementById('permisos');
            switch (this.value) {
                case '1': mensaje.textContent = 'Permisos: A'; break;
                case '2': mensaje.textContent = 'Permisos: B'; break;
                case '3': mensaje.textContent = 'Permisos: C'; break;
                case '4': mensaje.textContent = 'Permisos: D'; break;
                default: mensaje.textContent = '';
            }
        });
    });
    </script>
</body>
</html>