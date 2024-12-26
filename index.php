<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: Templates/login.html');
    exit();
}
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

    <!-- Menú lateral -->
    <div id="sidebar">
        <button id="menu-toggle"><i class="fas fa-bars"></i></button>
        <div class="menu-item" onclick="document.getElementById('main-frame').src='Templates/home.html'">
            <i class="fas fa-home"></i><span>Inicio</span>
        </div>
        <div class="menu-item" onclick="document.getElementById('main-frame').src='Templates/contactos.html'">
            <i class="fas fa-user"></i><span>Contactos</span>
        </div>
        <div class="menu-item" onclick="document.getElementById('main-frame').src='Templates/Gestion_usuarios.html'">
            <i class="fas fa-chart-line"></i><span>Gestión de usuarios</span>
        </div>
        <div class="menu-item" onclick="document.getElementById('main-frame').src='Modules/Config_User/config.php'">
            <i class="fas fa-cog"></i><span>Configuraciones</span>
        </div>
    </div>

    <!-- Contenido principal con barra superior e iframe -->
    <div id="main-container">
        <!-- Barra superior -->
        <div id="topbar">
            <div>
                <label for="btn-user"><i class="fas fa-user-circle icon"></i></label>
                <input type="checkbox" id="btn-user" style="display: none;">
                <div class="config">
                    <center>

                        <h2>bienvenido, <?php echo $_SESSION['nombre']; ?> </h2>

                        <?php echo $_SESSION['email']; ?>
                    </center>
                    <a href="logout.php" class="btnC">Cerrar Sesión</a>
                </div>
            </div>
        </div>

        <!-- Frame principal para mostrar el contenido -->
        <iframe id="main-frame" src="Templates/home.html"></iframe>
    </div>



    <script>
        document.getElementById("menu-toggle").addEventListener("click", function() {
            document.getElementById("sidebar").classList.toggle("collapsed");
        });
    </script>
</body>


</html>