<?php
// Incluye el archivo de conexión de forma segura
require __DIR__ . '../../Config/conexion.php';

// Verifica si la solicitud es un POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
    // 1. Sanitizar y validar los datos del formulario
    $name = htmlspecialchars(trim($_POST["name"]));
    $apaterno = htmlspecialchars(trim($_POST["apaterno"]));
    $amaterno = htmlspecialchars(trim($_POST["amaterno"]));
    $num = htmlspecialchars(trim($_POST["num"]));
    $whatsapp = htmlspecialchars(trim($_POST["whatsapp"]));
    $formato = htmlspecialchars(trim($_POST["formato"]));

    // Validaciones básicas (opcional pero recomendado)
    if (empty($name) || empty($apaterno) || empty($amaterno) || empty($num) || empty($whatsapp) || empty($formato)) {
        die("Todos los campos son obligatorios.");
    }
    
    // 2. Usar declaraciones preparadas para prevenir inyección SQL
    $sql = "INSERT INTO contacto (nombre, apaterno, amaterno, numero_telefonico, whatsapp, formato) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $connection->prepare($sql);
    
    // Manejo de error al preparar la consulta
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $connection->error);
    }
    
    // 3. Vincular los parámetros con sus tipos
    // 'ssssss' significa 6 parámetros de tipo string
    $stmt->bind_param("ssssss", $name, $apaterno, $amaterno, $num, $whatsapp, $formato);
    
    // 4. Ejecutar la declaración
    if ($stmt->execute()) {
        // Redirige al usuario en lugar de usar un script inline.
        // Esto previene el reenvío accidental del formulario si se recarga la página.
        header("Location: contactos.php?status=success");
        exit();
    } else {
        echo "Error: No se pudo crear el contacto. " . $stmt->error;
    }
    
    // 5. Cerrar la declaración
    $stmt->close();
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/CSS/crearContacto.css">
</head>

<body>
    <div class="container form-container">
        <div class="form-box">
            <a href="../../Templates/contactos.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>

            <!-- Formulario -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingresa el nombre" required
                        name="name">
                </div>
                <div class="form-group">
                    <label for="apaterno">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="apaterno" placeholder="Ingresa el apellido paterno"
                        required name="apaterno">
                </div>
                <div class="form-group">
                    <label for="amaterno">Apellido Materno:</label>
                    <input type="text" class="form-control" id="amaterno" placeholder="Ingresa el apellido materno"
                        required name="amaterno">
                </div>
                <div class="form-group">
                    <label for="telefono">Número Telefónico:</label>
                    <input type="text" class="form-control" id="telefono" placeholder="Ingresa el número telefónico"
                        maxlength="10" pattern="\d{10}" required name="num">
                </div>
                <div class="form-group">
                    <label for="whatsapp">WhatsApp:</label>
                    <select class="form-control" id="whatsapp" required name="whatsapp">
                        <option value="">Selecciona una opción</option>
                        <option value="Sí">Sí</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="formato">Formato:</label>
                    <select class="form-control" id="whatsapp" required name="formato">
                        <option value="">Selecciona una opción</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Familiar">Familiar</option>
                        <option value="Instagram">Instagram</option>
                        <option value="TikTok">TikTok</option>
                        <option value="Amigo">Amigo</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="submit">Guardar</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>


<!--Ventanas emergentes -->
<div class="overlay" id="overlay" style="display: none;">
    <div class="popup">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark-check" fill="none" stroke="#BBCD5D" stroke-width="5"
                d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <p>¡Operación exitosa!</p>
        <button class="btn-primary" onclick="closePopup()">Aceptar</button>
    </div>
</div>



<script>
    function closePopup() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>



</html>