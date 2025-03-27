<?php
$id_alumno = isset($_GET['id_alumno']) ? $_GET['id_alumno'] : '';
require_once '../../Config/conexion.php';
$sql = "SELECT * FROM alumno WHERE id_alumno = '$id_alumno'";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $matricula = $row['matricula'];
    $apaterno = $row['apaterno'];
    $amaterno = $row['amaterno'];
    $nombre = $row['nombre'];
    $nacimiento = $row['nacimiento'];
    $edad = $row['edad'];
    $curp = $row['curp'];
    $email = $row['email'];
    $celular = $row['tel_celular'];
    $telefono = $row['tel_fijo'];
    $calle = $row['calle'];
    $colonia = $row['colonia'];
    $cp = $row['cp'];
    $municipio = $row['municipio'];
    $t_apaterno = $row['tutor_apaterno'];
    $t_amaterno = $row['tutor_amaterno'];
    $t_nombre = $row['tutor_nombre'];
    $t_telefono = $row['tutor_tel_fijo'];
    $t_celular = $row['tutor_tel_celular'];
    $t_email = $row['tutor_email'];
    $e_apaterno = $row['emergencia_apaterno'];
    $e_amaterno = $row['emergencia_amaterno'];
    $e_nombre = $row['emergencia_nombre'];
    $e_parentesco = $row['emergencia_parentesco'];
    $e_telefono = $row['emergencia_tel'];
    $estado = $row['estado']; // Obtener el estado del alumno
}


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agora";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$payments = [];
$existingPayments = [];
if ($matricula) {
    $sql = "SELECT id_alumno FROM alumno WHERE matricula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();
    $id_alumno = null;
    if ($row = $result->fetch_assoc()) {
        $id_alumno = $row['id_alumno'];
    }

    if ($id_alumno) {
        $sql = "SELECT id_inscripcion FROM inscripcion WHERE id_alumno = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_alumno);
        $stmt->execute();
        $result = $stmt->get_result();
        $id_inscripcion = null;
        if ($row = $result->fetch_assoc()) {
            $id_inscripcion = $row['id_inscripcion'];
        }

        if ($id_inscripcion) {
            $sql = "SELECT id_pago, monto, concepto FROM caja WHERE id_inscripcion = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_inscripcion);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $payments[] = $row;
                $existingPayments[] = $row['concepto'];
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../Assets/CSS/alumno.css">
</head>

<body>
    <div class="main-container">
        <!-- Notification Container -->
        <div id="notification-container" class="notification-container"></div>
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
                
                <li class="nav-item estado-alumno">
                    <span class="estado-circle <?php echo 'estado-' . str_replace('_', '-', $estado); ?>"></span>
                    Estado: <?php echo ucfirst(str_replace('_', ' ', $estado)); ?>
                </li>
            </ul>
        </div>

        <!-- Contenido de las pestañas -->
        <div class="tab-content">
            <!-- Sección Datos -->
            <div class="tab-pane fade show active" id="datos">
                <div class="profile-section d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="Foto del Alumno">
                        <div>
                            <h2><?php echo $nombre . ' ' . $apaterno . ' ' . $amaterno ?></h2>
                            <p>Matrícula: <?php echo $matricula ?></p>
                        </div>
                    </div>
                    <!-- Botón de Imprimir Solicitud -->
                    <button id="ImprimirSolicitud" class="btn btn-secondary">
                        <i class="fas fa-print"></i>
                    </button>
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
                <!-- Payment Form -->
                <div class="data-card mb-4">
                    <h5 class="data-header">Agregar Pago</h5>
                    <form method="post" action="guardar_pago.php" class="row g-3">
                        <input type="hidden" name="id_alumno" value="<?php echo $id_alumno; ?>">
                        <input type="hidden" name="id_inscripcion" value="<?php echo $matricula; ?>">

                        <div class="col-md-4">
                            <label class="form-label">Tipo de Pago</label>
                            <select class="form-select" id="tipoPago" name="tipoPago" required>
                                <option value="">Seleccionar tipo</option>
                                <?php if (!in_array('colegiatura', $existingPayments)): ?>
                                    <option value="colegiatura">Colegiatura Mensual</option>
                                <?php endif; ?>
                                <?php if (!in_array('caja', $existingPayments)): ?>
                                    <option value="caja">Pago de Caja</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Campos para Colegiatura -->
                        <div class="col-md-8" id="colegiaturaFields" style="display: none;">
                            <label class="form-label">Mes de Pago</label>
                            <select class="form-select" name="mes">
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

                        <!-- Campos para Caja -->
                        <div id="cajaFields" style="display: none;">
                            <div class="col-md-12">
                                <label class="form-label">Concepto</label>
                                <select class="form-select" id="concepto" name="concepto">
                                    <option value="">Seleccionar concepto</option>
                                    <?php if (!in_array('Inscripción', $existingPayments)): ?>
                                        <option value="Inscripción" data-monto="2000">Inscripción - $2,000</option>
                                    <?php endif; ?>
                                    <?php if (!in_array('Seguro escolar', $existingPayments)): ?>
                                        <option value="Seguro escolar" data-monto="600">Seguro escolar - $600</option>
                                    <?php endif; ?>
                                    <?php if (!in_array('Trámites administrativos', $existingPayments)): ?>
                                        <option value="Trámites administrativos" data-monto="3000">Trámites administrativos - $3,000</option>
                                    <?php endif; ?>
                                    <?php if (!in_array('Playera mensual', $existingPayments)): ?>
                                        <option value="Playera mensual" data-monto="430">Playera mensual - $430</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="form-label">Monto</label>
                                <input type="number" class="form-control" id="monto" name="monto" readonly>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <button type="submit" class="btn-primary" name="submit">
                                <i class="fas fa-save me-2"></i>Guardar Pago
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Payment History -->
                <div class="data-card mb-4">
                    <h5 class="data-header">Historial de Pagos</h5>
                    <button class="btn-primary" onclick="imprimirHistorial()">
                        <i class="fas fa-print me-2"></i>Imprimir Historial
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom" id="paymentsTable">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $payment): ?>
                                <tr>
                                    <td></td> 
                                    <td>Caja</td>
                                    <td><?php echo $payment['concepto']; ?></td>
                                    <td><?php echo $payment['monto']; ?></td>
                                    <td>
                                        <button class="btn-secondary" onclick="imprimirRecibo(<?php echo $payment['id_pago']; ?>, 'caja')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
                    xd
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="data-card h-100">
                            <h5 class="data-header">Baja Temporal</h5>
                            <p class="text-secondary mb-4">Suspensión temporal de actividades académicas</p>
                            <button id="bajaTemporalBtn" class="btn-admin-warning w-100">
                                <i class="fas fa-pause me-2"></i>Solicitar Baja
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="data-card h-100">
                            <h5 class="data-header">Baja Definitiva</h5>
                            <p class="text-secondary mb-4">Baja permanente del programa académico</p>
                            <button id="bajaDefinitivaBtn" class="btn-admin-danger w-100">
                                <i class="fas fa-times me-2"></i>Solicitar Baja
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="data-card h-100">
                            <h5 class="data-header">Reactivación</h5>
                            <p class="text-secondary mb-4">Reincorporación al programa académico después de baja</p>
                            <button id="reactivacionBtn" class="btn-admin-success w-100" disabled>
                                <i class="fas fa-redo me-2"></i>Solicitar Reactivación
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals para opciones administrativas-->
    <div class="modal fade" id="temporal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas dar de baja temporal al alumno?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmBajaTemporal"></button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="definitiva" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="alert-card alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Esta acción no se puede deshacer.
                    </div>
                    ¿Estás seguro de que deseas dar de baja <strong>DEFINITIVA</strong> al alumno?<br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmBajaDefinitiva">Baja</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reactivacion" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas reactivar al alumno?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmReactivacion">Reactivar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para Baja Temporal -->
    <div class="modal fade" id="bajaTemporalModal" tabindex="-1" aria-labelledby="bajaTemporalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bajaTemporalModalLabel">Confirmar Baja Temporal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas solicitar una baja temporal?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-admin-warning">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para Baja Definitiva -->
    <div class="modal fade" id="bajaDefinitivaModal" tabindex="-1" aria-labelledby="bajaDefinitivaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bajaDefinitivaModalLabel">Confirmar Baja Definitiva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas solicitar una baja definitiva?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-admin-danger">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para Reactivación -->
    <div class="modal fade" id="reactivacionModal" tabindex="-1" aria-labelledby="reactivacionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reactivacionModalLabel">Confirmar Reactivación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas solicitar la reactivación?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-admin-success">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$codigo = "<script> document.getElementById('confirmBajaDefinitiva').value </script>";

?>

<script>
    $(document).ready(function() {
        $('#tipoPago').change(function() {
            if (this.value === 'colegiatura') {
                $('#colegiaturaFields').show();
                $('#cajaFields').hide();
            } else if (this.value === 'caja') {
                $('#colegiaturaFields').hide();
                $('#cajaFields').show();
            } else {
                $('#colegiaturaFields').hide();
                $('#cajaFields').hide();
            }
        });

        $('#concepto').change(function() {
            const monto = $(this).find(':selected').data('monto');
            $('#monto').val(monto);
        });

        function showNotification(message, type) {
            const notificationContainer = $('#notification-container');
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            const notification = $(`
                <div class="notification ${type}">
                    <i class="fas ${icon}"></i>
                    <span>${message}</span>
                </div>
            `);
            notificationContainer.append(notification);
            setTimeout(() => {
                notification.fadeOut(500, function() {
                    $(this).remove();
                });
            }, 2000);
        }


        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        if (status === 'success') {
            showNotification('Operación exitosa', 'success');
        } else if (status === 'error') {
            showNotification('Error en la operación', 'error');
        }

        // Habilitar o deshabilitar botones según el estado del alumno
        const estado = '<?php echo $estado; ?>';
        if (estado === 'activo') {
            $('#bajaTemporalBtn').prop('disabled', false);
            $('#bajaDefinitivaBtn').prop('disabled', false);
            $('#reactivacionBtn').prop('disabled', true);
        } else if (estado === 'baja_temporal') {
            $('#bajaTemporalBtn').prop('disabled', true);
            $('#bajaDefinitivaBtn').prop('disabled', true);
            $('#reactivacionBtn').prop('disabled', false);
        } else if (estado === 'baja_definitiva') {
            $('#bajaTemporalBtn').prop('disabled', true);
            $('#bajaDefinitivaBtn').prop('disabled', true);
            $('#reactivacionBtn').prop('disabled', true);
        }

        $('#bajaTemporalBtn').click(function() {
            $('#temporal').modal('show');
        });

        $('#bajaDefinitivaBtn').click(function() {
            $('#definitiva').modal('show');
        });

        $('#reactivacionBtn').click(function() {
            $('#reactivacion').modal('show');
        });


        $('#confirmBajaDefinitiva').click(function() {
            $.post('baja_definitiva.php', {
                id_alumno: '<?php echo $id_alumno; ?>'
            }, function(response) {
                if (response.status === 'success') {
                    showNotification('Baja definitiva realizada con éxito', 'success');
                } else {
                    showNotification('Error al solicitar baja definitiva', 'error');
                }
                setTimeout(function() {
                    location.reload();
                }, 2000);
                $('#definitiva').modal('hide');
            }, 'json');
        });

        $('#confirmBajaTemporal').click(function() {
            $.post('baja_temporal.php', {
                id_alumno: '<?php echo $id_alumno; ?>'
            }, function(response) {
                if (response.status === 'success') {
                    showNotification('Baja temporal realizada con éxito', 'success');
                } else {
                    showNotification('Error al solicitar baja definitiva', 'error');
                }
                setTimeout(function() {
                    location.reload();
                }, 2000);
                
                $('#temporal').modal('hide');
            }, 'json');
        });

        $('#confirmReactivacion').click(function() {
            $.post('reactivacion.php', {
                id_alumno: '<?php echo $id_alumno; ?>'
            }, function(response) {
                if (response.status === 'success') {
                    showNotification('Reactivación realizada con éxito', 'success');
                } else {
                    showNotification('Error al solicitar reactivación', 'error');
                }
                setTimeout(function() {
                    location.reload();
                }, 2000);
                $('#reactivacion').modal('hide');
            }, 'json');
        });


        $('#ImprimirSolicitud').click(function solicitud(){
            window.open('../../Modules/Inscribir/solicitudLlenado.php?id_alumno=<?php echo $id_alumno; ?>', '_blank');
        });

    });
</script>