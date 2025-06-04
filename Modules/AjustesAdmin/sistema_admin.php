<?php
header('Content-Type: application/json');
ob_start();

// Al inicio del archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Determinar si es FormData o JSON
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'multipart/form-data') !== false) {
            // Es FormData
            $data = $_POST;
            // Verificar tipo de operación
            if (!isset($data['tipo'])) {
                throw new Exception('Tipo de operación no especificado');
            }
        } else {
            // Es JSON
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            if (!isset($data['tipo'])) {
                throw new Exception('Tipo de operación no especificado');
            }
        }

        session_start();
        require_once dirname(__FILE__) . '/../../Config/conexion.php';
        
        // Verificar sesión
        if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 1) {
            throw new Exception('Acceso no autorizado');
        }

        // Crear tabla si no existe
        $connection->query("
            CREATE TABLE IF NOT EXISTS backups (
                id_backup INT PRIMARY KEY AUTO_INCREMENT,
                nombre_archivo VARCHAR(255) NOT NULL,
                fecha DATETIME NOT NULL,
                tamanho INT NOT NULL,
                id_usuario INT NOT NULL,
                FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        switch ($data['tipo']) {
            case 'crear_backup':
                // Validar contraseña del administrador
                if (!isset($data['password'])) {
                    throw new Exception('Contraseña no proporcionada');
                }

                // Verificar contraseña
                $stmt = $connection->prepare("SELECT password FROM usuario WHERE id_usuario = ? AND tipo_usuario = 1");
                $stmt->bind_param('i', $_SESSION['id_usuario']);
                $stmt->execute();
                $result = $stmt->get_result();
                $admin = $result->fetch_assoc();

                if (!$admin || $admin['password'] !== $data['password']) {
                    throw new Exception('Contraseña incorrecta');
                }
                
                // Crear nombre del archivo con fecha
                $fecha = date('Y-m-d_H-i-s');
                $nombre_archivo = "backup_{$fecha}.sql";
                $backup_path = dirname(__FILE__) . '/../../Backups/' . $nombre_archivo;

                // Construir comando mysqldump
                $mysqldump_path = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
                $command = sprintf(
                    '"%s" --user="%s" --password="%s" --host="%s" %s > "%s" 2>&1',
                    $mysqldump_path,
                    $user,
                    $pwd,
                    $host,
                    $DB,
                    $backup_path
                );
                
                exec($command, $output, $return_var);
                
                if ($return_var !== 0) {
                    throw new Exception('Error al crear backup: ' . implode("\n", $output));
                }

                // Registrar backup en la base de datos
                $tamanho = filesize($backup_path);
                $stmt = $connection->prepare("
                    INSERT INTO backups (nombre_archivo, fecha, tamanho, id_usuario) 
                    VALUES (?, NOW(), ?, ?)
                ");
                
                $stmt->bind_param('sii', $nombre_archivo, $tamanho, $_SESSION['id_usuario']);
                $stmt->execute();

                echo json_encode([
                    'success' => true,
                    'message' => 'Backup creado correctamente',
                    'backupPath' => $backup_path,
                    'details' => [
                        'fecha' => $fecha,
                        'tamanho' => number_format($tamanho / 1024, 2) . ' KB'
                    ]
                ]);
                break;

            case 'obtener_historial':
                $sql = "SELECT b.*, u.nombre as usuario 
                       FROM backups b 
                       JOIN usuario u ON b.id_usuario = u.id_usuario 
                       ORDER BY b.fecha DESC";
                
                $result = $connection->query($sql);
                if (!$result) {
                    throw new Exception('Error al obtener el historial');
                }

                $historial = [];
                while ($row = $result->fetch_assoc()) {
                    $historial[] = [
                        'id' => $row['id_backup'],
                        'archivo' => $row['nombre_archivo'],
                        'fecha' => $row['fecha'],
                        'tamanho' => (int)$row['tamanho'],
                        'usuario' => $row['usuario']
                    ];
                }

                echo json_encode([
                    'success' => true,
                    'data' => $historial
                ]);
                break;

            case 'descargar_backup':
                if (!isset($data['archivo'])) {
                    throw new Exception('Nombre de archivo no proporcionado');
                }

                // Sanitize filename - updated regex pattern
                $filename = basename($data['archivo']);
                if (!preg_match('/^backup_[\d\-_]+\.sql$/', $filename)) {
                    throw new Exception('Nombre de archivo inválido: ' . $filename);
                }

                $backup_path = dirname(__FILE__) . '/../../Backups/' . $filename;

                // Verify file exists and is readable
                if (!file_exists($backup_path) || !is_readable($backup_path)) {
                    throw new Exception('Archivo no encontrado o sin acceso');
                }

                // Verify user has permission
                $stmt = $connection->prepare("
                    SELECT id_backup 
                    FROM backups 
                    WHERE nombre_archivo = ? 
                    AND id_usuario = ?
                ");
                $stmt->bind_param('si', $filename, $_SESSION['id_usuario']);
                $stmt->execute();
                
                if (!$stmt->get_result()->fetch_assoc()) {
                    throw new Exception('No tiene permiso para descargar este archivo');
                }

                echo json_encode([
                    'success' => true,
                    'data' => [
                        'archivo' => $filename,
                        'ruta' => '../Backups/' . $filename
                    ]
                ]);
                break;

            case 'eliminar_backup':
                if (!isset($data['id'])) {
                    throw new Exception('ID de backup no proporcionado');
                }

                // Verify and get backup info
                $stmt = $connection->prepare("
                    SELECT nombre_archivo 
                    FROM backups 
                    WHERE id_backup = ? 
                    AND id_usuario = ?
                ");
                $stmt->bind_param('ii', $data['id'], $_SESSION['id_usuario']);
                $stmt->execute();
                $result = $stmt->get_result();
                $backup = $result->fetch_assoc();

                if (!$backup) {
                    throw new Exception('Backup no encontrado o sin permisos');
                }

                // Delete physical file
                $backup_path = dirname(__FILE__) . '/../../Backups/' . $backup['nombre_archivo'];
                if (file_exists($backup_path) && !unlink($backup_path)) {
                    throw new Exception('No se pudo eliminar el archivo');
                }

                // Delete database record
                $stmt = $connection->prepare("DELETE FROM backups WHERE id_backup = ?");
                $stmt->bind_param('i', $data['id']);
                if (!$stmt->execute()) {
                    throw new Exception('Error al eliminar el registro');
                }

                echo json_encode([
                    'success' => true,
                    'message' => 'Backup eliminado correctamente'
                ]);
                break;

            case 'restaurar_backup':
                // Verificar contraseña del administrador
                if (!isset($data['password'])) {
                    throw new Exception('Contraseña no proporcionada');
                }

                $stmt = $connection->prepare("SELECT password FROM usuario WHERE id_usuario = ? AND tipo_usuario = 1");
                if (!$stmt) {
                    throw new Exception('Error al preparar la consulta');
                }

                $stmt->bind_param('i', $_SESSION['id_usuario']);
                $stmt->execute();
                $result = $stmt->get_result();
                $admin = $result->fetch_assoc();

                if (!$admin || $admin['password'] !== $data['password']) {
                    throw new Exception('Contraseña incorrecta');
                }

                // Verificar archivo subido
                if (!isset($_FILES['backup_file'])) {
                    throw new Exception('No se proporcionó archivo de backup');
                }

                $backup_file = $_FILES['backup_file'];
                
                // Validar archivo
                if ($backup_file['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception('Error al subir el archivo');
                }

                if ($backup_file['type'] !== 'application/sql' && !preg_match('/\.sql$/', $backup_file['name'])) {
                    throw new Exception('El archivo debe ser un backup SQL válido');
                }

                // Crear backup de seguridad antes de restaurar
                $safety_backup = 'safety_' . date('Y-m-d_H-i-s') . '.sql';
                $safety_path = dirname(__FILE__) . '/../../Backups/' . $safety_backup;

                $mysqldump_path = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
                $command = sprintf(
                    '"%s" --user="%s" --password="%s" --host="%s" %s > "%s" 2>&1',
                    $mysqldump_path,
                    $user,
                    $pwd,
                    $host,
                    $DB,
                    $safety_path
                );

                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    throw new Exception('Error al crear backup de seguridad');
                }

                // Restaurar desde el archivo subido
                $mysql_path = 'C:\\xampp\\mysql\\bin\\mysql.exe';
                $restore_command = sprintf(
                    '"%s" --user="%s" --password="%s" --host="%s" %s < "%s" 2>&1',
                    $mysql_path,
                    $user,
                    $pwd,
                    $host,
                    $DB,
                    $backup_file['tmp_name']
                );

                exec($restore_command, $output, $return_var);
                if ($return_var !== 0) {
                    throw new Exception('Error al restaurar: ' . implode("\n", $output));
                }

                echo json_encode([
                    'success' => true,
                    'message' => 'Sistema restaurado correctamente'
                ]);
                break;

            case 'restablecer_sistema':
                // Validar confirmación
                if (!isset($data['confirmacion']) || $data['confirmacion'] !== 'RESTABLECER') {
                    throw new Exception('Confirmación incorrecta');
                }

                // Validar contraseña
                if (!isset($data['password'])) {
                    throw new Exception('Contraseña no proporcionada');
                }

                // Verificar contraseña del administrador
                $stmt = $connection->prepare("SELECT password FROM usuario WHERE id_usuario = ? AND tipo_usuario = 1");
                $stmt->bind_param('i', $_SESSION['id_usuario']);
                $stmt->execute();
                $result = $stmt->get_result();
                $admin = $result->fetch_assoc();

                if (!$admin || $admin['password'] !== $data['password']) {
                    throw new Exception('Contraseña incorrecta');
                }

                // Crear backup de seguridad
                $safety_backup = 'safety_before_reset_' . date('Y-m-d_H-i-s') . '.sql';
                $safety_path = dirname(__FILE__) . '/../../Backups/' . $safety_backup;
                
                $mysqldump_path = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
                $command = sprintf(
                    '"%s" --user="%s" --password="%s" --host="%s" %s > "%s" 2>&1',
                    $mysqldump_path,
                    $user,
                    $pwd,
                    $host,
                    $DB,
                    $safety_path
                );

                exec($command, $output, $return_var);
                if ($return_var !== 0) {
                    throw new Exception('Error al crear backup de seguridad');
                }

                // Restablecer la base de datos
                $mysql_path = 'C:\\xampp\\mysql\\bin\\mysql.exe';
                $schema_file = dirname(__FILE__) . '/../../SQL/sistema_inicial.sql';

                if (!file_exists($schema_file)) {
                    throw new Exception('No se encontró el archivo de esquema inicial');
                }

                // Importar el esquema inicial
                $restore_command = sprintf(
                    '"%s" --user="%s" --password="%s" --host="%s" < "%s" 2>&1',
                    $mysql_path,
                    $user,
                    $pwd,
                    $host,
                    $schema_file
                );

                exec($restore_command, $output, $return_var);
                if ($return_var !== 0) {
                    throw new Exception('Error al restablecer el sistema: ' . implode("\n", $output));
                }

                echo json_encode([
                    'success' => true,
                    'message' => 'Sistema restablecido correctamente'
                ]);
                break;

            default:
                throw new Exception('Operación no válida');
        }

    } catch (Exception $e) {
        error_log('Error: ' . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}
?>