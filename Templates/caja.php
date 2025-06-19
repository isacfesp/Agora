<<<<<<< HEAD
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../Assets/CSS/alumnos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="header-section">
            <br>
            <h2 style="font-weight: 600; margin: 40px 0; font-size: 1.5rem;">Gestión de Pagos</h2>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <select id="grupoFilter" class="form-select form-select-sm">
                    <option value="">Todos los grupos</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="gradoFilter" class="form-select form-select-sm">
                    <option value="">Todos los grados</option>
                </select>
            </div>
            <div class="col-md-6 text-end">
                <button id="limpiarFiltros" type="button" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="fas fa-eraser"></i> Limpiar
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="cajatable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Matrícula</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombre</th>
                        <th>Grupo</th>
                        <th>Grado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Datos dinámicos -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para pagos -->
    <div class="modal fade" id="pagoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gestión de Pagos - <span id="alumnoInfo"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Secciones de Caja y Colegiatura -->
                    <ul class="nav nav-tabs" id="pagoTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#cajaPago">Caja</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#colegiaturaPago">Colegiatura</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <!-- Sección Caja -->
                        <div class="tab-pane fade show active" id="cajaPago">
                            <form id="cajaForm">
                                <input type="hidden" name="id_alumno" id="alumno_id">
                                <div class="mb-3">
                                    <label class="form-label">Concepto</label>
                                    <select class="form-select" name="concepto" id="conceptoSelect" required>
                                        <!-- Los conceptos se cargarán dinámicamente desde la base de datos -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Monto</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="montoInput" readonly>
                                    </div>
                                    <small id="descuentoInfo" class="text-danger" style="display: none;"></small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Método de Pago</label>
                                    <select class="form-select" name="metodo_pago" required>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="transferencia">Transferencia</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar Pago</button>
                            </form>
                            <hr>
                            <h6>Historial de Pagos (Caja)</h6>
                            <table class="table table-sm" id="historialCaja">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Método</th>
                                        <th>Concepto</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Sección Colegiatura -->
                        <div class="tab-pane fade" id="colegiaturaPago">
                            <form id="colegiaturaForm">
                                <input type="hidden" name="id_alumno" id="alumno_id_col">
                                <div class="mb-3">
                                    <label class="form-label">Mes</label>
                                    <select class="form-select" name="mes" required>
                                        <option value="Enero">Enero</option>
                                        <option value="Febrero">Febrero</option>
                                        <option value="Marzo">Marzo</option>
                                        <option value="Abril">Abril</option>
                                        <option value="Mayo">Mayo</option>
                                        <option value="Junio">Junio</option>
                                        <option value="Julio">Julio</option>
                                        <option value="Agosto">Agosto</option>
                                        <option value="Septiembre">Septiembre</option>
                                        <option value="Octubre">Octubre</option>
                                        <option value="Noviembre">Noviembre</option>
                                        <option value="Diciembre">Diciembre</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Monto</label>
                                    <input type="number" class="form-control" name="monto" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Método de Pago</label>
                                    <select class="form-select" name="metodo_pago" required>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="transferencia">Transferencia</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar Pago</button>
                            </form>
                            <hr>
                            <h6>Historial de Pagos (Colegiatura)</h6>
                            <table class="table table-sm" id="historialColegiatura">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Método</th>
                                        <th>Mes</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../Assets/JS/caja.js"></script>
</body>
</html>
=======
<?php

?>
>>>>>>> 4515e08590704eaa1a6999874f38c4c3ea44c3c0
