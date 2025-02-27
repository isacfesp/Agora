<?php
$apaterno = isset($_GET['apaterno']) ? $_GET['apaterno'] : '';
$amaterno = isset($_GET['amaterno']) ? $_GET['amaterno'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$nacimiento = isset($_GET['nacimiento']) ? $_GET['nacimiento'] : '';
$edad = isset($_GET['edad']) ? $_GET['edad'] : '';
$curp = isset($_GET['curp']) ? $_GET['curp'] : '';
$celular = isset($_GET['celular']) ? $_GET['celular'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$telefono = isset($_GET['telefono']) ? $_GET['telefono'] : '';
$calle = isset($_GET['calle']) ? $_GET['calle'] : '';
$colonia = isset($_GET['colonia']) ? $_GET['colonia'] : '';
$cp = isset($_GET['cp']) ? $_GET['cp'] : '';
$municipio = isset($_GET['municipio']) ? $_GET['municipio'] : '';
$t_apaterno = isset($_GET['t_apaterno']) ? $_GET['t_apaterno'] : '';
$t_amaterno = isset($_GET['t_amaterno']) ? $_GET['t_amaterno'] : '';
$t_nombre = isset($_GET['t_nombre']) ? $_GET['t_nombre'] : '';
$t_telefono = isset($_GET['t_telefono']) ? $_GET['t_telefono'] : '';
$t_celular = isset($_GET['t_celular']) ? $_GET['t_celular'] : '';
$t_email = isset($_GET['t_email']) ? $_GET['t_email'] : '';
$e_apaterno = isset($_GET['e_apaterno']) ? $_GET['e_apaterno'] : '';
$e_amaterno = isset($_GET['e_amaterno']) ? $_GET['e_amaterno'] : '';
$e_nombre = isset($_GET['e_nombre']) ? $_GET['e_nombre'] : '';
$e_parentesco = isset($_GET['e_parentesco']) ? $_GET['e_parentesco'] : '';
$e_telefono = isset($_GET['e_telefono']) ? $_GET['e_telefono'] : '';
?>

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
            --primary: #2C3E50;
            --primary-hover: #1A252F;
            --secondary: #34495E;
            --success: #27AE60;
            --danger: #E74C3C;
            --warning: #F1C40F;
            --text-primary: #2C3E50;
            --text-secondary: #7F8C8D;
            --border: #BDC3C7;
            --surface: #FFFFFF;
            --background: #ECF0F1;
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
            border-radius: 12px;
            overflow: hidden;
        }

        .nav-tabs {
            border-bottom: 2px solid var(--border);
            padding: 0 1.5rem;
            background: var(--surface);
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
            color: var(--surface);
            border-radius: 8px 8px 0 0;
            border: none;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.03);
        }

        .nav-link:hover:not(.active) {
            background: #F5F5F5;
        }

        .tab-content {
            padding: 2rem;
        }

        .data-card {
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            background: var(--surface);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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

        .btn-primary {
            background: var(--primary);
            border: none;
            color: var(--surface);
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
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
            border-radius: 6px;
        }

        .table-custom {
            border: 1px solid var(--border);
            border-radius: 8px;
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

        .alert-card {
            padding: 1.5rem;
            border-left: 4px solid;
            border-radius: 6px;
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

        .filter-container {
            background: #FAFAFA;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .form-select {
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.75rem 1rem;
        }

        .profile-section {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .profile-section img {
            margin-left: 2%;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 1.5rem;
        }

        .profile-section h2 {
            margin: 0;
            font-size: 1.75rem;
            color: var(--text-primary);
        }

        .profile-section p {
            margin: 0;
            color: var(--text-secondary);
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
                <div class="profile-section">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="Foto del Alumno">
                    <div>
                        <h2><?php echo $nombre . ' ' . $apaterno . ' ' . $amaterno ?></h2>
                        <p>Matrícula: 02251001</p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="data-card">
                            <h5 class="data-header">Información Personal</h5>
                            <dl class="row">
                                <dt class="col-sm-4 text-secondary">Fecha de nacimiento</dt>
                                <dd class="col-sm-8"><?php echo $nacimiento ?></dd>

                                <dt class="col-sm-4 text-secondary">Edad</dt>
                                <dd class="col-sm-8"><?php echo $edad ?> años</dd>

                                <dt class="col-sm-4 text-secondary">Curp</dt>
                                <dd class="col-sm-8"><?php echo $curp ?></dd>

                                <dt class="col-sm-4 text-secondary">Contacto</dt>
                                <dd class="col-sm-8">
                                    <div><?php echo $celular ?></div>
                                    <div><?php echo $telefono ?></div>
                                    <div><?php echo $email ?></div>
                                </dd>

                                <dt class="col-sm-4 text-secondary">Dirección</dt>
                                <dd class="col-sm-8">
                                    <div><?php echo $calle ?></div>
                                    <div><?php echo $colonia ?></div>
                                    <div><?php echo $cp ?></div>
                                    <div><?php echo $municipio ?></div>
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
                                
                                <dt class="col-sm-4 text-secondary">Promedio</dt>
                                <dd class="col-sm-8">8.9</dd>
                            </dl>
                        </div>

                        <div class="data-card">
                            <h5 class="data-header">Información del Tutor</h5>
                            <dl class="row">
                                <dt class="col-sm-4 text-secondary">Nombre Completo</dt>
                                <dd class="col-sm-8"><?php echo $t_nombre . ' ' . $t_apaterno . ' ' . $t_amaterno ?></dd>
                                
                                <dt class="col-sm-4 text-secondary">Contacto</dt>
                                <dd class="col-sm-8">
                                    <div><?php echo $t_celular ?></div>
                                    <div><?php echo $t_telefono ?></div>
                                    <div><?php echo $t_email ?></div>
                                </dd>
                            </dl>
                        </div>

                        <div class="data-card">
                            <h5 class="data-header">Información de Emergencia</h5>
                            <dl class="row">
                                <dt class="col-sm-4 text-secondary">Nombre Completo</dt>
                                <dd class="col-sm-8"><?php echo $e_nombre . ' ' . $e_apaterno . ' ' . $e_amaterno ?></dd>
                                
                                <dt class="col-sm-4 text-secondary">Contacto</dt>
                                <dd class="col-sm-8">
                                    <div><?php echo $e_parentesco . ' del alumn@' ?></div>
                                    <div><?php echo $e_telefono ?></div>
                                </dd>
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