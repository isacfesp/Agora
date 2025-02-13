<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #BBCD5D;
            --primary-hover: #A8B850;
            --secondary: #2D3436;
            --success: #28A745;
            --danger: #DC3545;
            --warning: #FFC107;
            --text-primary: #2D3436;
            --text-secondary: #636E72;
            --border: #E0E5E9;
            --surface: #FFFFFF;
            --background: #f7f9fb;
        }

        body {
            background: var(--background);
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--text-primary);
        }

        .main-container {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 95%;
            margin: 2rem auto;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
        }

        /* Navegación mejorada */
        .nav-tabs {
            border-bottom: 2px solid var(--border);
            padding: 0 1.5rem;
            background: #FCFCFC;
        }

        .nav-link {
            color: var(--text-secondary);
            font-weight: 500;
            border: none;
            padding: 1rem 2rem;
            transition: all 0.2s ease;
            position: relative;
            margin: 0 0.25rem;
        }

        .nav-link.active {
            background: var(--primary);
            color: #BBCD5D;
            border-radius: 4px 4px 0 0;
            border: none;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.03);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--surface);
        }

        .nav-link:hover:not(.active) {
            background: #F5F5F5;
        }

        /* Secciones de contenido */
        .tab-content {
            padding: 2rem;
        }

        /* Componentes de datos */
        .data-card {
            padding: 1.5rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            background: var(--surface);
        }

        .data-header {
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }

        /* Sistema de botones */
        .btn-primary {
            background: var(--primary);
            border: none;
            color: var(--surface);
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #F0F2F5;
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
        }

        /* Tablas profesionales */
        .table-custom {
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
        }

        .table-custom thead {
            background: #FAFAFA;
            border-bottom: 2px solid var(--border);
        }

        .table-custom th {
            font-weight: 600;
            color: var(--text-secondary);
            padding: 1rem;
        }

        .table-custom td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* Sistema de alertas */
        .alert-card {
            padding: 1.5rem;
            border-left: 4px solid;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }

        .alert-warning {
            border-color: var(--warning);
            background: #FFF9E6;
        }

        .alert-danger {
            border-color: var(--danger);
            background: #FCE8E8;
        }

        .alert-success {
            border-color: var(--success);
            background: #E8F5E9;
        }

        /* Filtros y controles */
        .filter-container {
            background: #FAFAFA;
            padding: 1.5rem;
            border-radius: 6px;
            margin-bottom: 2rem;
        }

        .form-select {
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 0.75rem 1rem;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header -->
        <div class="nav-tabs">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#datos">
                        <i class="fas fa-user fa-sm me-2"></i>
                        Datos del Alumno
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#pagos">
                        <i class="fas fa-wallet fa-sm me-2"></i>
                        Historial de Pagos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#academico">
                        <i class="fas fa-graduation-cap fa-sm me-2"></i>
                        Historial Académico
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#opciones">
                        <i class="fas fa-cog fa-sm me-2"></i>
                        Opciones Administrativas
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenido de las pestañas -->
        <div class="tab-content">
            <!-- Sección Datos -->
            <div class="tab-pane fade show active" id="datos">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="data-card">
                            <h5 class="data-header">Información Personal</h5>
                            <dl class="row">
                                <dt class="col-sm-4 text-secondary">Nombre completo</dt>
                                <dd class="col-sm-8">Juan Pérez López</dd>
                                
                                <dt class="col-sm-4 text-secondary">Fecha de nacimiento</dt>
                                <dd class="col-sm-8">15/03/1995</dd>
                                
                                <dt class="col-sm-4 text-secondary">Contacto</dt>
                                <dd class="col-sm-8">
                                    <div>55 1234 5678</div>
                                    <div>juan.perez@instituto.edu</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="data-card">
                            <h5 class="data-header">Información Académica</h5>
                            <dl class="row">
                                <dt class="col-sm-4 text-secondary">Programa</dt>
                                <dd class="col-sm-8">Inyección electrónica</dd>
                                
                                <dt class="col-sm-4 text-secondary">Matrícula</dt>
                                <dd class="col-sm-8">02251001</dd>
                                
                                <dt class="col-sm-4 text-secondary">Promedio</dt>
                                <dd class="col-sm-8">8.9</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección Pagos -->
            <div class="tab-pane fade" id="pagos">
                <div class="filter-container">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <select class="form-select">
                                <option>Filtrar por periodo</option>
                                <option>02/25</option>
                                <option>01/25</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select">
                                <option>Filtrar por estatus</option>
                                <option>Completado</option>
                                <option>Pendiente</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Aplicar Filtros
                            </button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="data-header">Registro de Pagos</h5>
                    <button class="btn-primary">
                        <i class="fas fa-plus me-2"></i>Cargar Monto
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>16/02/2025</td>
                                <td>Colegiatura febrero 2025</td>
                                <td>$2,500.00</td>
                                <td><span class="badge bg-success">Completado</span></td>
                                <td>
                                    <button class="btn-secondary">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sección Académico -->
            <div class="tab-pane fade" id="academico">
                <div class="filter-container">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <select class="form-select">
                                <option>Seleccionar Periodo</option>
                                <option>01/25</option>
                                <option>02/25</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select">
                                <option>Ordenar por Calificación</option>
                                <option>Ordenar por Materia</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn-primary w-100">
                                <i class="fas fa-download me-2"></i>Generar Reporte
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Calificación</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Materia</td>
                                <td>9.5</td>
                                <td><span class="badge bg-success">Aprobado</span></td>
                                <td>
                                    <button class="btn-secondary">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sección Opciones -->
            <div class="tab-pane fade" id="opciones">
                <div class="alert-card alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Acciones administrativas requieren autorización del departamento correspondiente
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="data-card h-100">
                            <h5 class="data-header">Baja Temporal</h5>
                            <p class="text-secondary mb-4">Suspensión temporal de actividades académicas</p>
                            <button class="btn-primary w-100">
                                <i class="fas fa-pause me-2"></i>Solicitar Baja
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="data-card h-100">
                            <h5 class="data-header">Baja Definitiva</h5>
                            <p class="text-secondary mb-4">Egreso permanente del programa académico</p>
                            <button class="btn-primary w-100 bg-danger border-danger">
                                <i class="fas fa-times me-2"></i>Solicitar Baja
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="data-card h-100">
                            <h5 class="data-header">Reactivación</h5>
                            <p class="text-secondary mb-4">Reincorporación al programa académico después de baja temporal</p>
                            <button class="btn-primary w-100 bg-success border-success" disabled >
                                <i class="fas fa-redo me-2"></i>Solicitar Reactivación
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>