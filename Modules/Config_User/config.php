<?php
session_start();

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
} else {
    $imagePath = "https://via.placeholder.com/50";
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
        .user-options {
            margin-top: 30px;
        }

        .btnC {
            text-decoration: none;
        }

        .btnC:hover {
            text-decoration: none;
        }

        .user-options .leg {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="info-container">
            <h2>Información Básica</h2>
            <a href="configImage.php" class="info-item d-flex align-items-center">
                <label>Imagen de perfil</label>
                <div class="flex items-center">
                    <img src="<?php echo $imagePath; ?>" alt="Imagen" class="rounded-circle" width="50" height="50">
                </div>
                <div class="arrow-icon ml-auto"><i class='bx bx-chevron-right'></i></div>
            </a>

            <a href="config1.php" class="info-item d-flex align-items-center">
                <label>Nombre</label>
                <span class="ml-auto"><?php echo $_SESSION['nombre']; ?></span>
                <div class="arrow-icon"><i class='bx bx-chevron-right'></i></div>
            </a>

            <a href="#" class="info-item d-flex align-items-center">
                <label>Apellido paterno</label>
                <span class="ml-auto"><?php echo $_SESSION['apaterno']; ?></span>
                <div class="arrow-icon"><i class='bx bx-chevron-right'></i></div>
            </a>

            <a href="#" class="info-item d-flex align-items-center">
                <label>Apellido materno</label>
                <span class="ml-auto"><?php echo $_SESSION['amaterno']; ?></span>
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
            <br>
            <br>
            <a href="#" class="leg d-block mt-2">Términos y condiciones</a>
            <a href="#" class="leg d-block mt-2">Política de privacidad</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
