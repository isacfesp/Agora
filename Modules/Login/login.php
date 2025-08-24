<?php

// login.php

// Iniciar la sesión de forma segura al inicio del script.
session_start();

// Validar el método de la petición. Solo se debe procesar POST.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die("Método no permitido.");
}

// 1. Incluir y obtener la conexión PDO.
// Corrección: Asignar el resultado de 'require' a la variable $pdo.
try {
    $pdo = require __DIR__ . '/../../Config/conexion.php';
    // Se añade una verificación adicional.
    if (!$pdo) {
        throw new Exception("Error al obtener la conexión PDO.");
    }
} catch (Exception $e) {
    // Si la conexión falla, se registra y se muestra un error genérico.
    error_log("Error al cargar la conexión en login.php: " . $e->getMessage());
    $_SESSION['error'] = "Ha ocurrido un error inesperado. Inténtalo de nuevo más tarde.";
    header("Location: ../../Templates/login.php");
    exit();
}

// 2. Definir un mensaje de error genérico.
$genericError = "Credenciales incorrectas.";

// 3. Sanear y validar las entradas.
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = trim($_POST['password'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = $genericError;
    header("Location: ../../Templates/login.php");
    exit();
}

// 4. Consulta la base de datos de forma segura con PDO.
$sql = "SELECT id_usuario, password, tipo_usuario, nombre, email FROM usuario WHERE email = :email";
$stmt = $pdo->prepare($sql);

if ($stmt === false) {
    error_log("Error al preparar la consulta de login: " . print_r($pdo->errorInfo(), true));
    $_SESSION['error'] = "Ha ocurrido un error inesperado.";
    header("Location: ../../Templates/login.php");
    exit();
}

$stmt->execute(['email' => $email]);
$user = $stmt->fetch();

// 5. Verificar la contraseña de forma segura con password_verify.
if ($user && password_verify($password, $user['password'])) {
    
    // Regenerar el ID de sesión para prevenir ataques de fijación de sesión.
    session_regenerate_id(true);

    $_SESSION['id_usuario'] = $user['id_usuario']; // Cambiado de 'user_id' a 'id_usuario'
    $_SESSION['user_role'] = $user['tipo_usuario'];
    $_SESSION['nombre'] = $user['nombre'] . ' ' . $user['apaterno'] . ' ' . $user['amaterno']; // Cambiado de 'nombre_completo' a 'nombre'
    $_SESSION['email'] = $user['email'];
    // Redireccionar a la página de inicio.
    header("Location: ../../index.php");
    exit();

} else {
    // Mensaje genérico para credenciales incorrectas.
    $_SESSION['error'] = $genericError;
    header("Location: ../../Templates/login.php");
    exit();
}