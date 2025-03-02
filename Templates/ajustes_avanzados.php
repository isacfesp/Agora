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

        <!-- Módulo de Noticias -->
        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-newspaper"></i>Noticias</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#crearNoticiaModal">
                            <i class="fas fa-plus"></i> Crear Noticia
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-secondary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#editarNoticiaModal">
                            <i class="fas fa-edit"></i> Editar Noticia
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-info w-100 mb-2" data-bs-toggle="modal" data-bs-target="#programarNoticiaModal">
                            <i class="fas fa-clock"></i> Programar Publicación
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#categoriasModal">
                            <i class="fas fa-tags"></i> Categorías y Etiquetas
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Módulo de Promociones de Pagos -->
        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-percentage"></i>Promociones de Pagos</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#crearPromocionModal">
                            <i class="fas fa-plus"></i> Crear Promoción
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-secondary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#administrarPagosModal">
                            <i class="fas fa-money-bill"></i> Administrar Pagos
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-info w-100 mb-2" data-bs-toggle="modal" data-bs-target="#historialTransaccionesModal">
                            <i class="fas fa-history"></i> Historial de Transacciones
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Módulo de Periodos Escolares -->
        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-calendar-alt"></i>Periodos Escolares</h4>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periodoEscolarModal">
                    <i class="fas fa-plus"></i> Añadir Periodo Escolar
                </button>
            </div>
        </div>

        <!-- Módulo de Gestión de Usuarios -->
        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-users-cog"></i>Gestión de Usuarios</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#tipoUsuarioModal">
                            <i class="fas fa-user-plus"></i> Crear Tipo de Usuario
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-secondary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#permisosModal">
                            <i class="fas fa-key"></i> Asignar Permisos
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-info w-100 mb-2" data-bs-toggle="modal" data-bs-target="#gruposUsuariosModal">
                            <i class="fas fa-users"></i> Gestionar Grupos
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Módulo de Mantenimiento y Seguridad -->
        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-shield-alt"></i>Mantenimiento y Seguridad</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-warning w-100 mb-2" data-bs-toggle="modal" data-bs-target="#restablecerDatosModal">
                            <i class="fas fa-undo"></i> Restablecer Datos
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#copiaSeguriadModal">
                            <i class="fas fa-database"></i> Copia de Seguridad
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>