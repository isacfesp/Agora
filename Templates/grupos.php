<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../Assets/CSS/grupos.css">
</head>

<body>
    <div class="container">
        <div class="header-section">
            <br>
            <h2 style="font-weight: 600; margin: 40px 0; font-size: 1.5rem;">Gestión de Grupos</h2>
        </div>

        <div class="row mb-3">
            <div class="col-md-2">
                <select id="filtroGrupo" class="form-select form-select-sm">
                    <option value="">Todos los grupos</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filtroGrado" class="form-select form-select-sm">
                    <option value="">Todos los grados</option>
                </select>
            </div>
            <div class="col-md-2">
                <select id="filtroProfesor" class="form-select form-select-sm">
                    <option value="">Todos los profesores</option>
                </select>
            </div>
            <div class="col-md-5 text-end">
                <button id="btnLimpiarFiltros" type="button" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="fas fa-eraser"></i> Limpiar
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalGrupo">
                    <i class="fas fa-plus"></i> Nuevo
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="gruposTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Grupo</th>
                        <th>Grado</th>
                        <th>Profesor</th>
                        <th>Periodo</th>
                        <th>Total Alumnos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Datos dinámicos -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../Assets/JS/grupos.js"></script>
</body>
</html>