<?php
// Configura el encabezado para la respuesta JSON al inicio
header('Content-Type: application/json');

// 1. Carga de dependencias y configuración segura
// Incluye la conexión y el cargador de variables de entorno
$connection = require_once('../../Config/conexion.php');
require_once '../../Config/PHPMailer/src/Exception.php';
require_once '../../Config/PHPMailer/src/PHPMailer.php';
require_once '../../Config/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carga las variables del archivo .env para las credenciales de SMTP
$smtp_username = $_ENV['SMTP_USERNAME'] ?? null;
$smtp_password = $_ENV['SMTP_PASSWORD'] ?? null;
$smtp_host = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
$smtp_port = $_ENV['SMTP_PORT'] ?? 587;

// 2. Manejo y validación de la entrada
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['correo_usuario']) || empty($data['correo_usuario'])) {
    // La respuesta no debe revelar información. Se comporta como si hubiera enviado el correo.
    echo json_encode(['success' => true, 'mensaje' => 'El proceso de validación ha sido iniciado. Por favor, revisa tu correo.']);
    exit;
}
$correo = filter_var($data['correo_usuario'], FILTER_SANITIZE_EMAIL);
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    // Si el correo es inválido, responde de la misma manera genérica.
    echo json_encode(['success' => true, 'mensaje' => 'El proceso de validación ha sido iniciado. Por favor, revisa tu correo.']);
    exit;
}

// 3. Consulta de forma segura y evita la enumeración de usuarios
$sql = "SELECT id_usuario FROM usuario WHERE email = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    // Si el correo no existe, devuelve el mismo mensaje de éxito.
    // Esto previene que un atacante sepa si un correo está registrado o no.
    echo json_encode(['success' => true, 'mensaje' => 'El proceso de validación ha sido iniciado. Por favor, revisa tu correo.']);
    exit;
}

$row = $result->fetch_assoc();
$id_usuario = $row['id_usuario'];

// 4. Generación segura del token con fecha de expiración
$token = bin2hex(random_bytes(32));
$expiracion = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token válido por 1 hora

// 5. Actualización segura de la base de datos
$updateSql = "UPDATE usuario SET token_validacion = ?, token_expiracion = ? WHERE id_usuario = ?";
$updateStmt = $connection->prepare($updateSql);

if ($updateStmt === false) {
    error_log("Error al preparar la consulta de actualización: " . $connection->error);
    echo json_encode(['success' => false, 'error' => 'Error interno del servidor.']);
    exit;
}

$updateStmt->bind_param("ssi", $token, $expiracion, $id_usuario);
$updateStmt->execute();
$updateStmt->close();

// Crea el enlace de validación
$enlace = "http://localhost/Agora/Templates/confirmar_email.php?token=$token";

// 6. Configuración de PHPMailer con credenciales seguras
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = $smtp_host;
    $mail->Port = $smtp_port;
    $mail->SMTPAuth = true;
    $mail->Username = $smtp_username;
    $mail->Password = $smtp_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->setFrom('no-reply@agora.com', 'AGORA');
    $mail->addAddress($correo);
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    $mail->Subject = 'Valida tu correo electrónico';
    $mail->Body = '
        <div style="font-family: \'Inter\', Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
            ... (cuerpo del correo) ...
            <a href="'.$enlace.'" style="background: #BBCD5D; color: #2C3E2F; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 18px;">Validar mi correo</a>
            ... (resto del cuerpo) ...
        </div>';
    $mail->AltBody = "Valida tu correo en este enlace: $enlace";
    $mail->addEmbeddedImage('../../Assets/Images/LogoTrans.png', 'logo');
    $mail->send();

    // 7. Respuesta final segura y consistente
    echo json_encode([
        'success' => true,
        'mensaje' => 'Correo de validación enviado correctamente'
    ]);
} catch (Exception $e) {
    error_log("Error al enviar el correo a $correo: {$mail->ErrorInfo}");
    // Devuelve un mensaje genérico para no revelar detalles del error
    echo json_encode([
        'success' => false,
        'error' => "Hubo un problema al enviar el correo. Inténtalo de nuevo."
    ]);
} finally {
    // Asegúrate de cerrar la conexión de manera segura al final
    if (isset($connection)) {
        $connection->close();
    }
}