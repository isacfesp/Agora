<?php
// INICIO DEL PROCESO SEGURO
// 1. Incluye la conexión segura a la base de datos.
// El archivo `conexion.php` ahora devuelve el objeto de conexión.
$connection = require_once '../../Config/conexion.php';

// 2. Procesa la solicitud POST solo si el formulario ha sido enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
    // 3. Sanitiza y valida los datos de entrada del lado del servidor.
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $estado = filter_var($_POST["estado"], FILTER_VALIDATE_INT);
    $tipo_usuario = filter_var($_POST["tipo_usuario"], FILTER_VALIDATE_INT);

    // 4. Validación de datos: Asegura que las variables no sean nulas o inválidas.
    if (!$email || $estado === false || $tipo_usuario === false) {
        die("Error: Datos de formulario inválidos.");
    }
    
    // NOTA DE SEGURIDAD:
    // La variable $password no está definida porque el campo de contraseña
    // en el formulario HTML está comentado. Por lo tanto, no se puede hashear.
    // Si agregas un campo de contraseña, asegúrate de definir esta variable
    // ANTES de intentar hashearla.
    // Ejemplo: $password = $_POST["password"];
    // $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 5. Utiliza una sentencia preparada para prevenir la inyección de SQL.
    $sql = "INSERT INTO usuario (email, estado, tipo_usuario) VALUES (?, ?, ?)";
    
    $stmt = $connection->prepare($sql);
    
    if ($stmt === false) {
        error_log("Error al preparar la consulta: " . $connection->error);
        die("Hubo un error al crear el usuario. Por favor, inténtelo de nuevo más tarde.");
    }
    
    // 6. Vincula los parámetros a la sentencia preparada.
    $stmt->bind_param("sii", $email, $estado, $tipo_usuario);
    
    // 7. Ejecuta la consulta y verifica el resultado.
    if ($stmt->execute()) {
        header("Location: ../../Templates/Gestion_usuarios.html?usuario_creado=1");
        exit();
    } else {
        error_log("Error al ejecutar la consulta: " . $stmt->error);
        die("No se pudo crear el usuario.");
    }

    // 8. Cierra la sentencia y la conexión.
    $stmt->close();
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/CSS/crearContacto.css">
</head>
<body>
    <div class="container form-container">
        <div class="form-box">
            <a href="../../Templates/Gestion_usuarios.html" class="btn-back">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="crearUsuarioForm">
                <div id="alerta" class="alert d-none" role="alert"></div>
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" id="email" placeholder="Ingresa el correo" required name="email">
                </div>
                <div class="form-group" style="display: none;">
                    <label for="estado">Estado:</label>
                    <select class="form-control" id="estado" required name="estado">
                        <option value="1" selected>Inactivo</option>
                    </select>
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
                    <label for="permisos" id="permisos">Permisos: A</label>
                </div>
                    <script>
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
                    </script>
                <button type="submit" class="btn btn-primary btn-block" name="submit" id="validar">Guardar</button>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('crearUsuarioForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const email = document.getElementById('email').value.trim();
        const alerta = document.getElementById('alerta');
        alerta.classList.add('d-none');

        // Validación básica de formato de correo
        if (!email.match(/^[^@\s]+@[^@\s]+\.[^@\s]+$/)) {
            alerta.textContent = 'Por favor, ingresa un correo válido.';
            alerta.className = 'alert alert-danger';
            alerta.classList.remove('d-none');
            return;
        }

        // Petición al backend para validar si el correo existe
        fetch('validar_email.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ correo_usuario: email })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Si el correo es válido, envía el formulario
                event.target.submit();
            } else {
                alerta.textContent = data.mensaje || 'El correo ya existe en el sistema.';
                alerta.className = 'alert alert-danger';
                alerta.classList.remove('d-none');
            }
        })
        .catch(() => {
            alerta.textContent = 'Error de conexión con el servidor.';
            alerta.className = 'alert alert-danger';
            alerta.classList.remove('d-none');
        });
    });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>