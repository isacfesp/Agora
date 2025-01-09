<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Nombre</title>
    <!-- Enlace a Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .btn-primary {
            background-color: #3C4046;
            border: none;
            margin-left: 75%;
        }

        .btn-primary:hover{
            background-color: #3C4046;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            background-color: #e9ecef;
            color: #6c757d;
            padding: 10px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #d6dbdf;
            color: #4a4a4a;
        }

        .btn-back i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container mx-auto">
            <!-- Botón para regresar -->
            <a href="javascript:history.back()" class="btn-back">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>

            <form>
                <div class="form-group">
                    <label for="nombre" style="font-size: 24px; margin-bottom: 10%">Nombre:</label>
                    <input type="text" id="nombre" class="form-control" placeholder="Ingresa el nombre" value="<?php echo $_SESSION['nombre']; ?>">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="config.html" class="btn btn-primary">Guardar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Enlace a FontAwesome para los íconos -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <!-- Enlace a Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
