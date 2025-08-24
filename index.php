<?php
// 1. Inicia la sesión de forma segura al inicio del script.
session_start();

// 2. Control de acceso estricto. Redirige si el usuario no está autenticado.
// Se ha corregido la variable de sesión para que coincida con la del script de login.php
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nombre'])) {
    header('Location: Templates/login.php');
    exit();
}

// 3. Incluye la conexión segura a la base de datos usando el archivo centralizado.
// Usa la ruta absoluta con __DIR__ para mayor seguridad.
try {
    $connection = require __DIR__ . '/Config/conexion.php';
    if (!$connection) {
        throw new Exception("Error al obtener la conexión PDO.");
    }
} catch (Exception $e) {
    error_log("Error de conexión en index.php: " . $e->getMessage());
    // Muestra un error genérico o redirige a una página de mantenimiento.
    die("Servicio no disponible. Inténtelo más tarde.");
}

// Define la URL base para el sitio.
define('BASE_URL', '/Agora/Modules/Config_User/');

// 4. Utiliza una sentencia preparada de PDO para prevenir la inyección de SQL.
$usuario_id = $_SESSION['id_usuario'];
$sql = "SELECT ruta FROM imagenes WHERE usuario_id = :usuario_id ORDER BY id DESC LIMIT 1";

$stmt = $connection->prepare($sql);
if ($stmt === false) {
    // Si hay un error, lo registramos y mostramos un mensaje genérico.
    error_log("Error al preparar la consulta de imagen: " . print_r($connection->errorInfo(), true));
    $imagePath = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
} else {
    // Usa el método de PDO para ejecutar la consulta con el parámetro.
    $stmt->execute(['usuario_id' => $usuario_id]);
    
    // Obtiene el resultado como un array asociativo.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $imagePath = BASE_URL . htmlspecialchars($row['ruta'], ENT_QUOTES, 'UTF-8');
    } else {
        $imagePath = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png";
    }
}
// Cierra la conexión PDO estableciendo la variable en null.
$connection = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/style.css">
</head>
<body>
    <div id="sidebar">
        <button id="menu-toggle"><i class="fas fa-bars"></i></button>
        <div class="menu-item" data-src="Templates/home.php">
            <i class="fas fa-home"></i><span>Inicio</span>
        </div>
        <div class="menu-item" data-src="Templates/contactos.php">
            <i class="fas fa-user"></i><span>Contactos</span>
        </div>
        <div class="menu-item" data-src="Templates/Gestion_usuarios.html">
            <i class="fa-solid fa-users"></i><span>Gestión de usuarios</span>
        </div>
        <div class="menu-item" data-src="Modules/Inscribir/inscribir.php">
            <i class="fa-solid fa-file"></i><span>Inscribir</span>
        </div>
        <div class="menu-item" data-src="Templates/alumnos.php">
            <i class="fa-solid fa-person"></i><span>Alumnos</span>
        </div>
        <div class="menu-item" data-src="Templates/grupos.php">
            <i class="fa-solid fa-chalkboard-user"></i><span>Grupos</span>
        </div>
        <div class="menu-item" data-src="Templates/caja.php">
            <i class="fa-solid fa-cash-register"></i><span>Caja</span>
        </div>
        <div class="menu-item" data-src="Modules/Config_User/config.php">
            <i class="fas fa-cog"></i><span>Configuraciones</span>
        </div>
    </div>

    <div id="main-container">
        <div id="topbar">
            <button id="mobile-menu-toggle" class="mobile-menu-btn"><i class="fas fa-bars"></i></button>
            <div class="user-icon-container">
                <label for="btn-user"><img src="<?php echo htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8'); ?>" alt="" class="rounded-circle border mt-3 user-icon"></label>
                <input type="checkbox" id="btn-user" style="display: none;">
                <div class="container config" id="user-config">
                    <div class="text-center">
                        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
                        <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    </div>
                    <a href="Modules/Login/logout.php" class="btn btnC">Cerrar Sesión</a>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="mobile-menu">
            <div class="menu-item" data-src="Templates/home.php">
                <i class="fas fa-home"></i><span>Inicio</span>
            </div>
            <div class="menu-item" data-src="Templates/contactos.php">
                <i class="fas fa-user"></i><span>Contactos</span>
            </div>
            <div class="menu-item" data-src="Templates/Gestion_usuarios.html">
                <i class="fa-solid fa-users"></i><span>Gestión de usuarios</span>
            </div>
            <div class="menu-item" data-src="Modules/Inscribir/inscribir.php">
                <i class="fa-solid fa-file"></i><span>Inscribir</span>
            </div>
            <div class="menu-item" data-src="Templates/alumnos.php">
                <i class="fa-solid fa-person"></i><span>Alumnos</span>
            </div>
            <div class="menu-item" data-src="Templates/grupos.php">
                <i class="fa-solid fa-users-rectangle"></i><span>Grupos</span>
            </div>
            <div class="menu-item" data-src="Templates/caja.php">
                <i class="fa-solid fa-cash-register"></i><span>Caja</span>
            </div>
            <div class="menu-item" data-src="Modules/Config_User/config.php">
                <i class="fas fa-cog"></i><span>Configuraciones</span>
            </div>
        </div>

        <iframe id="main-frame" src="Templates/home.php"></iframe>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.menu-item');
            const mainFrame = document.getElementById('main-frame');

            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    const src = this.getAttribute('data-src');
                    if (src) {
                        mainFrame.src = src;
                    }
                });
            });

            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const mobileMenu = document.getElementById('mobile-menu');

            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });

            mobileMenuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
            });

            document.getElementById('btn-user').addEventListener('change', function() {
                const userConfig = document.getElementById('user-config');
                if (this.checked) {
                    userConfig.style.display = 'block';
                } else {
                    userConfig.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>