<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustes Avanzados</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Assets/CSS/ajustes.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Ajustes Avanzados</h2>

        <!-- Módulo de Anuncios -->
        <div class="card mb-4">
            <div class="card-header" role="button" data-bs-toggle="collapse" data-bs-target="#anunciosCollapse">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-newspaper me-2"></i>Anuncios</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="collapse" id="anunciosCollapse">
                <div class="card-body">
                    <button class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Nuevo Anuncio
                    </button>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Fecha Publicación</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ejemplo de Anuncio</td>
                                    <td>31/05/2025</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Módulo de Promociones -->
        <div class="card mb-4">
            <div class="card-header" role="button" data-bs-toggle="collapse" data-bs-target="#promocionesCollapse">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-percentage me-2"></i>Promociones</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="collapse" id="promocionesCollapse">
                <div class="card-body">
                    <button class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Nueva Promoción
                    </button>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Descuento</th>
                                    <th>Vigencia</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Promoción Inscripción</td>
                                    <td>Inscripción</td>
                                    <td>15%</td>
                                    <td>01/06/2025 - 31/07/2025</td>
                                    <td><span class="badge bg-success">Activa</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Módulo de Periodos -->
        <div class="card mb-4">
            <div class="card-header" role="button" data-bs-toggle="collapse" data-bs-target="#periodosCollapse">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Periodos Escolares</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="collapse" id="periodosCollapse">
                <div class="card-body">
                    <button class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Nuevo Periodo
                    </button>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha Inicio</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>01/08/2025</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Módulo de Permisos -->
        <div class="card mb-4">
            <div class="card-header" role="button" data-bs-toggle="collapse" data-bs-target="#permisosCollapse">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-users-cog me-2"></i>Gestión de Permisos</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="collapse" id="permisosCollapse">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus"></i> Nuevo Tipo de Usuario
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tipo Usuario</th>
                                    <th>Permisos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Administrativo</td>
                                    <td>
                                        <span class="badge bg-info me-1">Ver Anuncios</span>
                                        <span class="badge bg-info me-1">Crear Anuncios</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Módulo de Copias de Seguridad y Restauración -->
        <div class="card mb-4">
            <div class="card-header" role="button" data-bs-toggle="collapse" data-bs-target="#backupCollapse">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-database me-2"></i>Copias de Seguridad y Restauración</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <div class="collapse" id="backupCollapse">
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <!-- Crear Backup -->
                        <div class="col-md-4">
                            <div class="card h-100 border-primary">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-download me-2"></i>Crear Copia de Seguridad</h5>
                                    <p class="card-text">Genera una copia de seguridad completa del sistema.</p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#backupModal">
                                        <i class="fas fa-save me-2"></i>Crear Backup
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Restaurar Backup -->
                        <div class="col-md-4">
                            <div class="card h-100 border-warning">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-upload me-2"></i>Restaurar Sistema</h5>
                                    <p class="card-text">Restaura el sistema desde una copia de seguridad.</p>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#restaurarModal">
                                        <i class="fas fa-undo me-2"></i>Restaurar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Restablecer Sistema -->
                        <div class="col-md-4">
                            <div class="card h-100 border-danger">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-exclamation-triangle me-2"></i>Restablecer Sistema</h5>
                                    <p class="card-text">Restablece el sistema a valores predeterminados.</p>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#restablecerModal">
                                        <i class="fas fa-trash me-2"></i>Restablecer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de Copias de Seguridad -->
                    <div class="table-responsive mt-4">
                        <h5 class="mb-3">Historial de Copias de Seguridad</h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tamaño</th>
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="backupHistoryBody">
                                <!-- El contenido se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Configuración de Copias Automáticas -->
                    <div class="mt-4">
                        <h5 class="mb-3">Configuración de Copias Automáticas</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="autoBackup">
                                    <label class="form-check-label" for="autoBackup">Habilitar copias automáticas</label>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Frecuencia</label>
                                        <select class="form-select">
                                            <option value="daily">Diaria</option>
                                            <option value="weekly">Semanal</option>
                                            <option value="monthly">Mensual</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Hora</label>
                                        <input type="time" class="form-control" value="00:00">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Validación de Backup -->
    <div class="modal fade" id="backupModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Copia de Seguridad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="backupForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="backupPassword" class="form-label">Contraseña de Administrador</label>
                            <input type="password" class="form-control" id="backupPassword" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Crear Backup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Validación de Restauración -->
    <div class="modal fade" id="restaurarModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="restaurarForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Restaurar Sistema</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Esta acción restaurará el sistema a una versión anterior. Los datos actuales serán reemplazados.
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Seleccionar Backup</label>
                            <input type="file" name="backup_file" class="form-control" accept=".sql" required>
                            <small class="text-muted">Solo archivos SQL de backup</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña de Administrador</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn" style="background-color: #BBCD5D; color: white;">
                            <i class="fas fa-undo me-2"></i>Restaurar Sistema
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Restablecer Sistema -->
    <div class="modal fade" id="restablecerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restablecer Sistema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>¡ADVERTENCIA!</strong> Esta acción eliminará TODOS los datos y restablecerá el sistema a su estado inicial.
                        Esta acción no se puede deshacer.
                    </div>
                    <form id="restablecerForm">
                        <div class="mb-3">
                            <label class="form-label">Escriba "RESTABLECER" para confirmar</label>
                            <input type="text" class="form-control" pattern="RESTABLECER" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña de Administrador</label>
                            <input type="password" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="restablecerForm" class="btn btn-danger">Restablecer Sistema</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../Assets/JS/ajustes.js"></script>
</body>
</html>