<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Imagen</title>
    <!-- Incluir CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Subir Imagen</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data" class="border p-4">
            <div class="form-group">
                <label for="fileToUpload">Selecciona la imagen para subir:</label>
                <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload">
            </div>
            <button type="submit" class="btn btn-primary">Subir Imagen</button>
        </form>
    </div>

    <!-- Incluir JS de Bootstrap y dependencias de JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
