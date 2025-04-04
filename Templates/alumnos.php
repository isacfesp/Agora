<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../Assets/CSS/alumnos.css">
</head>

<body>
    <div class="container">
        <div class="header-section">
            <br>
            <h2 style="font-weight: 600; margin: 40px 0; font-size: 1.5rem;">Gestión de Alumnos</h2>
        </div>

        <div class="filter-container mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <div class="me-2">
                    <select id="grupoFilter" class="form-select" aria-label="Selecciona grupo">
                        <option value="">Grupo</option>
                    </select>
                </div>
                <div class="me-2">
                    <select id="periodoFilter" class="form-select" aria-label="Selecciona periodo">
                        <option value="">Periodo</option>
                    </select>
                </div>
                <div class="me-2 d-flex align-items-center">
                    <select id="gradoFilter" class="form-select" aria-label="Selecciona grado">
                        <option value="">Grado</option>
                    </select>
                    <span id="resetFilters" class="ms-2 text-secondary" role="button" title="Reiniciar Filtros">
                        <i class="fas fa-sync-alt"></i>
                    </span>
                </div>
            </div>
        </div>

        <table id="alumnostable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Matrícula</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../Assets/JS/alumnos.js"></script>
</body>
</html>