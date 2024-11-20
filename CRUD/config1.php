<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Edición</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-box {
            width: 100%;
            max-width: 600px; 
            margin: 40px; 
            padding: 100px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary{
            background-color: #BBCD5D;
            border: #BBCD5D;
        }

        .btn-primary:hover{
            background-color: #aabb57;
            border-color: #aabb57;
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <div class="form-box bg-light">
            <form>
                <div class="form-group">
                    <label for="dataField"><h1>Nombre:</h1></label>
                    <input type="text" class="form-control" id="dataField" value="<?php echo $_SESSION['nombre'];?>">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
