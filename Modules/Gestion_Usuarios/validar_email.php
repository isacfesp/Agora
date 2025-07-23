<?php
header('Content-Type: application/json');
include_once('../../Config/conexion.php');
require '../../Config/PHPMailer/src/Exception.php';
require '../../Config/PHPMailer/src/PHPMailer.php';
require '../../Config/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['correo_usuario']) || empty($data['correo_usuario'])) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Correo no proporcionado'
    ]);
    exit;
}

$correo = $data['correo_usuario'];

// Verifica si el correo existe
$sql = "SELECT id_usuario FROM usuario WHERE email = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    echo json_encode([
        'success' => false,
        'mensaje' => 'Correo no encontrado'
    ]);
    exit;
}

// Genera un token único
$token = bin2hex(random_bytes(32));

// Guarda el token en la base de datos (puedes crear un campo 'token_validacion' en la tabla usuario)
$updateSql = "UPDATE usuario SET token_validacion = ? WHERE email = ?";
$updateStmt = $connection->prepare($updateSql);
$updateStmt->bind_param("ss", $token, $correo);
$updateStmt->execute();

// Crea el enlace de validación
$enlace = "http://localhost/Agora/Templates/confirmar_email.php?token=$token";

// Envía el correo
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = "correo@gmail.com"; // Cambia esto por tu correo
    // Asegúrate de que la contraseña sea correcta y que el acceso a aplicaciones menos seguras esté habilitado en tu cuenta de Gmail.
    // Si usas autenticación de dos factores, necesitarás una contraseña de aplicación.
    $mail->Password = "tu_contraseña"; // Cambia esto por tu contraseña
    // Si usas autenticación de dos factores, necesitarás una contraseña de aplicación.
    // Lo antes mencionado aplica si estás usando Gmail como dominio.
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->setFrom('Nombre del remitente', 'AGORA');
    $mail->addAddress($correo);
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    $mail->Subject = 'Valida tu correo electrónico';
    $mail->Body = '
    <div style="font-family: \'Inter\', Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="cid:logo" alt="Logo AGORA" style="max-width: 150px;">
        </div>
        <div style="background: #ffffff; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <h2 style="color: #2C3E50; text-align: center; margin-bottom: 20px;">Validación de Correo</h2>
            <p style="color: #34495E; font-size: 16px; line-height: 1.6;">Hola,</p>
            <p style="color: #34495E; font-size: 16px; line-height: 1.6;">Haz clic en el siguiente botón para validar tu correo electrónico:</p>
            <div style="text-align: center; margin: 25px 0;">
                <a href="'.$enlace.'" style="background: #BBCD5D; color: #2C3E2F; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 18px;">Validar mi correo</a>
            </div>
            <p style="color: #34495E; font-size: 14px;">Si no solicitaste este registro, puedes ignorar este correo.</p>
            <div style="border-top: 1px solid #E5E7E9; margin-top: 30px; padding-top: 20px;">
                <p style="color: #7F8C8D; font-size: 12px; text-align: center;">Este es un correo automático, por favor no respondas a este mensaje.</p>
            </div>
        </div>
    </div>';
    $mail->AltBody = "Valida tu correo en este enlace: $enlace";

    $mail->addEmbeddedImage('../../Assets/Images/LogoTrans.png', 'logo');

    $mail->send();

    echo json_encode([
        'success' => true,
        'mensaje' => 'Correo de validación enviado correctamente'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => "Error al enviar el correo: {$mail->ErrorInfo}"
    ]);
}

$stmt->close();
$connection->close();
?>