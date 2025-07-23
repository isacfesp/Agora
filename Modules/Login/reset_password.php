<?php
header('Content-Type: application/json'); 
include_once('../../Config/conexion.php');
require '../../Config/PHPMailer/src/Exception.php';
require '../../Config/PHPMailer/src/PHPMailer.php';
require '../../Config/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['action']) && $data['action'] === 'verify_code') {
    $sql = "SELECT id_usuario FROM usuario WHERE email = ? AND codigoRecuperacion = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $data['correo_usuario'], $data['codigo']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'success' => true,
            'mensaje' => 'Código verificado correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'mensaje' => 'Código incorrecto o expirado'
        ]);
    }

    $stmt->close();
    $connection->close();
    return;
}

if (isset($data['action']) && $data['action'] === 'change_password') {
    $email = $data['correo_usuario'];
    $newPassword = $data['nueva_contraseña'];

    if (empty($email) || empty($newPassword)) {
        echo json_encode(['success' => false, 'mensaje' => 'Correo o contraseña no pueden estar vacíos']);
        exit();
    }

    $stmt = $connection->prepare("UPDATE usuario SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $newPassword, $email);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'mensaje' => 'Contraseña actualizada correctamente']);
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar la contraseña']);
    }

    $stmt->close();
    $connection->close();
    exit();
}

$codigo = random_int(100000, 999999); 

$mail = new PHPMailer(true);

try {
    $sql = "SELECT id_usuario FROM usuario WHERE email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $data['correo_usuario']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows <= 0){
        echo json_encode([
            'success' => false,
            'mensaje' => 'Correo no encontrado'
        ]);
        return;
    }

    $updateSql = "UPDATE usuario SET codigoRecuperacion = ? WHERE email = ?";
    $updateStmt = $connection->prepare($updateSql);
    $updateStmt->bind_param("is", $codigo, $data['correo_usuario']);
    $updateStmt->execute();

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
    $mail->addAddress($data['correo_usuario']);
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    $mail->Subject = 'Código de recuperación de contraseña';
    $mail->Body = '
    <div style="font-family: \'Inter\', Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="cid:logo" alt="Logo AGORA" style="max-width: 150px;">
        </div>
        <div style="background: #ffffff; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <h2 style="color: #2C3E50; text-align: center; margin-bottom: 20px;">Recuperación de Contraseña</h2>
            <p style="color: #34495E; font-size: 16px; line-height: 1.6;">Hola,</p>
            <p style="color: #34495E; font-size: 16px; line-height: 1.6;">Has solicitado restablecer tu contraseña. Utiliza el siguiente código de verificación:</p>
            <div style="background: #F7F9FA; border-radius: 8px; padding: 20px; text-align: center; margin: 25px 0;">
                <span style="font-family: monospace; font-size: 32px; color: #000; letter-spacing: 4px; font-weight: bold;">'.$codigo.'</span>
            </div>
            <p style="color: #34495E; font-size: 14px;">Si no solicitaste este código, puedes ignorar este correo.</p>
            <div style="border-top: 1px solid #E5E7E9; margin-top: 30px; padding-top: 20px;">
                <p style="color: #7F8C8D; font-size: 12px; text-align: center;">Este es un correo automático, por favor no respondas a este mensaje.</p>
            </div>
        </div>
    </div>';
    $mail->AltBody = "Tu código de recuperación es: $codigo";

    $mail->addEmbeddedImage('../../Assets/Images/LogoTrans.png', 'logo');

    $mail->send();

    echo json_encode([
        'success' => true,
        'mensaje' => 'Código enviado correctamente'
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
