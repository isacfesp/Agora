<?php
// Lógica PHP para manejar el mensaje de error
session_start();
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso CRM | Automatización IA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Assets/CSS/login.css">
</head>

<body>
    <canvas id="particle-canvas" class="fixed inset-0 w-full h-full z-0"></canvas>

    <div class="auth-container">
        <div class="mb-10">
            <div class="text-6xl mb-4" style="color: var(--secondary-color);">
                <i class="fas fa-microchip"></i>
            </div>
            <h1>Bienvenido</h1>
            <p>Accede a tu panel de automatización.</p>
        </div>

        <?php if (!empty($errorMessage)) : ?>
            <div id="error-message" class="bg-red-200 text-red-800 p-3 rounded-lg mb-6">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="../Modules/Login/login.php">
            <div class="input-group">
                <span class="input-icon">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" class="form-input" id="email" name="email" placeholder="Correo electrónico" required>
            </div>

            <div class="input-group">
                <span class="input-icon">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" class="form-input" id="password" name="password" placeholder="Contraseña" required>
                <span class="password-toggle" onclick="togglePassword()">
                    <i id="password-toggle-icon" class="fas fa-eye"></i>
                </span>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt mr-2"></i>Ingresar
            </button>

            <div class="mt-6">
                <a href="reset_password.html" class="text-link">
                    ¿Olvidó su contraseña?
                </a>
            </div>
        </form>
    </div>

    <script src="../Assets/JS/login.js"></script>
</body>
</html>